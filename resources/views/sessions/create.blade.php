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
                <h2 class="section-heading text-uppercase">{{ __('Login') }}</h2>
                <h3 class="section-subheading text-muted">大盛り(5조)</h3>
            </div>
            <form action="{{ route('sessions.store') }}" method="POST">
                @csrf
                <div class="form-group">
                    <input type="email" id="email" name="email" class="form-control" placeholder="아이디 입력" required>
                </div>
                <div class="form-group">
                    <input type="password" id="password" name="password" class="form-control" placeholder="비밀번호 입력" required>
                </div>
                <div class="form-group">
                    <button class="btn btn-primary btn-block text-uppercase" type="submit">로 그 인</button>
                </div>
            </form>
            <!-- 찾기 메뉴 -->
            <div class="py-4 text-center">
                <a href="#">아이디 찾기</a>
                <span>&nbsp;|&nbsp;</span>
                <a href="{{ route('remind.create') }}">비밀번호 찾기</a>
                <span>&nbsp;|&nbsp;</span>
                <a href="{{ route('users.create') }}">회원가입</a>
            </div>
        </div>
    </div>
</div>
@endsection