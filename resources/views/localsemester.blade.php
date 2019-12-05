@extends('layouts.app')

@section('script')
<script>
	$(function() {
		var create_tf = false;
		var show_tf = false;
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}});
		$(document).ready(function(e){
			$.ajax({
				type: 'GET',
				url: '/localsemesters/create',
				headers: {
					"Content-Type" : "application/json",
					"X-HTTP-Method-Override" : "POST"
				},
			}).then(data => {
				var ls_container = document.getElementById('ls-container');
				Array.from(data).forEach((value)=>{
					var ls_box = document.createElement('div');
					ls_box.className = 'ls-box';
					ls_box.innerHTML = '<div>작성자 : "'+value.user.name+'"</div>\<div>제목 : "'+value.title+'"</div>\<div class="ls-image" name="'+value.id+'" value="'+value.id+'" style.background="'+value.file+'">ls-image</div>\<button class="button-update" name="'+value.id+'">수정</button>\<button class="button-delete" name="'+value.id+'">삭제</button>';
					ls_container.appendChild(ls_box);
				});
			})
		});

		$(document).on('click', '#button-write', function(e){
			var ls_modal_container = document.getElementById('ls-modal-container');
			var ls_modal_content = document.querySelector('.ls-modal-content');
			var ls_modal_show = document.querySelector('.ls-modal-show');
			var ls_modal_update = document.querySelector('.ls-modal-update');
			ls_modal_container.style.display = 'block';
			ls_modal_content.style.display = 'block';
			ls_modal_show.style.display = 'none';
			ls_modal_update.style.display = 'none';
		});

		$(document).on('click', '#button-save', function(e){
			var title = document.getElementById('ls-modal-title').value;
			var content = document.getElementById('ls-modal-content').value;
			var filename = document.getElementById('ls-modal-file').files;
			console.log(filename[0].name);
			$.ajax({
				type: 'POST', 
				url: '/localsemesters',
				headers: {
				"Content-Type" : "application/json",
				"X-HTTP-Method-Override" : "POST"
				},
				data: JSON.stringify({
					'title': title,
					'content': content,
					'filename': filename[0].name,
				}),
				success : function(data) {
					console.log(data);
					var ls_container = document.getElementById('ls-container');
					Array.from(data).forEach((value)=>{
						var ls_box = document.createElement('div');
						ls_box.className = 'ls-box';
						ls_box.innerHTML = '<div>작성자 : "'+value.user.name+'"</div>\
						<div>제목 : "'+value.title+'"</div>\
						<div class="ls-image" name="'+value.id+'" value="'+value.id+'">ls-image</div>\
						<button class="button-update" name="'+value.id+'">수정</button>\
						<button class="button-delete" name="'+value.id+'">삭제</button>';
						ls_container.prepend(ls_box);
					});
				},
				error: function(err){
					console.log(err);
				}
			})
			document.getElementById('ls-modal-title').value = '';
			document.getElementById('ls-modal-content').value = '';
		})

		$(document).on('click', '.button-update', function(e){
            var id = $(this).attr('name');
            console.log(e.target.getAttribute('name'));
			var ls_modal_container = document.getElementById('ls-modal-container');
			var ls_modal_content = document.querySelector('.ls-modal-content');
			var ls_modal_show = document.querySelector('.ls-modal-show');
			var ls_modal_update = document.querySelector('.ls-modal-update');
			var ls_modal_update_title = document.getElementById('ls-modal-update-title');
			var ls_modal_update_content = document.getElementById('ls-modal-update-content');
			ls_modal_container.style.display = 'block';
			ls_modal_update.style.display = 'block';
			ls_modal_content.style.display = 'none';
			ls_modal_show.style.display = 'none';
			$.ajax({
				type: 'GET',
				url: '/localsemesters/' + id,
				headers: {
					"Content-Type" : "application/json",
					"X-HTTP-Method-Override" : "POST"
				},
			}).then(function(data){
				ls_modal_update_title.value = data[0].title;
				ls_modal_update_content.value = data[0].content;
				document.getElementById('ls-modal-update-button').setAttribute('name', id);
			})
		})

		$(document).on('click', '#ls-modal-update-button', function(e){
			var id = $(this).attr('name');
			console.log(e.target.getAttribute('name'));
			var title = document.getElementById('ls-modal-update-title').value;
			var content = document.getElementById('ls-modal-update-content').value;
			console.log(title);
			console.log(content);
			$.ajax({
				type: 'PATCH', 
				url: '/localsemesters/' + id,
				headers: {
				"Content-Type" : "application/json",
				"X-HTTP-Method-Override" : "PUT"
				},
				data: JSON.stringify({
					'title': title,
					'content': content,
				}),
			success: function(data){
				console.log(data);
				console.log('수정 완료 ㅎㅎ');
			},
			error: function(err){
				console.log(err);
			}
			})
			document.getElementById('ls-modal-update-title').value = '';
			document.getElementById('ls-modal-update-content').value = '';
			document.getElementById('ls-modal-container').style.display = "none";
		})

		$(document).on('click', '.button-delete', function(e){
			var id = $(this).attr('name');
			console.log(id);
			if(confirm("엠창?따블로가?")){
				$.ajax({
					type: 'DELETE',
					url: '/localsemesters/' + id,
					headers : { // Http header
					"Content-Type" : "application/json",
					"X-HTTP-Method-Override" : "POST"
					},
				}).then(function(){
					e.target.parentNode.parentNode.removeChild(e.target.parentNode);
				});
			}
		});

		$(document).on('click', '.ls-image', function(e){
			var id = $(this).attr('name');
			console.log(e.target.getAttribute('name'));
			var ls_modal_container = document.getElementById('ls-modal-container');
			var ls_modal_content = document.querySelector('.ls-modal-content');
			var ls_modal_show = document.querySelector('.ls-modal-show');
			var ls_modal_update = document.querySelector('.ls-modal-update');
			var ls_modal_show_title = document.getElementById('ls-modal-show-title');
			var ls_modal_show_name = document.getElementById('ls-modal-show-name');
			var ls_modal_show_content = document.getElementById('ls-modal-show-content');
			ls_modal_container.style.display = 'block';
			ls_modal_show.style.display = 'block';
			ls_modal_content.style.display = 'none';
			ls_modal_update.style.display = 'none';
			$.ajax({
				type: 'GET',
				url: '/localsemesters/' + id,
				headers: {
					"Content-Type" : "application/json",
					"X-HTTP-Method-Override" : "POST"
				},
			}).then(function(data){
				ls_modal_show_title.innerHTML = '제목 : ' + data[0].title;
				ls_modal_show_name.innerHTML = '이름 : ' + data[0].user.name;
				ls_modal_show_content.innerHTML = '내용 : ' + data[0].content;
			})
		})

		window.onclick = function(event) {
			var ls_modal_container = document.getElementById('ls-modal-container');
			if (event.target == ls_modal_container) {
				// ls_modal_container.innerHTML="";
				ls_modal_container.style.display = "none";
			}
		}
	});
