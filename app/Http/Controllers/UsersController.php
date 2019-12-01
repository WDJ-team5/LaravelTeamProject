<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Http\Requests\UsersRequest;
use \App\Events\UserCreated;


class UsersController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UsersRequest $request)
    {
        $confirmCode = \Str::random(60);
        $year = $request->input('year'); 
        $month = $request->input('month'); 
        $day = $request->input('day'); 

        $user = \App\User::create([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'name' => $request->input('name'),
            'profile_img' => $request->input('profile_img'),
            'birth' => ($year."-".$month."-".$day),
            'gender' => $request->input('gender'),
            'hint' => $request->input('hint'),
            'hint_ans' => $request->input('hint_ans'),
            'confirm_code' => $confirmCode,
        ]);



            event(new \App\Events\UserCreated($user));

            flash('가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입확인 하시고 로그인해 주세요.');

            return redirect('/');
        
        // event(new UserCreated($user));

        // return $this->respondCreated('가입하신 메일 계정으로 가입 확인 메일을 보내드렸습니다. 가입확인 하시고 로그인해 주세요.');
    }

    // protected function respondCreated($message)
    // {
    //     flash($message);
    //     return redirect('/');
    // }

    public function confirm($code)
    {
        $user = \App\User::whereConfirmCode($code)->first();

        if(!$user) {
            flash('URL이 정확하지 않거나 만료되었습니다.ㅇ0ㅇ!');

            return redirect('/');
        }

        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);
        flash(auth()->user()->name.'님, 환영합니다. 가입 확인되었습니다.');

        return redirect('/');
    }
}
