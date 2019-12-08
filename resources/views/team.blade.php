@extends('layouts.app')

@section('script')
<script>
	(function($) {
		window.onload = function(){
			$('#team-ul').find(":not(li:first-child)").remove();
			function getAllData(){
				fetch('/teams/create',{
				method: "GET",
				headers: {
					'Content-Type': 'application/json',
					'Accept': 'application/json',
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
				}})
				.then(e => e.json())
				.then(data => {
					if(!data[1]){
						$('#add-team').parent().css('display','block');
					}
					Array.from(data[0]).forEach((info,index)=>{
						setElements(info,index);
					});
				})
				.then(()=>{
					setEvents();
				});
			}
		

			function setElements(info,index){
				var mainUl = document.getElementById('team-ul');
				var li = document.createElement('li');
				if(index%2 == 0){
					li.className = 'timeline-inverted';
				}
				var img_div = document.createElement('div');
				img_div.className = 'timeline-image team-image';
				img_div.id = info.user.id;
				var imgPath = '';
				if(info.user.img) {
					imgPath = "http://"+document.location.hostname+"/files/"+info.user.img;
				}
				var img = document.createElement('img');
				img.className = 'rounded-circle img-fluid';
				img.src = imgPath;
				
				var out_div = document.createElement('div');
				out_div.className = 'timeline-panel';
				
				var in_div = document.createElement('div');
				in_div.className = 'timeline-heading';
				
				var name = document.createElement('h4');
				name.innerHTML = info.user.name;
				
				var email = document.createElement('h6');
				email.className = 'subheading';
				email.innerHTML = info.user.email;
				
				img_div.appendChild(img);
				li.appendChild(img_div);
				in_div.appendChild(name);
				in_div.appendChild(email);
				out_div.appendChild(in_div);
				li.appendChild(out_div);
				mainUl.appendChild(li);
			}
			
			function setOnClickEventToImg(img,index){
				img.addEventListener('click',function(e){
					var target = e.currentTarget.parentNode.lastChild
					if(clickStatus[index] == false){
						var div = document.createElement('div');
						div.className = 'timeline-body';
						
						var birthday = document.createElement('p');
						birthday.className = 'text-muted';
						
						id = e.currentTarget.id;
						
						fetch('/teams/'+id,{
							method: "GET"
						})
						.then(e => e.json())
						.then(function(data){
							birthday.innerHTML = '생일 : '+data[0][0].birth;
							div.appendChild(birthday);
							if(id == data[1]){
								var comment = document.createElement('input');
								comment.value = data[0][0].team.comment;
								comment.className = 'text-muted'; 
								comment.id = 'comment-data';
								div.appendChild(comment);
								makeUpdate(data[0][0].team.id);
							}else{
								var comment = document.createElement('p');
								comment.innerHTML = '자기소개 : '+data[0][0].team.comment;
								div.appendChild(comment);
							}
						});
						
						// 이건 본인이나 관리자만
						function makeUpdate(id){
							var updateBtn = document.createElement('button');
							var editDiv = document.createElement('div');
							
							updateBtn.innerHTML = '수정';
							updateBtn.addEventListener('click',function(e){
								var commentData = $('#comment-data').val();
								fetch('/teams/'+id,{
									method:"PUT",
									headers: {
										'Content-Type': 'application/json',
										'Accept': 'application/json',
										'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
									},
									body:JSON.stringify({'comment': commentData})
								})
								.then(function(e){
									target.removeChild(target.lastChild)
									clickStatus[index] = false;
								});
							});
							div.appendChild(updateBtn);

							var deleteBtn = document.createElement('button');
							deleteBtn.innerHTML = '삭제';
							deleteBtn.addEventListener('click',function(e){
								fetch('/teams/'+id,{
									method:"DELETE",
									headers: {
										'Content-Type': 'application/json',
										'Accept': 'application/json',
										'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
									},
								})
								.then(function(e){
									var deleteTarget = target.parentNode;
									deleteTarget.parentNode.removeChild(deleteTarget);
									
									$('#add-team').parent().css('display','block');	
									var lis = $('#team-ul > li');
									for(var i = 0;i < lis.length;i++){
										if(i%2!=0){
											lis[i].className = 'timeline-inverted';
										}else{
											lis[i].className = '';
										}
									}
								});
							});
							div.appendChild(deleteBtn);
						}
						target.appendChild(div);
						clickStatus[index] = true;
					}else{
						target.removeChild(target.lastChild)
						clickStatus[index] = false;
					}
				});
			}
			
			function setEvents(){
				var imgs = $('.timeline-image');
				clickStatus = [];
				for(var i = 0; i < imgs.length; i++){
					clickStatus[i] = false;
				}
				Array.from($('.team-image')).forEach(function(img, index){
					setOnClickEventToImg(img,index);
				});
				var ls_container = document.getElementById('team-modal');
				document.getElementById('add-team').addEventListener('click',function(e){
					var box = document.createElement('div');
					box.className = 'modal-content';
					
					var span = document.createElement('span');
					span.className = 'close';
					span.innerHTML = '&times;';
					span.addEventListener('click',function(e){
						ls_container.innerHTML='';
						ls_container.style.display = 'none';
					});
					
					var div = document.createElement('div');
					div.innerHTML = '\<input name="comment" id="comment"></input>\<button type="submit" id="create-btn";">버튼</button>';
					box.appendChild(span);
					box.appendChild(div);
					ls_container.appendChild(box);
					ls_container.style.display = 'block';
					$("#create-btn").click(imageClick);
				});
			}
			
			function imageClick(){
				var comment = $('#comment').val();
				fetch('/teams',{
					headers : { 
						'Content-Type': 'application/json',
						'Accept': 'application/json',
						'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
					},
					method:'POST',
					credentials: "same-origin",
					body:JSON.stringify({'comment': comment})
				})
				.then(e => e.json())
				.then(e=>{
					$('#add-team').parent().css('display','none');
					var ls_container = document.getElementById('team-modal');
					ls_container.innerHTML='';
					ls_container.style.display = 'none';
					getAllData();
				}); 
			}
			getAllData();
		}
	})(jQuery);