</script>
@stop

@section('style')
    <style>
        #ls-container {
            width: 100%;
        }
        .ls-box {
            display: inline-block;
            border: solid black 1px;
            width: 31%;
            text-align: center;
            margin: 1%;
        }
        .ls-image {
            border: solid black 1px;
            width: 100%;
            height: 20vh;
            color: green;
        }
        .create-div {
            border: solid black 1px;
            width: 50px;
            height: 50px;
        }
        #ls-modal-container {
            display: none; /* Hidden by default */
            position: fixed; /* Stay in place */
            z-index: 1; /* Sit on top */
            left: 0;
            top: 0;
            width: 100%; /* Full width */
            height: 100%; /* Full height */
            overflow: auto; /* Enable scroll if needed */
            background-color: rgb(0,0,0); /* Fallback color */
            background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
        }
        .ls-modal-content {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 75%; /* Could be more or less, depending on screen size */
            display: none;
        }
        .ls-modal-show {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 75%; /* Could be more or less, depending on screen size */
            display: none;
        }
        #ls-modal-title {
            width: 90%;
        }
        #ls-modal-content {
            width: 90%;
        }
        #ls-modal-show-title {
            width: 90%;
        }
        #ls-modal-show-name {
            width: 90%;
        }
        #ls-modal-show-content {
            width: 90%;
        }
        .ls-modal-update {
            background-color: #fefefe;
            margin: 15% auto; /* 15% from the top and centered */
            padding: 20px;
            border: 1px solid #888;
            width: 75%; /* Could be more or less, depending on screen size */
            display: none;
        }
        #ls-modal-update-title {
            width: 90%;
        }
        #ls-modal-update-content {
            width: 90%;
        }
    </style>
@stop

@section('content')
<div class='container'>
    <h1>후쿠오카 현지학기제</h1>
    <hr>
    <button id='button-write'>작성</button>

    <div id='ls-modal-container'>

        <div class='ls-modal-content'>
		<!-- <form action="{{ route('localsemesters.store') }}" id="ls-form" name="ls-form" method="post">
			{!! csrf_field() !!} -->
			<label for="ls-modal-title">제목</label>
			<input type="text" id="ls-modal-title" name="title" placeholder="title" />
			<br>
			<label for="ls-modal-content">내용</label>
			<textarea name="content" id="ls-modal-content" placeholder="content" rows="8" ></textarea>
			<br>
			<label for="ls-modal-file">파일</label>
			<input type="file" name="file" id="ls-modal-file" class="form-control" multiple="multiple" />
			<br>
			<input type="button" value="save" id="button-save" name="save"/>
		<!-- </form> -->
        </div>

        <div class='ls-modal-show'>
            <div id='ls-modal-show-title'></div>
            <br>
            <div id='ls-modal-show-name'></div>
            <br>
            <div id='ls-modal-show-content'></div>
            <br>
			<div id='ls-modal-show-file'></div>
        </div>

        <div class='ls-modal-update'>
		<!-- <form action="{{ route('localsemesters.store') }}" id='ls-update-form' name='ls-update-form' method='put'>
			{!! csrf_field() !!} -->
			<label for="ls-modal-update-title">제목</label>
			<input type="text" id='ls-modal-update-title' name='title' placeholder='title' />
			<br>
			<label for="ls-modal-update-content">내용</label>
			<textarea name="content" id="ls-modal-update-content" placeholder="content" rows="8" ></textarea>
			<br>
			<label for="ls-modal-update-file">파일</label>
			<input type="file" name="file" id="ls-modal-update-file" class="form-control" multiple="multiple" />
			<br>
			<input type="button" value='update' id='ls-modal-update-button' />
		<!-- </form> -->
        </div>
    </div>
    <hr>

    <div id='ls-container'>
    </div>
</div>
@stop