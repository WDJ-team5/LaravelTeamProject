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
    		{data: 'id', name: 'id'},
            {data: 'email', name: 'email'},
            {data: 'name', name: 'name'},
			{data: 'rank', name: 'rank'},
            {data: 'action', name: 'action', orderable: false, searchable:false},
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
        <div class="col-md-12">
			
    		<h1>회원목록</h1>
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
						<th>Email</th>
						<th>Name</th>
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
