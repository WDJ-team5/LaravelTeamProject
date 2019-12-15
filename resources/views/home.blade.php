@extends('layouts.app')

@section('script')
    
@endsection

@section('style')
<style>
	
	body {
	  overflow:hidden;
	  height: 100%;
	  max-height: 100%;
	}
	
	.overlay {
	  position: fixed;
	  top: 0;
	  left: 0;
	  height: 100%;
	  width: 100%;
	  background-color: black;
	  opacity: 0.5;
	  z-index: -2;
	}

	video {
	  position: fixed;
	  top: 50%;
	  left: 50%;
	  min-width: 100%;
	  min-height: 100%;
	  width: 100wh;
	  transform: translateX(-50%) translateY(-50%);
	  z-index: -3;
	}
	
	.box {
		position:fixed;
		width: 100%; 
	    height: auto;
		max-height:100%;
		padding-left:3%;
		bottom: 10%;
	}
	
	h1 {
		color : white;
		font-size: 100px;
		font-weight:900;
		z-index: 0;
		padding-left:3%;
	}
	
	h6 {
		color : white;
		margin-left:5%;
		font-weight:bold;
		z-index: 0;
	}
	
	.footer {
		width: 100%;
		margin-top:50%;
		bottom: 0;
		position : fixed;
	}


	
</style>
@endsection

@section('content')
<div class="conta">
	<div class="overlay"></div>
	<video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
		<source src="mp4/bg2.mp4" type="video/mp4">
	</video>

	<div class="box">
		<div class="bottomleft">
			<h1>おおもり</h1>
			<h6>ヒョンホ、ヒゴン、ジュフン、ソンヒョン、スジンみんなの話</h6>
		</div>
	</div>
<div>
@endsection
