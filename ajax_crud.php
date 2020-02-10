
<?php
include('config.php');
if(!isset($_SESSION['name']))
{ header('location:index.php'); }
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
		
		<section>
			<div class="container">
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModalAdd">Add User</button>
				<a href="index1.php" class="btn btn-info">Home</a>
				<?php
				$limit = 10;  
				if (isset($_GET["page"])) { $page  = $_GET["page"]; } else { $page=1; };  
				$start_from = ($page-1) * $limit;  
				  
				$sql = "select name,email,phone,address ,user_id from user where 1=1 LIMIT $start_from, $limit";  
				$rs_result = mysqli_query($conn1, $sql); 
				
				?>
				<table id="userlist" class="table table-bordered mt-2 table-striped">
					<tr>
						
						<th>Name</th>
						<th>Email</th>
						<th>Phone</th>
						<th>Address</th>
						<th>Action</th>
					</tr>
					<?php
					$sel=mysqli_query($conn1,$sql);
					$count=mysqli_num_rows($sel);
					while($data=mysqli_fetch_object($sel))
					{
					?>
					<tr class="userid<?=$data->user_id?>" data-userid="<?=$data->user_id?>">
						
						<td class="name"><?=$data->name?></td>
						<td class="email"><?=$data->email?></td>
						<td class="phone"><?=$data->phone?></td>
						<td class="address"><?=$data->address?></td>
						<td><button type="button" data-toggle="modal" class="edit_btn btn btn-sm btn-warning">Edit</button>
						<button type="button" class="del_btn btn btn-sm btn-danger">Delete</button></td>
					
					<?php
				}
					?>
					</tr>
				</table>
				<?php 
					$sql1 = "SELECT COUNT(user_id) FROM user";  
					$rs_result = mysqli_query($conn1, $sql1);  
					$row = mysqli_fetch_row($rs_result);  
					$total_records = $row[0];  
					$total_pages = ceil($total_records / $limit);  
					$pagLink = "<div class='pagination bg-dark col-lg-5'>";  
					for ($i=1; $i<=$total_pages; $i++) {  
						$pagLink .= "<a href='index.php?page=".$i."'>".$i."</a>";  
					};  
					echo $pagLink . "</div>";  
				?>
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
								
								var slid = $('#userlist').find('.userid'+user_id);
								console.log(slid.length);
								
								slid.find('.name').text(name);
								slid.find('.email').text(email);
								slid.find('.phone').text(phone);
								slid.find('.address').text(address);
								
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
				<!-----------Add User Modal---------->
				<!-- The Modal -->
				  <div class="modal" id="myModalAdd">
					<div class="modal-dialog">
					  <div class="modal-content container">
					  
						<!-- Modal Header -->
						<div class="modal-header">
						  <h4 class="modal-title">Modal Heading</h4>
						  <button type="button" class="close" data-dismiss="modal">&times;</button>
						</div>
						
						<!-- Modal body -->
						<form method="post">
						  <div class="form-group">
							<label>Name:</label>
							<input type="text" class="form-control" placeholder="Enter Your Name" id="aname" name="name" autocomplete="off">
						  </div>
						  <div class="form-group">
							<label>Email:</label>
							<input type="text" class="form-control" placeholder="Enter Your Email" id="aemail" name="email" autocomplete="off"> 
						  </div>
						  <div class="form-group">
							<label>Address:</label>
							<input type="text" class="form-control" placeholder="Enter Your Address" id="aaddress" name="address" autocomplete="off">
						  </div>
						  <div class="form-group">
							<label>Phone:</label>
							<input type="text" class="form-control" placeholder="Enter Your Phone No." id="aphone" name="phone" autocomplete="off">
						  </div>
						  <div class="form-group">
							<label>State Name:</label>
							<select class="form-control" name="state" id="state_id">
								<option value="" disabled selected hidden>Please Choose State</option>
								<?php
								$sel=mysqli_query($conn1,"select state_name, state_id from state where del_action='N'");
								while($selstate=mysqli_fetch_object($sel))
								{
								?>
									<option value="<?=$selstate->state_id?>"><?=$selstate->state_name?></option>
								<?php
								}
								?>
								
							</select>
						  </div>
						  <div class="form-group">
							<label>District Name:</label>
							<select class="form-control" name="district" id="district_id">
								<option value="" disabled selected hidden>Please Choose District</option>
							</select>
						  </div>
						  <div class="form-group">
							<label for="pwd">Password:</label>
							<input type="password" class="form-control" placeholder="Enter password" id="apassword" name="password" autocomplete="off">
						  </div>
						  
						
						
						<!-- Modal footer -->
						<div class="modal-footer">
						  <button type="buttom" name="submit" class="btn btn-primary" id="addUser">Update</button>
						  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
						</div>
						</form> 
					  </div>
					</div>
				  </div>
				  <!---------------/Add User Modal-------------->
		
		<script>
		$(document).ready(function(){
		$('#state_id').on('change',function(){
			var stateId=$(this).val();
			if(stateId){
				$.ajax({
					type:"POST",
					url:'insert.php',
					data:"stateId_new=" +stateId+"&id=" + 4 ,
					success:function(html){
						$('#district_id').html(html);
						}
					});
				}
			else{
				$('#district_id').html('<option value="">Select First District</option>');
				}
			});
			 $("#addUser").click(function() {
						var name = $('#aname').val();
						var email =  $('#aemail').val();
						var phone =  $('#aphone').val();
						var address =  $('#aaddress').val();
						var password =  $('#apassword').val();
						var state =  $('#state_id').val();
						var district =  $('#district_id').val();
						$.ajax({
							type: "POST",
							url: "insert.php",
							data: "name=" + name+ "&email=" + email + "&phone=" + phone + "&address=" + address + "&password=" + password + "&state=" + state + "&district=" + district + "&id=" + 'add' ,
							success: function(data) {	
							  if(data==1)
							   {
								alert("Add User Successfull...");
								$('#myModalAdd').modal('hide'); 
								
								}
							else{
								alert("Add User Failed");
								}
							}
						});
						return false;
					});
								
		});
	</script>
		<!-- jQuery library -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<!-- Popper JS -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<!-- Latest compiled JavaScript -->
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script> 
	</body>
</html>
