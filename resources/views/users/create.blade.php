@extends('layouts.app')

@section('script')
<script>
	window.onload = function(){

		var date = new Date();
		var year = date.getFullYear();
		var selectYear = document.getElementById("year");
		var selectMonth = document.getElementById("month"); 
		var selectDay = document.getElementById("day");


		for(var i=year-100;i<=year;i++){
				selectYear.add(new Option(i+"년"));  
		}

		for(var i=1;i<=12;i++){
				selectMonth.add(new Option(i+"월"));
		}

		for(var i=1;i<=31;i++){
				selectDay.add(new Option(i+"일"));
		}

		var id = $('#email').attr('name');
		if(id != 'email'){
			fetch('/auth/register/'+id,{
				method: "GET",
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
			}})
			.then(e => e.json())
			.then(data => {
				$('#email').text(data.email);
				$('#name').val(data.name);
				var birth = data.birth.split('-');
				var year = birth[0];
				var month = birth[1];
				var day = birth[2];
				$('#year').val(year).attr('selected','selected');
				$('#month').val(month).attr('selected','selected');
				$('#day').val(day).attr('selected','selected');
				$('#gender').val(data.gender).attr('selected','selected');
				var imgPath = '';
				if(data.img){
					imgPath = "http://"+document.location.hostname+"/files/"+data.img;
				}
				$('#holder').attr('src', imgPath);
			});
		}
		
		
		$('#img-input').change(function(){
			var input = this;
			var url = $(this).val();
			var ext = url.substring(url.lastIndexOf('.') + 1).toLowerCase();
			if (input.files && input.files[0]&& (ext == "gif" || ext == "png" || ext == "jpeg" || ext == "jpg")) 
			 {
				var reader = new FileReader();

				reader.onload = function (e) {
				   	$('#holder').attr('src', e.target.result);
				}
			   reader.readAsDataURL(input.files[0]);
			}
			else
			{
			  $('#img').attr('src', '/assets/no_preview.png');
			}
		});
	}
</script>
@endsection

@section('style')
<style>
.birth {
    float: left;
    width: 32%;
    margin-bottom: 30px;
}
#holder {
	width: 300px;
	height: 300px;
	border-radius:50%;
	background:#00d3d3;
	border: 6px solid #fff;
	box-shadow: 0 0 16px rgb(221,221,221);
}
#year{
    margin-right: 2%;     
}

#month{
    margin-right: 2%;        
}   
.filebox label {
	display: inline-block; 
	padding: .5em .75em;
	color: #fff;; 
	font-size: inherit; 
	line-height: normal; 
	vertical-align: middle;
	background-color: #337ab7; 
	cursor: pointer; 
	border: 1px solid #2e6da4;
	border-bottom-color: #e2e2e2;
	border-radius: .25em; 
} 
.filebox input[type="file"] { /* 파일 필드 숨기기 */ 
	position: absolute; 
	width: 1px;
	height: 1px; 
	padding: 0; 
	margin: -1px;
	overflow: hidden;
	clip:rect(0,0,0,0); 
	border: 0; 
}

</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">	
            <div class="text-center">
                <h2 class="">{{ __('Register') }}</h2>
                <h3 class="">Please edit your membership information.</h3>
            </div>
			@guest
            <form action="{{ route('users.store') }}" method="POST" enctype="multipart/form-data" >
			@else
			<form action="/auth/register/{{$id}}}" method="POST" enctype="multipart/form-data" >
				@method('patch')
			@endguest
				@csrf
                <div class="form-group text-center">
                	<img class="rounded-circle" id="holder" alt="d" src="{{ asset('files/oomori.png') }}">
                </div>
				<div class="filebox text-center">
					<label for="img-input">업로드</label> 
					<input type="file" id="img-input" name="file"> 
				</div>
                <div class="form-group">
					@guest
                    <input type="email" id="email" name="email" class="form-control" placeholder="이메일 *" required>
					@else
					<p id="email" name="{{ $id }}" class="form-control"></p>
					@endguest
				</div>
				
                <div class="form-group">
                    <input type="password" name="password" class="form-control" placeholder="비밀번호 *" required>
                </div>
				
                <div class="form-group">
                    <input type="password" name="password_confirmation" class="form-control" placeholder="비밀번호 확인 *" required>
                </div>
				
                <div class="form-group">
                    <input type="text" id="name" name="name" class="form-control" placeholder="이름 *" required>
                </div>
				
                <div class="form-group birth-group">
                    <select id="year" name="year" class="form-control birth" required>
                        <option value="">년(4자)*</option>
                    </select>
                    <select id="month" name="month" class="form-control birth" required>
                        <option value="">월*</option>
                    </select>
                    <select id="day" name="day" class="form-control birth" required>
                        <option value="">일*</option>
                    </select>
                </div>
				
                <div class="form-group">
                    <select name="gender" id="gender" class="form-control" required>
                        <option value="">성별*</option>
                        <option value="woman">여</option>
                        <option value="men">남</option>
                    </select>
                </div>

				
                <div class="form-group">
					@guest
                    	<button class="btn btn-primary btn-block text-uppercase" type="submit">가 입 하 기</button>
					@else
                    	<button class="btn btn-primary btn-block text-uppercase" type="submit">수 정 완 료</button>
					@endguest
                </div>
            </form>
		</div>
    </div>
</div>
@endsection