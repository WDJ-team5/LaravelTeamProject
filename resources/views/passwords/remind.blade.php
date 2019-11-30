@extends('layouts.app')

@section('script')

@endsection

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			
			<div class="text-center">
				<h4 class="section-heading text-uppercase">비밀번호 찾기</h4>
				<p class="section-subheading text-muted">회원가입했던 이메일을 입력해주세요.</p>
			</div>

			<form action="{{ route('remind.store') }}" method="POST">
				@csrf

				<div class="form-group">
				<input type="email" name="email" class="form-control" placeholder="회원 이메일 입력*" required>
				</div>

				<button class="btn btn-primary btn-block btn-block" type="submit">확 인</button>
			</form>
        </div>
    </div>
</div>
@endsection