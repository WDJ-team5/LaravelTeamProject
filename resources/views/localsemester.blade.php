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
						ls_box.innerHTML ='<div class="ls-imgbox" name="'+value.id+'"><div class="ls-hover"><div class="ls-hover-content"><i class="fas fa-plus fa-3x"></i></div></div><div class="ls-image" name="'+value.id+'" value="'+value.id+'"><img class="ls-box-image" src='+imgPath+' alt='+value.id+'/></div></div>\
						<div class="space"></div><h3 class="ls-title">'+value.title+'</h3>\
						<h6 class="ls-name">'+value.user.name+'</h6><div class="space"></div>\
						<button class="button-edit btn btn-secondary btn-sm" name="'+value.id+'">수정</button>\
						<button class="button-delete btn btn-secondary btn-sm" name="'+value.id+'">삭제</button>';
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
				$('#hidden_method').html('');
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
				$('#ls-form').prepend('<input type="hidden" id="httpMethod" name="_method" value="PUT">');
				var id = $('#ls-modal-id').val();
				$.ajax({
					url:"/localsemesters/"+id,
					method:"POST",
					enctype: 'multipart/form-data',
					data:new FormData(this),
					dataType:'JSON',
					contentType: false,
					cache: false,
					processData: false,
					success:function(data){
						$('#httpMethod').remove();
						$('#ls-form').trigger("reset");
						$('#ls-modal-create-container').modal('hide');
						koko();
					}
				});
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
			if(confirm("정말 삭제하시겠습니까?")){
				$.ajax({
					type: 'DELETE',
					url: '/localsemesters/' + id,
				}).then(function(){
					koko();
				});
			}
		});

		$(document).on('click', '.ls-imgbox', function(e){
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
					}
					$('.ls-box-image2').attr('src', imgPath);
						
				},
			});
		})
		
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
	body {
			background-color:#f7f7f7;
		}

	.head h1 {
			margin : 5% 0 1% 0;
			font-weight:bold;
			font-size:2.3rem;
			text-align:center;
		}
	.head h6 {
			margin : 0 0 5% 0;
			text-align:center;
			color:#807e7e;
		}
	.head button { 
			margin: -20px -50px; 
			position:relative;
			top:50%; 
			left:50%;
			margin-bottom:3%;
		}
	button {
			margin: 0 1% 5% 1%;
		}
    #ls-container {
            width: 100%;
        }
    .ls-box {
			background-color:white;
			display:inline-block;
			width:30%;
			height: 45%;
			margin : 0 1.5% 6% 1.5%;
			text-align: center;
        }
	.ls-box .space{
			margin-top:10%;
        }
    .ls-image {
            /* border: solid black 1px; */
            width: 100%;
            height: 25vh;
            color: green;
        }
	.ls-imgbox {
			position: relative;
			display: block;
			margin: 0 auto;
			cursor: pointer;
		}
	.ls-hover-content {
			position: absolute;
			width: 100%;
			height: 25vh;
			transition: all ease 0.5s;
			opacity: 0;
			background: #326ba8;
			text-align: center;
  			color: white;
		}
	.ls-hover-content:hover {
			opacity: 0.9;
		}
	.ls-hover-content i {
			line-height: 25vh;
		}

	.ls-title { 
			font-weight:bold;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
	.ls-name {
			margin-top:3%;
			overflow: hidden;
			text-overflow: ellipsis;
			white-space: nowrap;
		}
	.create-div {
		border: solid black 1px;
		width: 50px;
		height: 50px;
	}
	.ls-box-image {
		width: 100%;
		height: 100%;
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
    <div class="head">
		<h1>후쿠오카 현지학기제</h1>
		<h6>2019.08.03 - 2019.09.11</h6>
		<button id='button-write' class="btn btn-primary btn-sm">새 글 작성</button>
	</div>
	<hr/>
	<div id="ls-container"></div>
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
				<h4 class="modal-title" id="modelHeading"></h4>
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