</script>
@endsection

@section('style')
<style>
	.page-section {
		padding: 100px 0;
	}

	.page-section h2.section-heading {
		font-size: 40px;
		margin-top: 0;
		margin-bottom: 15px;
	}

	.page-section h3.section-subheading {
		font-size: 16px;
		font-weight: 400;
		font-style: italic;
		margin-bottom: 75px;
		text-transform: none;
		font-family: 'Droid Serif', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, 'Helvetica Neue', Arial, sans-serif, 'Apple Color Emoji', 'Segoe UI Emoji', 'Segoe UI Symbol', 'Noto Color Emoji';
	}
	.page-section h2.section-heading {
		font-size: 40px;
		margin-top: 0;
		margin-bottom: 15px;
	}
	.timeline {
		position: relative;
		padding: 0;
		list-style: none;
	}

	.timeline:before {
		position: absolute;
		top: 0;
		bottom: 0;
		left: 40px;
		width: 2px;
		margin-left: -1.5px;
		content: '';
		background-color: #e9ecef;
	}

	.timeline > li {
		position: relative;
		min-height: 50px;
		margin-bottom: 50px;
	}

	.timeline > li:after, .timeline > li:before {
		display: table;
		content: ' ';
	}

	.timeline > li:after {
		clear: both;
	}

	.timeline > li .timeline-panel {
		position: relative;
		float: right;
		width: 100%;
		padding: 0 20px 0 100px;
		text-align: left;
	}

	.timeline > li .timeline-panel:before {
		right: auto;
		left: -15px;
		border-right-width: 15px;
		border-left-width: 0;
	}

	.timeline > li .timeline-panel:after {
		right: auto;
		left: -14px;
		border-right-width: 14px;
		border-left-width: 0;
	}

	.timeline > li .timeline-image {
		position: absolute;
		z-index: 100;
		left: 0;
		width: 80px;
		height: 80px;
		margin-left: 0;
		text-align: center;
		color: white;
		border: 7px solid #e9ecef;
		border-radius: 100%;
		background-color: #fed136;
	}

	.timeline > li .timeline-image h4 {
		font-size: 10px;
		line-height: 14px;
		margin-top: 12px;
	}

	.timeline > li.timeline-inverted > .timeline-panel {
		float: right;
		padding: 0 20px 0 100px;
		text-align: left;
	}

	.timeline > li.timeline-inverted > .timeline-panel:before {
		right: auto;
		left: -15px;
		border-right-width: 15px;
		border-left-width: 0;
	}

	.timeline > li.timeline-inverted > .timeline-panel:after {
		right: auto;
		left: -14px;
		border-right-width: 14px;
		border-left-width: 0;
	}

	.timeline > li:last-child {
		margin-bottom: 0;
	}

	.timeline .timeline-heading h4 {
		margin-top: 0;
		color: inherit;
	}

	.timeline .timeline-heading h4.subheading {
		text-transform: none;
	}

	.timeline .timeline-body > ul,
	.timeline .timeline-body > p {
		margin-bottom: 0;
	}

	@media (min-width: 768px) {
		.timeline:before {
			left: 50%;
		}
		.timeline > li {
			min-height: 100px;
			margin-bottom: 100px;
		}
		.timeline > li .timeline-panel {
			float: left;
			width: 41%;
			padding: 0 20px 20px 30px;
			text-align: right;
		}
		.timeline > li .timeline-image {
			left: 50%;
			width: 100px;
			height: 100px;
			margin-left: -50px;
		}
		.timeline > li .timeline-image h4 {
			font-size: 13px;
			line-height: 18px;
			margin-top: 16px;
		}
		.timeline > li.timeline-inverted > .timeline-panel {
			float: right;
			padding: 0 30px 20px 20px;
			text-align: left;
		}
	}

	@media (min-width: 992px) {
		.timeline > li {
			min-height: 150px;
		}
		.timeline > li .timeline-panel {
			padding: 0 20px 20px;
		}
		.timeline > li .timeline-image {
			width: 150px;
			height: 150px;
			margin-left: -75px;
		}
		.timeline > li .timeline-image h4 {
			font-size: 18px;
			line-height: 26px;
			margin-top: 30px;
		}
		.timeline > li.timeline-inverted > .timeline-panel {
			padding: 0 20px 20px;
		}
	}

	@media (min-width: 1200px) {
		.timeline > li {
			min-height: 170px;
		}
		.timeline > li .timeline-panel {
			padding: 0 20px 20px 100px;
		}
		.timeline > li .timeline-image {
			width: 170px;
			height: 170px;
			margin-left: -85px;
		}
		.timeline > li .timeline-image h4 {
			margin-top: 40px;
		}
		.timeline > li.timeline-inverted > .timeline-panel {
			padding: 0 100px 20px 20px;
		}
	}


	/* modals */
	.modal {
		display: none; /* Hidden by default */
		position: fixed; /* Stay in place */
		z-index: 2000; /* Sit on top */
		left: 0;
		top: 0;
		width: 100%; /* Full width */
		height: 100%; /* Full height */
		overflow: auto; /* Enable scroll if needed */
		background-color: rgb(0,0,0); /* Fallback color */
		background-color: rgba(0,0,0,0.4); /* Black w/ opacity */
	}

	/* Modal Content/Box */
	.modal-content {
		background-color: #fefefe;
		margin: 15% auto; /* 15% from the top and centered */
		padding: 20px;
		border: 1px solid #888;
		width: 50%; /* Could be more or less, depending on screen size */                          
	}
	/* The Close Button */
	.close {
		color: #aaa;
		float: right;
		font-size: 28px;
		font-weight: bold;
	}
	.close:hover,
	.close:focus {
		color: black;
		text-decoration: none;
		cursor: pointer;
	}
	
	.rounded-circle {
		padding: 5%;
		width: 100%;
		height: 100%;
	}

</style>
@endsection

@section('content')
<meta id = 'user-data'>
<section class="page-section" id="about">
	<div class="container">
		<div class="row">
			<div class="col-lg-12 text-center">
				<h2 class="section-heading text-uppercase">조원 소개</h2>
				<h3 class="section-subheading text-muted">oomori 짱짱 123</h3>
			</div>
		</div>
		<div class="row">
			<div class="col-lg-12">
				<ul class="timeline" id='team-ul'>
					<li class="timeline-inverted" style="display:none">
						<div class="timeline-image" id = 'add-team' onselectstart="return false"  ondragstart="return false" >
							<h4>추가
							<br>My
							<br>Introtuce</h4>
						</div>
					</li>
				</ul>
			</div>
		</div>
	</div>
	<div id="team-modal" class="modal"></div>
</section>
@endsection