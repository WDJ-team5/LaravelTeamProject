@extends('layouts.app')

@section('script')

@endsection

@section('style')

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
                <form action="{{ route('remind.store') }}" method="POST">
                    @csrf
                    <div class="text-center">
                        <h4 class="section-heading text-uppercase">{{ __('Remind') }}</h4>
                        <p class="section-subheading text-muted">plae</p>
                    </div>
                    <div class="form-group">
                    <input type="email" name="email" class="form-control" placeholder="회원 이메일 입력" value="{{ old('email') }}" required autofocus>
                    </div>
                    <button class="btn btn-primary btn-block btn-block" type="submit">확 인</button>
                </form>
        </div>
    </div>
</div>
@endsection