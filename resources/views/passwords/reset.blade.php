@extends('layouts.app')

@section('script')

@endsection

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			
			<div class="page-header">
				<h4>비밀번호 바꾸기</h4>
				<p class="text-muted">회원가입했던 이메일을 입력하고, 새로운 비밀번호를 입력하세요.</p>
			</div>
			
			<form action="{{ route('reset.store') }}" method="POST">
				@csrf

				<input type="hidden" name="token" value="{{ $token }}">

				<div class="form-group">
				  <input type="email" name="email" class="form-control" placeholder="이메일*" required>
				</div>

				<div class="form-group">
				  <input type="password" name="password" class="form-control" placeholder="새로운 비밀번호*">
				</div>

				<div class="form-group">
				  <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호 확인*">
				</div>

				<button class="btn btn-primary btn-block btn-block" type="submit">비밀번호 바꾸기</button>
			</form>
        </div>
    </div>
</div>
@endsection