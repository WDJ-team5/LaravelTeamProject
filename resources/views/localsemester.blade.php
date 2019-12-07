@extends('layouts.app')

@section('script')
<script>
	$(function() {
		var create_tf = false;
		var show_tf = false;
		
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN':$('meta[name="csrf-token"]').attr('content')
			}});
		
		function koko() {
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
					$('#ls-container').empty();
					Array.from(data).forEach((value)=>{
						var ls_box = document.createElement('div');
						if(value.file){
							var imgPath = "http://"+document.location.hostname+"/files/"+value.file;
						} else{
							var imgPath = "http://placehold.it/320x100?text=sample";
						}
						ls_box.className = 'ls-box';
						ls_box.innerHTML = '<div>작성자 : '+value.user.name+'</div>\<div>제목 : '+value.title+'</div>\<div class="ls-image" name='+value.id+' value='+value.id+'><img class="ls-box-image" src='+imgPath+' alt='+value.id+'/></div>\<button class="button-edit" name='+value.id+'>수정</button>\<button class="button-delete" name='+value.id+'>삭제</button>';
						ls_container.appendChild(ls_box);
					});
				})
			});
		}
		koko();

		$(document).on('click', '#button-write', function(e){
			e.preventDefault();
			$('#ls-modal-id').val("");
			$('#button-save').val("Save");
			$('#ls-form').trigger("reset");
			$('#ls-modal-create-container').modal('show');
		});
		
		$('#ls-form').on('submit', function(e) {
			e.preventDefault();
			if($('#ls-modal-id').val() === "") {
				$.ajax({
					url:"{{ route('localsemesters.store') }}",
					method:"POST",
					data:new FormData(this),
					dataType:'JSON',
					contentType: false,
					cache: false,
					processData: false,
					success:function(data){
						$('#ls-form').trigger("reset");
						$('#ls-modal-create-container').modal('hide');
						koko();
					}
				})
			}else {
				var id = $('#ls-modal-id').val();
				var data = $('#ls-form').serialize();
				var image = $('#ls-modal-file').val();
				data = data+'&file='+image
				$.ajax({
					url:"{{ route('localsemesters.store') }}"+'/'+id,
					method:"PUT",
					data: data,
					dataType:'JSON',
					//contentType: false,
					cache: false,
					processData: false,
					success:function(data){
						console.log(data)
						$('#ls-form').trigger("reset");
						$('#ls-modal-create-container').modal('hide');
						koko();
					}
				})
				
			}
			
		});

		$(document).on('click', '.button-edit', function(e){
			e.preventDefault();
			var id = $(this).attr('name');
			$.ajax({
				url: "{{ route('localsemesters.index') }}"+"/"+id+"/edit",
				type: 'GET',
				datatype: 'json',
				success: function (data) {
					$('#button-save').val("Update");
					$('#ls-form').trigger("reset");
					$('#ls-modal-create-container').modal('show');
					$('#ls-modal-id').val(data.id);
					$('#ls-modal-title').val(data.title);
					$('#ls-modal-content').val(data.content);
				},
			});
		})


		$(document).on('click', '.button-delete', function(e){
			var id = $(this).attr('name');
			console.log(id);
			if(confirm("엠창?")){
				$.ajax({
					type: 'DELETE',
					url: '/localsemesters/' + id,
				}).then(function(){
					koko();
				});
			}
		});

		$(document).on('click', '.ls-image', function(e){
			var id = $(this).attr('name');
			$.ajax({
				url:"{{ route('localsemesters.index') }}" +'/' + id,
				type: 'GET',
				datatype: 'json',
				success: function (data) {
					$('#ls-modal-show-container').trigger("reset");
					$('#ls-modal-show-container').modal('show');
					$('#ls-modal-title2').text(data.title);
					$('#ls-modal-content2').html(data.content);
					var imgPath = '';
					if(data.file) {
						imgPath = "http://"+document.location.hostname+"/files/"+data.file;
						// document.querySelector('.ls-box-image2').src = imgPath;
					}
					$('.ls-box-image2').attr('src', imgPath);
						
				},
			});
			
			// var QnA_id = $(this).data('id');
			// $.get("{{ route('qnas.index') }}" +'/' + QnA_id, function (data) {
			// 	$('#modelHeading2').text("Show QnA");
			// 	$('#ajaxModel02').modal('show');
			// 	$('#ls-modal-title2').text(data.title);
			// 	$('#ls-modal-content2').html(data.content);
			// 	if(data.file !== null) {
			// 		$('.ls-box-image2').attr('src',data.file);
			// 	}
			// })
			// var id = $(this).attr('name');
			// console.log(e.target.getAttribute('name'));
			// var ls_modal_container = document.getElementById('ls-modal-container');
			// var ls_modal_content = document.querySelector('.ls-modal-content');
			// var ls_modal_show = document.querySelector('.ls-modal-show');
			// var ls_modal_update = document.querySelector('.ls-modal-update');
			// var ls_modal_show_title = document.getElementById('ls-modal-show-title');
			// var ls_modal_show_name = document.getElementById('ls-modal-show-name');
			// var ls_modal_show_content = document.getElementById('ls-modal-show-content');
			// ls_modal_container.style.display = 'block';
			// ls_modal_show.style.display = 'block';
			// ls_modal_content.style.display = 'none';
			// ls_modal_update.style.display = 'none';
			// $.ajax({
			// 	type: 'GET',
			// 	url: '/localsemesters/' + id,
			// 	headers: {
			// 		"Content-Type" : "application/json",
			// 		"X-HTTP-Method-Override" : "POST"
			// 	},
			// }).then(function(data){
			// 	ls_modal_show_title.innerHTML = '제목 : ' + data[0].title;
			// 	ls_modal_show_name.innerHTML = '이름 : ' + data[0].user.name;
			// 	ls_modal_show_content.innerHTML = '내용 : ' + data[0].content;
			// })
		})

		// window.onclick = function(event) {
		// 	var ls_modal_container = document.getElementById('ls-modal-container');
		// 	if (event.target == ls_modal_container) {
		// 		// ls_modal_container.innerHTML="";
		// 		ls_modal_container.style.display = "none";
		// 	}
		// }
		
		/* etc */
		$('.fa-times').click(function() {
			$('#ls-modal-create-container').modal('hide');
			$('#ls-modal-show-container').modal('hide');
		});
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
	.ls-box-image {
		width: 100%;
		height: 100%;
	}
	.create-div {
		border: solid black 1px;
		width: 50px;
		height: 50px;
	}
	.ls-box-image2 {
		width: 100%;
	}
	.portfolio-modal .modal-dialog {
	  margin: 1rem;
	  max-width: 100vw;
	}

	.portfolio-modal .modal-content {
	  padding: 100px 0;
	  text-align: center;
	}

	.portfolio-modal .modal-content h2 {
	  font-size: 3em;
	  margin-bottom: 15px;
	}

	.portfolio-modal .modal-content p {
	  margin-bottom: 30px;
	}

	.portfolio-modal .modal-content p.item-intro {
	  font-size: 16px;
	  font-style: italic;
	  margin: 20px 0 30px;
	  font-family: 'Droid Serif', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
	}

	.portfolio-modal .modal-content ul.list-inline {
	  margin-top: 0;
	  margin-bottom: 30px;
	}

	.portfolio-modal .modal-content img {
	  margin-bottom: 30px;
	}

	.portfolio-modal .modal-content button {
	  cursor: pointer;
	}

	.portfolio-modal .close-modal {
	  position: absolute;
	  top: 25px;
	  right: 25px;
	  width: 75px;
	  height: 75px;
	  cursor: pointer;
	  background-color: transparent;
	}

	.portfolio-modal .close-modal:hover {
	  opacity: 0.3;
	}

	.portfolio-modal .close-modal .lr {
	  /* Safari and Chrome */
	  z-index: 1051;
	  width: 1px;
	  height: 75px;
	  margin-left: 35px;
	  /* IE 9 */
	  transform: rotate(45deg);
	  background-color: #212529;
	}

	.portfolio-modal .close-modal .lr .rl {
	  /* Safari and Chrome */
	  z-index: 1052;
	  width: 1px;
	  height: 75px;
	  /* IE 9 */
	  transform: rotate(90deg);
	  background-color: #212529;
	}
