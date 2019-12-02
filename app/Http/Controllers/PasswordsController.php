<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PasswordsController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function getRmind()
    {
        return view('passwords.remind');
    }

    public function postRmind(Request $request)
    {
		$this->validate($request, [ ]);

        $email = $request->get('email');
		$token = \Str::random(64);
		
		
		\DB::table('password_resets')->insert([
			'email' => $email,
			'token' => $token,
			'created_at' => \Carbon\Carbon::now()->toDateTimeString(),
		]);
		
		event(new \App\Events\PasswordRemindCreated($email, $token));
		
		flash('관리자가 요청 검토 후 비밀번호를 바꾸는 방법을 담은 이메일을 발송해 드리겠습니다. 최대 1시간 소요 됩니다.');
		
		return redirect('/');
    }
	
	public function getReset($token = null)
	{
		return view('passwords.reset', compact('token'));
	}
	
	public function postReset(\App\Http\Requests\PasswordsRequest $request)
    {
        $token = $request->get('token');

        if (! \DB::table('password_resets')->whereToken($token)->first()) {
            return $this->respondError('URL이 정확하지않거나 만료 되었습니다.');
        }

        \App\User::whereEmail($request->input('email'))->first()->update([
            'password' => bcrypt($request->input('password'))
        ]);

        \DB::table('password_resets')->whereToken($token)->delete();

        return $this->respondSuccess('비밀번호를 바꾸었습니다. 새로운 비밀번호로 로그인하세요.');
    }
	
	protected function respondError($message)
    {
        flash()->error($message);

        return back()->withInput();
    }
	
	protected function respondSuccess($message)
    {
        flash($message);

        return redirect('/');
    }
}
