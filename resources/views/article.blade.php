<!DOCTYPE html>
<html>
<head>
    <title>Laravel 6 Crud operation using ajax(Real Programmer)</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.1.3/css/bootstrap.min.css" />
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.19/css/dataTables.bootstrap4.min.css" rel="stylesheet">
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.0/jquery.validate.js"></script>
    <script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.19/js/dataTables.bootstrap4.min.js"></script>  
</head>
<body>
    
<div class="container">
    <h1>5조 게시판</h1>
    <a class="btn btn-success" href="javascript:void(0)" id="createNewArticle"> 새 글 쓰기</a>
    <table class="table table-bordered data-table">
        <thead>
            <tr>
                <th>No</th>
                <th>Title</th>
                <th>content</th>
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

                    <!-- 게시글 저장버튼 -->
                    <div class="col-sm-offset-2 col-sm-10">
                     <button type="submit" class="btn btn-primary" id="saveBtn" value="create">저장하기</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
    
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
        ajax: "{{ route('articles.index') }}",
		columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'content', name: 'content'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
    });


    $('#createNewArticle').click(function () {
        $('#saveBtn').val("create-article");
        $('#article_id').val('');
        $('#articleForm').trigger("reset");
        $('#modelHeading').html("Create New Article");
        $('#ajaxModel').modal('show');
    });


    $('body').on('click', '.editArticle', function () {
      var article_id = $(this).data('id');
      $.get("{{ route('articles.index') }}" +'/' + article_id +'/edit', function (data) {
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
			url: "{{ route('articles.store') }}",
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
            url: "{{ route('articles.store') }}"+'/'+article_id,
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
</body>
</html>