<?php include('interface.php'); ?>
<?php
	if(isset($_POST['submit']))
		{
			$name=$_POST['name'];
			$password=$_POST['password'];
			$email=$_POST['email'];
			$address=$_POST['address'];
			$phone=$_POST['phone'];
			$state=$_POST['state'];
			$district=$_POST['district'];
			
			$obj =new MyClassName(); 
			$obj->insert($name,$password,$email,$address,$phone,$state,$district,$conn);
			}
	if(isset($_POST['update']))
		{
			$name=$_POST['name'];
			$email=$_POST['email'];
			$address=$_POST['address'];
			$phone=$_POST['phone'];
			$condition=$_POST['user_id'];
			
			$obj =new MyClassName(); 
			$obj->update($name,$email,$address,$phone,$conn,$condition);
			}

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>Bootstrap Example</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>
	<div class="container">
		<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
			Add User
		  </button>
		<table class="table table-bordered">
		<tr><th>Name</th><th>Email</th><th>Contact</th><th>Address</th><th>Action</th></tr>
	<?php
		$sel=mysqli_query($conn,"select * from user");
		while($data=mysqli_fetch_object($sel))
		{
			?>
			<tr class="userid<?=$data->user_id?>" data-userid="<?=$data->user_id?>">
			<td class="name"><?=$data->name?></td><td class="email"><?=$data->email?></td><td class="phone"><?=$data->phone?></td>
			<td class="address"><?=$data->address?></td>
			<td><button type="button" data-toggle="modal" class="edit_btn btn btn-sm btn-warning">Edit</button></td>
			</tr>
	<?php
		}
	?>
	</table>
	</div>
	<section>

		  <!-- Add User Modal -->
		  <div class="modal" id="myModal">
			<div class="modal-dialog">
			  <div class="modal-content">
			  
				<!-- Modal Header -->
				<div class="modal-header">
				  <h4 class="modal-title">User Registration</h4>
				  <button type="button" class="close" data-dismiss="modal">&times;</button>
				</div>
				
				<!-- Modal body -->
				<form method="post">
				<div class="modal-body">
					
					  <div class="form-group">
						<label>Name:</label>
						<input type="text" class="form-control" placeholder="Enter Your Name" name="name" autocomplete="off">
					  </div>
					  <div class="form-group">
						<label>Email:</label>
						<input type="text" class="form-control" placeholder="Enter Your Email" name="email" autocomplete="off"> 
					  </div>
					  <div class="form-group">
						<label>Address:</label>
						<input type="text" class="form-control" placeholder="Enter Your Address" name="address" autocomplete="off">
					  </div>
					  <div class="form-group">
						<label>Phone:</label>
						<input type="text" class="form-control" placeholder="Enter Your Phone No." name="phone" autocomplete="off">
					  </div>
					  <div class="form-group">
						<label>State Name:</label>
						<select class="form-control state_id" name="state">
							<option value="" disabled selected hidden>Please Choose State</option>
							<?php
							$sel=mysqli_query($conn,"select state_name, state_id from state where del_action='N'");
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
						<select class="form-control district_id" name="district">
							<option value="" disabled selected hidden>Please Choose District</option>
						</select>
					  </div>
					  <div class="form-group">
						<label for="pwd">Password:</label>
						<input type="password" class="form-control" placeholder="Enter password" name="password" autocomplete="off">
					  </div>
					
				</div>
				
				<!-- Modal footer -->
				<div class="modal-footer">
				  <button type="submit" name="submit" class="btn btn-primary" >Submit</button>
				  <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
				</div>
				</form> 
			  </div>
			</div>
		  </div>
	</section>
	
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
								<input type="text" class="form-control" placeholder="Enter Your Name" id="name" name="name" autocomplete="off">
							  </div>
							  <div class="form-group">
								<label>Email:</label>
								<input type="text" class="form-control" placeholder="Enter Your Email" id="email" name="email" autocomplete="off"> 
							  </div>
							  <div class="form-group">
								<label>Address:</label>
								<input type="text" class="form-control" placeholder="Enter Your Address" id="address" name="address" autocomplete="off">
							  </div>
							  <div class="form-group">
								<label>Phone:</label>
								<input type="text" class="form-control" placeholder="Enter Your Phone No." id="phone" name="phone" autocomplete="off">
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
						alert (name);
						$('#name').val(name);
						$('#email').val(email);
						$('#phone').val(phone);
						$('#address').val(address);
						$('#user_id').val(user_id);
						$('#myModalEdit').modal('show');
						});
					});
					
					</script>
				<!-----------/Edit Model----------->
	<script>
		$(document).ready(function(){
		$('.state_id').on('change',function(){
			var stateId=$(this).val();
			if(stateId){
				$.ajax({
					type:"POST",
					url:'insert.php',
					data:"stateId_new=" +stateId+"&id=" + 4 ,
					success:function(html){
						$('.district_id').html(html);
						}
					});
				}
			else{
				$('.district_id').html('<option value="">Select First District</option>');
				}
			});		
		});
	</script>
</body>
</html>
