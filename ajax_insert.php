<!DOCTYPE html>
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
<section>
		<div class="container">
			<h1>User Registration</h1>
	 <form method="post" id="myform">
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
			<input type="password" class="form-control" placeholder="Enter password" id="password" name="password" autocomplete="off"">
		  </div>
		  <input type="button" name="submit" class="btn btn-primary" value="Submit" id="submit">
		</form> 
	</div>
</section>
<script>
function valfun(){
	var name=$("#name").val();
	var email=$("#email").val();
	var phone=$("#phone").val();
	var address=$("#address").val();
	var password=$("#password").val();
		if(name==""|| name.length<3 || name.length>20)
		{
		alert("please Fill Your Name & Name should be between 3-to-20 character!..");
		return false;
		}
		if(email==""|| email.length<10 || email.length>60)
		{
		alert("please Fill Your Email Id & Email Id should be between  10-to-60 character!..");
		return false;
		}
		if(address==""|| address.length<10 || address.length>100)
		{
		alert("please Fill Your Address & Address should be between  10-to-100 character!..");
		return false;
		}
		if(phone.length != 10)
		{
			
		alert("please Fill Your Mobile No & Mobile No should be only 10 Digit");
		return false;
		}
		if(password==""|| password.length<8 || password.length>35)
		{
		alert("please Fill Your Password & Password should be between  8-to-35 character!..");
		return false;
		}
		return true;
		
}
</script>
<script>
	$(document).ready(function(){
		  $("#submit").click(function() {
						var name= $("#name").val();
						var email= $("#email").val();
						var phone= $("#phone").val();
						var password= $("#password").val();
						var address= $("#address").val();
						if(valfun()){
						$.ajax({
							type: "POST",
							url: "insert.php",
							data: "name=" + name+ "&email=" + email+ "&phone=" + phone +  "&password=" + password+  "&address=" + address+ "&id=" + 1 ,
							success: function(data) {
							  if(data==1)
							   {
								alert("sucess");   
								}
							else{
								alert("Registration Failed");
								}
							}
						});
						return false;
					}
					});
	
						
			});
</script>
</body>
</html>
