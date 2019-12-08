<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;

class UsersController extends Controller
{
	public function __construct()
    {
        $this->middleware('guest', ['except' => ['show','edit','update']]);
    }
	
    public function create()
    {
        return view('users.create');
    }
	
	public function store(\App\Http\Requests\UsersRequest $request)
    {
		 $file = $request->file("file");
		 $filename = Str::random(15).filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);
		 $file->move(public_path('files/'),$filename);

		
        $confirmCode = \Str::random(60);
        $birthday = $request->input('year').'-'.$request->input('month').'-'.$request->input('day');

        $user = \App\User::create([
            'email' => $request->input('email'),
            'password' => bcrypt($request->input('password')),
            'name' => $request->input('name'),
            'birth' => $birthday,
            'gender' => $request->input('gender'),
            'confirm_code' => $confirmCode,
			'img' =>$filename,
        ]);
        
        event(new \App\Events\UserCreated($user));

        return $this->respondCreated('관리자가 회원가입 검토 후 메일로 발송해드립니다. 최대 1시간 소요 됩니다.');
    }

    protected function respondCreated($message)
    {
        flash($message);
        return redirect('/');
    }

    public function confirm($code)
    {
        $user = \App\User::whereConfirmCode($code)->first();

        if(!$user) {
            flash('URL이 정확하지 않거나 만료되었습니다잉!');

            return redirect('/');
        }

        $user->activated = 1;
        $user->confirm_code = null;
        $user->save();

        auth()->login($user);
        flash(auth()->user()->name.'님, 환영합니다. 가입이 확인되었습니다.');

        return redirect('/');
    }
	
	public function show()
	{
		$user = auth()->user();
		return response()->json($user); 
	}
	
	public function edit($id)
	{
		return view('users.create', [
			'id' => $id,
		]);
	}
	
	public function update(Request $request, $id)
	{
		
		
		
		$user = \App\User::find($id);
		$image = $user->img;
		
		if($image !== null) {
			\File::delete(public_path('files/') . $image);
		}
		
		$file = $request->file("file");
		$filename = Str::random(15).filter_var($file->getClientOriginalName(),FILTER_SANITIZE_URL);
		$file->move(public_path('files/'),$filename);

		
		
		$birthday = $request->input('year').'-'.$request->input('month').'-'.$request->input('day');
		
		\App\User::find($id)->update([
            'password' => bcrypt($request->input('password')),
            'name' => $request->input('name'),
            'birth' => $birthday,
            'gender' => $request->input('gender'),
			'img' => $filename,
        ]);
		
		return redirect('/');
	}
	
}
