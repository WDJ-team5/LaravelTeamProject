@extends('layouts.app')

@section('script')
<script>
	$(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });


	// 유저를 뿌려줌
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('managements.index') }}",
		columns: [
            {data: 'DT_RowIndex', name: 'DT_RowIndex'},
            {data: 'title', name: 'title'},
            {data: 'content', name: 'content'},
            {data: 'action', name: 'action', orderable: false, searchable: false},
        ]
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
      
                </form>
            </div>
        </div>
    </div>
</div>

@endsection
