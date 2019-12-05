@extends('layouts.app')

@section('script')
<script>
	$(function () {
      $.ajaxSetup({
          headers: {
              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
    });


	/* table ajax index */
    var table = $('.data-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('managements.index') }}",
		columns: [
    		{data: 'id', name: 'id'},
            {data: 'email', name: 'email'},
            {data: 'name', name: 'name'},
			{data: 'birth', name: 'birth'},
			{data: 'gender', name: 'gender'},
			{data: 'rank', name: 'rank'},
            {data: 'action', name: 'action', orderable: false, searchable:false},
        ]
    });
	
		
	$('body').on('click', '.rankUp', function () {
		var User_id = $(this).data("id");
		var result = confirm("등급을 올리시겠습니까?");
		if(result) {
			$.ajax({
				type: "PUT",
				data: {"up" : "up"},
				url: "{{ route('managements.store') }}"+'/'+User_id,
				dataType: 'json',
				success: function (data) {
					table.draw();
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
		
	$('body').on('click', '.rankDown', function () {
		var User_id = $(this).data("id");
		var result = confirm("등급을 내리시겠습니까?");
		if(result) {
			$.ajax({
				type: "PUT",
				data: {"down" : "down"},
				url: "{{ route('managements.store') }}"+'/'+User_id,
				dataType: 'json',
				success: function (data) {
					table.draw();
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}
	});
	
	/* table ajax delete */
	$('body').on('click', '.deleteUser', function () {
		var User_id = $(this).data("id");
		var result = confirm("삭제하시겠습니까?");	
		if(result) {
			$.ajax({
				type: "DELETE",
				url: "{{ route('managements.store') }}"+'/'+User_id,
				success: function (data) {
					table.draw();
				},
				error: function (data) {
					console.log('Error:', data);
				}
			});
		}   
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
			
    		<h1>회원목록</h1>
			<table class="table table-bordered data-table">
				<colgroup>
					<col width='5%'/>
					<col width='*%'/>
					<col width='20%'/>
					<col width='10%'/>
					<col width='8%'/>
					<col width='8%'/>
					<col width='18%'/>
				</colgroup>
				<thead>
					<tr>
						<th>No</th>
						<th>Email</th>
						<th>Name</th>
						<th>Birth</th>
						<th>gender</th>
						<th>Rank</th>
						<th width="300px">Action</th>
					</tr>
				</thead>
				<tbody>
				</tbody>
			</table>
		</div>
	</div>
</div>
@endsection
