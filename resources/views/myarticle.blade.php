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
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'content', name: 'content'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });
		  
		  
		  
	$('body').on('click', '.editArticle', function () {
		  var article_id = $(this).data('id');
		  $.get("{{ route('myarticles.index') }}" +'/' + article_id +'/edit', function (data) {
			  $('#modelHeading').html("Edit Article");
			  $('#saveBtn').val("edit-article");
			  $('#ajaxModel').modal('show');
			  $('#article_id').val(data.id);
			  $('#title').val(data.title);
			  $('#content').val(data.content);
		  })
	   });
	
		  
	$('#saveBtn').click(function (e) {
        e.preventDefault();
        $(this).html('Save');
    
        $.ajax({
          data: $('#articleForm').serialize(),
          url: "{{ route('myarticles.store') }}",
          type: "POST",
          dataType: 'json',
          success: function (data) {
     
              $('#articleForm').trigger("reset");
              $('#ajaxModel').modal('hide');
              table.draw();
         
          },

          error: function (data) {
              console.log('Error:', data);
              $('#saveBtn').html('저장실패');
          }
      });
    });
		  
		  
	$('body').on('click', '.deleteArticle', function () {
     
        var article_id = $(this).data("id");
        confirm("삭제하시겠습니까?");
      
        $.ajax({
            type: "DELETE",
            url: "{{ route('myarticles.store') }}"+'/'+article_id,
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


<head>
    <title>Laravel 6 Crud operation using ajax(Real Programmer)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>



<body>
	<div class="container">
		<div class="row justify-content-center">
			<div class="col-md-8">


				 <div class="container">	
					<h1>내 활동 조회</h1>
					<table class="table table-bordered data-table">
						<thead>
							<tr>
								<th>No</th>
								<th>Title</th>
								<th>Content</th>
								<th width="300px">Action</th>
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
							</div>

							<div class="modal-body">
								<form id="articleForm" name="articleForm" class="form-horizontal">
								   <input type="hidden" name="article_id" id="article_id">

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


								<form action="{{route('myarticles.store')}}" method="POST" enctype="multipart/form-data" class="form__article">
									<!-- 파일첨부 폼 -->
									<div class="form-group {{$errors->has('files')?'has-error':''}}">
										<label for="files">파일</label>
										<input type="file" name="files[]" id="files" class="form-control" multiple="multiple"/>
										{!! $errors->first('files.0', '<span class="form-error">:message</span>') !!}
									</div>
								</form>

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


<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">

            여기다 ㄱㄱ~
        </div>
    </div>
</div>
@endsection

