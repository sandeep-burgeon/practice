<html>
	<head>
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	</head>
	<body>
	<?php
	include('config.php');
	
	class User{
		public function set_users($name,$password,$email,$address,$phone){
			$this->name=$name;
			$this->password=$password;
			$this->email=$email;
			$this->address=$address;
			$this->phone=$phone;
			}
		public function get_users(){
			//$conn = new mysqli('localhost', 'phptest', 'phptest', 'phptest');
			$sel=array($this->name,$this->password,$this->email,$this->address,$this->phone);
			global $conn1;
			
			//mysqli_query($conn1,"select * from user") or die("error");
			mysqli_query($conn1,"insert into user set name='$sel[0]',password='$sel[1]',email='$sel[2]',address='$sel[3]',phone='$sel[4]'") or die("error");
			echo "<script>alert('User Residtration Successful..')</script>";
			}
		}
		if(isset($_POST['submit']))
		{
			$name=$_POST['name'];
			$password=$_POST['password'];
			$email=$_POST['email'];
			$address=$_POST['address'];
			$phone=$_POST['phone'];
			
			$adduser = new User;
			$adduser->set_users($name,$password,$email,$address,$phone);
			$adduser->get_users();
			}
		
	?>
	<section>
		<div class="container">
	 <form method="post">
		  <div class="form-group">
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
		  <div class="form-group">
			<label for="pwd">Password:</label>
			<input type="password" class="form-control" placeholder="Enter password" id="pwd" name="password" autocomplete="off"">
		  </div>
		  <input type="submit" name="submit" class="btn btn-primary" value="Submit">
		</form> 
		</div>
	</section>
	</body>
</html>
