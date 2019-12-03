@extends('layouts.app')

@section('script')
<script type="text/javascript">
	
	$(function () {
		
		/* CSRF 상태 토큰 */
		$.ajaxSetup({
			headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
		}});

		/* table ajax index */
		var table = $('.data-table').DataTable({
			processing: true,
			serverSide: true,
			ajax: "{{ route('qnas.index') }}",
			columns: [
				{data: 'id', name: 'id', orderable: false},
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


		/* table ajax edit */
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

		/* table ajax create & update */
		$('#saveBtn').click(function (e) {
			e.preventDefault();
			
			if($('#saveBtn').text() == 'Save') {
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


		/* table ajax delete */
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

		/* table ajax show */
		$('body').on('click', '.showQnA', function () {
			var QnA_id = $(this).data('id');
			$.get("{{ route('qnas.index') }}" +'/' + QnA_id, function (data) {
				$('#modelHeading2').html("글 읽는 즁");
				$('#ajaxModel02').modal('show');
				$('#QnA_id2').val(data.id);
				$('#title2').text(data.title);
				$('#content2').text(data.content);
			})
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

@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-12">
			<div class="text-center">
                <h2 class="section-heading text-uppercase">Q&#38;A</h2>
                <h3 class="section-subheading text-muted">大盛り(5조)</h3>
            </div>
			
			<a class="btn btn-success" href="javascript:void(0)" id="createNewQnA"> 새 글 쓰기</a>

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
<div class="modal fade" id="ajaxModel01" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">
			
			<div class="modal-header">
				<h4 class="modal-title" id="modelHeading"></h4>
				<div>
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
							<textarea id="content" name="content" required="" placeholder="Enter Content" class="form-control"></textarea>
						</div>
					</div>

					<!-- 게시글 저장&수정버튼 -->
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-primary" id="saveBtn" value="create">저장하기</button>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
<!-- Show modal -->
<div class="modal fade" id="ajaxModel02" aria-hidden="true">
	<div class="modal-dialog">
		<div class="modal-content">

			<div class="modal-header">
				<h4 class="modal-title" id="modelHeading2"></h4>
				<div>
					<i class="fas fa-times fa-3x"></i>
				</div>
			</div>

			<div class="modal-body">
				<form id="QnAForm" name="QnAForm" class="form-horizontal">
					<input type="hidden" name="QnA_id" id="QnA_id2">

					<!-- 제목 -->
					<div class="form-group">
						<h1 id="title2"></h1>
					</div>

					<!-- 본문 -->
					<div class="form-group">
						<p id="content2"></p>
					</div>
				</form>
			</div>
			
		</div>
	</div>
</div>
@endsection 