</style>
@stop

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<h1>후쿠오카 현지학기제</h1>
			<hr>
			<button id='button-write' class="btn btn-success">글쓰기</button>
			<div id='ls-container'>
    		</div>
        </div>
    </div>
</div>
<!-- model01 -->
<div class="modal fade" id="ls-modal-create-container" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="modelHeading">요호호</h4>
				<div class="close-modal">
					<i class="fas fa-times fa-3x"></i>
				</div>
			</div>

			<div class="modal-body">
				<form id="ls-form" name="ls-form" enctype="multipart/form-data">
					
					<input type="hidden" name="ls-modal-id" id="ls-modal-id">
					
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">제목</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="ls-modal-title" name="title" placeholder="Enter Title" required/>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">내용</label>
						<div class="col-sm-12">
							<textarea name="content" id="ls-modal-content" placeholder="Enter Content" class="form-control" rows="20" required></textarea>
						</div>
					</div>
					
					<div class="form-group">
						<label class="col-sm-2 control-label">파일</label>
						<div class="col-sm-12">
							<input type="file" name="file" id="ls-modal-file" class="form-control"/>
						</div>
					</div>
					
					<div class="">
						<input type="submit" value="으아 들이대" id="button-save" class="btn btn-block btn-primary" name="save" method="post"/>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
<!-- modal02 -->
<div class="modal fade portfolio-modal" id="ls-modal-show-container" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="modelHeading">유후후</h4>
				<div class="close-modal">
					<i class="fas fa-times fa-3x"></i>
				</div>
			</div>

			<div class="modal-body">
				<form id="ls-form" name="ls-form" enctype="multipart/form-data">
										
					<!-- 제목 -->
					<div class="form-group">
						<h1 id="ls-modal-title2"></h1>
					</div>
					
					<div class="form-group">
						<img class="ls-box-image2" src=""/>
					</div>

					<!-- 본문 -->
					<div class="form-group">
						<pre id="ls-modal-content2"></pre>
					</div>
					
				</form>
			</div>
			
		</div>
	</div>
</div>
@stop