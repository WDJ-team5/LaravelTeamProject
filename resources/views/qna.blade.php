@extends('layouts.app')

@section('script')
<script type="text/javascript">
	
	$(function () {
		
		/* CSRF 상태 토큰 */
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}});

		/* aticle ajax index */
		var table = $('.data-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('qnas.index') }}",
			columns: [
				{data: 'id', name: 'id'},
				{data: 'title', name: 'title'},
				{data: 'name', name: 'name'},
				{data: 'created_at', name: 'created_at'},
				{data: 'action', name: 'action', orderable: false, searchable: false},
			]
		});

		/* 새 글 쓰기 버튼 클릭 시 */
		$('#createNewQnA').click(function () {
			$('#saveBtn').text("Save");
			$('#QnA_id').val('');
			$('#QnAForm').trigger("reset");
			$('#modelHeading').html("Create New QnA");
			$('#ajaxModel01').modal('show');
		});


		/* aticle ajax edit */
		$('body').on('click', '.editQnA', function () {
			$('#saveBtn').text("Update");
			var QnA_id = $(this).data('id');
			$.get("{{ route('qnas.index') }}" + '/' + QnA_id + '/edit', function (data) {
				$('#modelHeading').html("글 수정하기");
				$('#saveBtn').val("edit-QnA");
				$('#ajaxModel01').modal('show');
				$('#QnA_id').val(data.id);
				$('#title').val(data.title);
				$('#content').val(data.content);
			})
		});

		/* aticle ajax create & update */
		$('#saveBtn').click(function (e) {
			e.preventDefault();
			if($('#QnA_id').val() === "") {
				$(this).html('Saving...');
				$.ajax({
					data: $('#QnAForm').serialize(),
					url: "{{ route('qnas.store') }}",
					type: "POST",
					dataType: 'json',
					success: function (data) {
						$('#QnAForm').trigger("reset");
						$('#ajaxModel01').modal('hide');
						table.draw();
					},
					error: function (data) {
						console.log('Error:', data);
						$('#saveBtn').html('실패');
						$('#ajaxModel01').modal('hide');
					}
				});
			}else {
				var QnA_id = $('#QnA_id').val();
				$(this).html('Udating...');
				$.ajax({
					data: $('#QnAForm').serialize(),
					type: "PUT",
					url: "{{ route('qnas.store') }}"+'/'+QnA_id,
					dataType: 'json',
					success: function (data) {
						$('#QnAForm').trigger("reset");
						$('#ajaxModel01').modal('hide');
						table.draw();
					},
					error: function (data) {
						console.log('Error:', data);
						$('#saveBtn').html('실패');
					}
				});
			}
		});


		/* aticle ajax delete */
		$('body').on('click', '.deleteQnA', function () {
			var QnA_id = $(this).data("id");
			var result = confirm("삭제하시겠습니까?");	
			if(result) {
				$.ajax({
					type: "DELETE",
					url: "{{ route('qnas.store') }}"+'/'+QnA_id,
					success: function (data) {
						table.draw();
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			}   
		});

		/* aticle ajax show & comment ajax read */
		$('body').on('click', '.showQnA', function () {
			var QnA_id = $(this).data('id');
			$.get("{{ route('qnas.index') }}" +'/' + QnA_id, function (data) {
				$('#modelHeading2').text("Show QnA");
				$('#ajaxModel02').modal('show');
				$('#comment-container').empty();
				$('#article_id').val(data.id);
				$('#title2').text(data.title); 
				$('#content2').html(data.content);
				$('#comment-save-button').text("Save");
				callComments(QnA_id);
			})
		});
		
	 	function callComments(article_id) {
			$(function() {
				$.get("{{ route('comments.index') }}" +'/' + article_id, function (data) {
					$('#comment-save-button').text("Save");
					$('#comment-container').empty();
					Array.from(data).forEach((value)=>{
						$('#comment-container').append('<div class="card-header"><pre class="comment-content'+value.id+'">'+value.content+'</pre><button data-id='+value.id+' class="btn btn-success btn-sm editComment">edit</button>&nbsp;<button data-id='+value.id+' class="btn btn-danger btn-sm deleteComment">delete</button></div>');
					});
				})
			});
		}
		
		/* comment ajax create */
		$('#comment-save-button').click(function (e) {
			e.preventDefault();
			$(this).html('Saving...');
			$.ajax({
				data: $('#CommentForm').serialize(),
				url: "{{ route('comments.store') }}",
				type: "POST",
				dataType: 'json',
				success: function (data) {
					$('#CommentForm').trigger("reset");
					$('#commentContent').val("");
					callComments(data.article_id);
				},
				error: function (data) {
					console.log('Error:', data);
					$('#comment-save-button').html('실패');
				}
			});
		});
		
		/* comment ajax update */
		$('body').on('click', '.editComment', function () {
			var id = $(this).data('id');
			var result = prompt('댓글을 수정하세욤.');
			$.ajax({
				type: "patch",
				url: "{{ route('comments.store') }}"+'/'+id,
				data: { 'content':result},
				success: function (data) {
					console.log($(this).parent().children('pre'));
					$(this).parent().children('pre').val(result);
					
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
			if(result.trim() !== "") {
				console.log('수정함');
			}
			
		});

		/* comment ajax delete */
		$('body').on('click', '.deleteComment', function () {
			var id = $(this).data("id");
			var artcle_id = $('#article_id').val();
			var result = confirm("삭제하시겠습니까?");	
			if(result) {
				$.ajax({
					type: "DELETE",
					url: "{{ route('comments.store') }}"+'/'+id,
					success: function (data) {
						callComments(artcle_id);
					},
					error: function (data) {
						console.log('Error:', data);
					}
				});
			}   
		});
		
		/* etc */
		$('.fa-times').click(function() {
			$('#ajaxModel01').modal('hide');
			$('#ajaxModel02').modal('hide');
		});

	});
</script>
@endsection

@section('style')
<style>
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
.py-4 {
	width: 100%;
}
pre {
	width: 96%;
	white-space: pre-wrap;
}
</style>
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<div class="text-center">
                <h2 class="section-heading text-uppercase">Q&#38;A</h2>
                <h3 class="section-subheading text-muted">大盛り(5조)</h3>
            </div>
			@can('create')
				<a class="btn btn-success" href="javascript:void(0)" id="createNewQnA">글쓰기</a>
			@endcan
			<div class="py-4">
				<table class="table table-bordered data-table">
					<colgroup>
						<col width='5%'/>
          				<col width='*%'/>
						<col width='8%'/>
						<col width='10%'/>
          				<col width='20%'/>
					</colgroup>
					<thead>
						<tr>
							<th>No</th>
							<th>Title</th>
							<th>name</th>
							<th>created_at</th>
							<th width="200px">Action</th>
						</tr>
					</thead>
					<tbody>
					</tbody>
				</table>
			</div>
			
        </div>
    </div>
</div>
<!-- Create&Edit modal -->
<div class="modal fade portfolio-modal" id="ajaxModel01" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="modelHeading"></h4>
				<div class="close-modal">
					<i class="fas fa-times fa-3x"></i>
				</div>
			</div>

			<div class="modal-body">
				<form id="QnAForm" name="QnAForm" class="form-horizontal">
					
					<input type="hidden" name="QnA_id" id="QnA_id">

					<!-- 제목 폼 -->
					<div class="form-group">
						<label for="name" class="col-sm-2 control-label">제목</label>
						<div class="col-sm-12">
							<input type="text" class="form-control" id="title" name="title" placeholder="Enter Title" value="" maxlength="50" required="">
						</div>
					</div>

					<!-- 본문 폼 -->
					<div class="form-group">
						<label class="col-sm-2 control-label">본문</label>
						<div class="col-sm-12">
							<textarea id="content" name="content" required="" placeholder="Enter Content" class="form-control" rows="20"></textarea>
						</div>
					</div>

					<!-- 게시글 저장&수정버튼 -->
					<div class="">
						<button type="submit" class="btn btn-block btn-primary" id="saveBtn" value="create">저장하기</button>
					</div>
					
				</form>
			</div>
			
		</div>
	</div>
</div>
<!-- Show modal -->
<div class="modal fade portfolio-modal" id="ajaxModel02" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" id="modelHeading2"></h4>
				<div class="close-modal">
				<i class="fas fa-times fa-3x"></i>
				</div>
			</div>

			<div class="modal-body">

				<!-- 제목 -->
				<h1 id="title2"></h1>
			
				<!-- 본문 -->
				<pre id="content2"></pre>

				<div class="py-4">댓 글
					<div id="comment-container" class="card">

					</div>
				</div>
				<!-- 댓글 폼 -->
				<form id="CommentForm" name="CommentForm" class="form-horizontal">
					
					<input type="hidden" name="article_id" id="article_id">

					<textarea id="content" name="content" required="" placeholder="Enter Content" class="form-control kokoa" rows="4"></textarea>
					
					<button type="submit" class="btn btn-block btn-primary" id="comment-save-button" value="create">저장하기</button>

				</form>
			</div>
			
		</div>
	</div>
</div>
@endsection 

