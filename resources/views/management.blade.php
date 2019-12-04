@extends('layouts.app')

@section('script')
<script>
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
@endsection

@section('style')
    
@endsection

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
			
    		<h1>5조 게시판</h1>
			<table class="table table-bordered data-table">
				<thead>
					<tr>
						<th>No</th>
						<th>Email</th>
						<th>Name</th>
						<th>Rank</th>
						<!-- <th width="300px">Action</th> -->
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>

<!-- modal -->
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

@endsection
