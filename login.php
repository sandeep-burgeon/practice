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
			<label>Email:</label>
			<input type="text" class="form-control" placeholder="Enter Your Email" id="email" name="email" autocomplete="off"> 
		  </div>
		  <div class="form-group">
			<label for="pwd">Password:</label>
			<input type="password" class="form-control" placeholder="Enter password" id="password" name="password" autocomplete="off"">
		  </div>
		  <input type="button" name="submit" class="btn btn-primary" value="Login" id="submit">
		</form> 
	</div>
</section>
<script>
	$(document).ready(function(){
		  $("#submit").click(function() {
						var email= $("#email").val();
						var password= $("#password").val();
						$.ajax({
							type: "POST",
							url: "insert.php",
							data: "email=" + email+ "&password=" + password + "&id=" + 2,
							success: function(data) {
							  data = JSON.parse(data);	
							  if(data.message=='success')
							   {
								alert("success");
								
								window.location.assign("index.php");  
								}
							else{
								alert("Registration Failed");
								}
							}
						});
						return false;
					});
	
						
			});
</script>
</body>
</html>
