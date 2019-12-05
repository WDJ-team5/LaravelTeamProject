@extends('layouts.app')

@section('script')

<script type="text/javascript">
	
	
	 $(function () {
		  
     $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    	}
    });
		  
	    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('myarticles.index') }}",
        columns: [
            {data: 'id', name: 'id', orderable: false},
            {data: 'title', name: 'title'},
            {data: 'content', name: 'content'},
			{data: 'name', name: 'name'},
			{data: 'created_at', name: 'created_at'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
      	]
   	});
		  
		  
	$('body').on('click', '.editMyArticle', function () {
		  $('#saveBtn').text("Update");
		  var myarticle_id = $(this).data('id');
		  $.get("{{ route('myarticles.index') }}" +'/' + myarticle_id +'/edit', function (data) {
			  $('#modelHeading').html("글 수정하기");
			  $('#saveBtn').val("edit-myarticle");
			  $('#ajaxModel').modal('show');
			  $('#myarticle_id').val(data.id);
			  $('#title').val(data.title);
			  $('#content').val(data.content);
		  })
	   });
	
		  
	$('#saveBtn').click(function (e) {
			e.preventDefault();
			
			if($('#saveBtn').text() == 'Save') {
				$(this).html('Saving...');
				$.ajax({
					data: $('#myarticleForm').serialize(),
					url: "{{ route('myarticles.store') }}",
					type: "POST",
					dataType: 'json',
					success: function (data) {
						$('#myarticleForm').trigger("reset");
						$('#ajaxModel').modal('hide');
						table.draw();
					},
					error: function (data) {
						console.log('Error:', data);
						$('#saveBtn').html('실패');
						$('#ajaxModel').modal('hide');
					}
				});
			}else {
				var myarticle_id = $('#myarticle_id').val();
				$(this).html('Updating...');
				$.ajax({
					data: $('#myarticleForm').serialize(),
					type: "PUT",
					url: "{{ route('myarticles.store') }}"+'/'+myarticle_id,
					dataType: 'json',
					success: function (data) {
						$('#myarticleForm').trigger("reset");
						$('#ajaxModel').modal('hide');
						table.draw();
					},
					error: function (data) {
						console.log('Error:', data);
						$('#saveBtn').html('실패');
					}
				});
			}	
		});
		  
		  
	$('body').on('click', '.deleteMyArticle', function () {
        var myarticle_id = $(this).data("id");
        confirm("삭제하시겠습니까?");
        $.ajax({
            type: "DELETE",
            url: "{{ route('myarticles.store') }}"+'/'+myarticle_id,
            success: function (data) {
                table.draw();
            },
            error: function (data) {
                console.log('Error:', data);
            }
        });
    });
  });
	

</script>

@endsection

@section('style')

@endsection

@section('content')

<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-11">
				 <div class="container">	
					<h1>내 활동 조회</h1>
					<table class="table table-bordered data-table">
						<colgroup>
							<col width='5%'/>
							<col width='20%'/>
							<col width='*%'/>
							<col width='10%'/>
							<col width='20%'/>
						</colgroup>
						<thead>
							<tr>
								<th>No</th>
								<th>Title</th>
								<th>Content</th>
								<th>name</th>
								<th>created_at</th>
								<th width="200px">Action</th>
							</tr>
						</thead>
						<tbody>
						</tbody>
					</table>
				</div>
				

				<div class="modal fade" id="ajaxModel" aria-hidden="true">
					<div class="modal-dialog">
						<div class="modal-content">
							
							<div class="modal-header">
								<h4 class="modal-title" id="modelHeading"></h4>
								<div>
									<i class="fas fa-times fa-3x"></i>
								</div>
							</div>
							
							<div class="modal-body">
								<form id="myarticleForm" name="myarticleForm" class="form-horizontal">
								   <input type="hidden" name="myarticle_id" id="myarticle_id">

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
											<textarea id="content" name="content" required="" placeholder="Enter content" class="form-control"></textarea>
										</div>
									</div>
									
									<!-- 게시글 저장버튼 -->
									<div class="col-sm-offset-2 col-sm-10">
									 <button type="submit" class="btn btn-primary" id="saveBtn" value="create">저장하기</button>
									</div>
									
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
</body>

@endsection

