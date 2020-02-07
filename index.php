
<?php
include('config.php');
?>
<html>
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<!-- Latest compiled and minified CSS -->
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<style>
  /* Make the image fully responsive */
  .carousel-inner img {
      width: 100%;
      height: 100%;
  }
  </style>
	</head>
	<body>
		<header>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
		  <a class="navbar-brand" href="#"><?php echo $_SESSION['name'];?></a>
		  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		  </button>

		  <div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav ml-auto">
			  <li class="nav-item active">
				<a class="nav-link" href="index.php">Home <span class="sr-only">(current)</span></a>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" href="add_oops.php">Add user</a>
			  </li>
			  <li class="nav-item dropdown">
				<a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
				  Dropdown
				</a>
				<div class="dropdown-menu" aria-labelledby="navbarDropdown">
				  <a class="dropdown-item" href="#">Action</a>
				  <a class="dropdown-item" href="#">Another action</a>
				  <div class="dropdown-divider"></div>
				  <a class="dropdown-item" href="#">Something else here</a>
				</div>
			  </li>
			  <li class="nav-item">
				<a class="nav-link" data-toggle="modal" data-target="#myModal">login</a>
			  </li>
			</ul>
			<form class="form-inline my-2 my-lg-0">
			  <input class="form-control mr-sm-2" type="search" placeholder="Search" aria-label="Search">
			  <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
			</form>
		  </div>
		</nav>
		</header>
		<section>
			<div class="container">
				<table class="table table-bordered mt-2">
					<tr>
						
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Action</th>
					</tr>
					<?php
					$sel=mysqli_query($conn1,"select name,email,phone,address ,user_id from user");
					$count=mysqli_num_rows($sel);
					while($data=mysqli_fetch_object($sel))
					{
					?>
					<tr data-userid="<?=$data->user_id?>">
						
						<td class="name"><?=$data->name?></td>
						<td class="email"><?=$data->email?></td>
						<td class="phone"><?=$data->phone?></td>
						<td class="address"><?=$data->address?></td>
						<td><button type="button" data-toggle="modal" class="edit_btn">Edit</button>|
						<button type="button" class="del_btn">Delete</button></td>
					
					
					
					
					<?php
				}
					?>
					</tr>
				</table>
			</div>
		</section>
		<!----------Edit Model-------------->
					<!-- The Modal -->
					
						

					
					  <div class="modal fade" id="myModalEdit">
						<div class="modal-dialog">
						  <div class="modal-content container-fluid">
						  
							<!-- Modal Header -->
							<div class="modal-header">
							  <h4 class="modal-title">Edit User</h4>
							  <button type="button" class="close" data-dismiss="modal">&times;</button>
							</div>
							
							<!-- Modal body -->
							<form method="post">
							  <div class="form-group">
								<input type="hidden" name="user_id" id="user_id" value="<?=$data->user_id?>">
								<label>Name:</label>
								<input type="text" class="form-control" placeholder="Enter Your Name" id="name" name="name" autocomplete="off" value="<?=$data->name?>">
							  </div>
							  <div class="form-group">
								<label>Email:</label>
								<input type="text" class="form-control" placeholder="Enter Your Email" id="email" name="email" autocomplete="off" value="<?=$data->email?>"> 
							  </div>
							  <div class="form-group">
								<label>Address:</label>
								<input type="text" class="form-control" placeholder="Enter Your Address" id="address" name="address" autocomplete="off" value="<?=$data->address?>">
							  </div>
							  <div class="form-group">
								<label>Phone:</label>
								<input type="text" class="form-control" placeholder="Enter Your Phone No." id="phone" name="phone" autocomplete="off" value="<?=$data->phone?>">
							  </div>
							<!-- Modal footer -->
							<div class="modal-footer">
								<button type="submit" name="update" id="update" class="btn btn-primary">Update</button>
								<button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
							</div>
						  </form> 
						  </div>
						</div>
					  </div>
					  <script>
					$(document).ready(function(){
						$(".edit_btn").on('click', function(){
						var name = $(this).closest('tr').find('.name').text();
						var email = $(this).closest('tr').find('.email').text();
						var phone = $(this).closest('tr').find('.phone').text();
						var address = $(this).closest('tr').find('.address').text();
						var user_id = $(this).closest('tr').attr('data-userid');
						$('#name').val(name);
						$('#email').val(email);
						$('#phone').val(phone);
						$('#address').val(address);
						$('#user_id').val(user_id);
						$('#myModalEdit').modal('show');
						});
						 $("#update").click(function() {
						var name = $('#name').val();
						var email =  $('#email').val();
						var phone =  $('#phone').val();
						var address =  $('#address').val();
						var user_id =  $('#user_id').val();
						$.ajax({
							type: "POST",
							url: "insert.php",
							data: "name=" + name+ "&email=" + email + "&phone=" + phone + "&address=" + address + "&user_id=" + user_id + "&id=" + 'edit' ,
							success: function(data) {	
							  if(data==1)
							   {
								alert("Update Successfull...");
								 $('#myModalEdit').modal('hide'); 
								}
							else{
								alert("Update User Failed");
								}
							}
						});
						return false;
					});
						
						
						$(".del_btn").on('click', function(){
						var user_id = $(this).closest('tr').attr('data-userid');
						$.ajax({
							type: "POST",
							url: "insert.php",
							data: "user_id=" + user_id + "&id=" + 'del' ,
							context: this,
							success: function(data) {	
							  if(data==1)
							   {
								alert("Deleted Successfull...");
								
								 $(this).closest('tr').remove();
								}
							else{
								alert("Deleted Failed");
								}
							}
						});
						return false;
					});
						
					});
					
					</script>
				<!-----------/Edit Model----------->
		<section>
		<div id="demo" class="carousel slide" data-ride="carousel">

		  <!-- Indicators -->
		  <ul class="carousel-indicators">
			<li data-target="#demo" data-slide-to="0" class="active"></li>
			<li data-target="#demo" data-slide-to="1"></li>
			<li data-target="#demo" data-slide-to="2"></li>
		  </ul>
		  
		  <!-- The slideshow -->
		  <div class="carousel-inner">
			<div class="carousel-item active">
			  <img src="image/chicago.jpg" alt="Los Angeles" width="1100" height="500">
			</div>
			<div class="carousel-item">
			  <img src="image/chicago.jpg" alt="Chicago" width="1100" height="500">
			</div>
			<div class="carousel-item">
			  <img src="image/chicago.jpg" alt="New York" width="1100" height="500">
			</div>
		  </div>
		  
		  <!-- Left and right controls -->
		  <a class="carousel-control-prev" href="#demo" data-slide="prev">
			<span class="carousel-control-prev-icon"></span>
		  </a>
		  <a class="carousel-control-next" href="#demo" data-slide="next">
			<span class="carousel-control-next-icon"></span>
		  </a>
		</div>
		</section>
		
		
		
		
		 <!-- The Modal -->
		  <div class="modal fade" id="myModal">
			<div class="modal-dialog">
			  <div class="modal-content">
			  
				<!-- Modal Header -->
				<div class="modal-header">
				  <h4 class="modal-title">Modal Heading</h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<div class="modal-body">
				  Modal body..
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
				  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				
			  </div>
			</div>
		  </div>
		<!----------Login Model--------->	
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> 
	</body>
</html>
