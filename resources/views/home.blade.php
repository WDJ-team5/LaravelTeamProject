@extends('layouts.app')

@section('script')
    
@endsection

@section('style')

<style>
	
	body {
	  height: 100%;
	  min-height: 35rem;
	}
	
	.overlay {
	  position: fixed;
	  top: 7.5%;
	  left: 0;
	  height: 150%;
	  width: 100%;
	  background-color: black;
	  opacity: 0.5;
	  z-index: -1;
	}

	video {
	  position: fixed;
	  top: 50%;
	  left: 50%;
	  min-width: 100%;
	  min-height: 100%;
	  width: auto;
	  height: auto;
	  transform: translateX(-50%) translateY(-50%);
	  z-index: -2;
	}
	
	h1 {
		text-align : center;
		color : white;
		margin-top:430px;
		margin-right:60%;
		font-size: 100px;
		font-weight:900;
	}
	
	h6 {
		text-align : center;
		color : white;
		margin-right:58%;
		font-weight:bold;
	}


	
</style>
    
@endsection

@section('content')

<body>

 <div class="overlay"></div>
  <video playsinline="playsinline" autoplay="autoplay" muted="muted" loop="loop">
    <source src="mp4/bg2.mp4" type="video/mp4">
  </video>

	<div class="box">
		<h1>おおもり</h1>
		<h6>ヒョンホ、ヒゴン、ジュフン、ソンヒョン、スジンみんなの話</h6>
	</div>

</body>

@endsection
