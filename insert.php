<?php
include('config.php');
  
  $id=$_POST['id'];
  if($id==1)
  {
  $name=$_POST['name']; 
  $email=$_POST['email'];
  $phone=$_POST['phone']; 
  $password=$_POST['password'];
  $address=$_POST['address']; 
  $sel=mysqli_query($conn1,"select * from user where email='".$email."' && phone='".$phone."'");
  $count=mysqli_num_rows($sel);
  if($count<1)
  {
  $sql= mysqli_query($conn1,"insert into user set name='$name',email='$email',password='$password',address='$address',phone='$phone'");
	  if($sql)
	  {
	 echo 1;
	   exit;
	}
}
else{
	echo 0;
  exit;
 }
}
if($id==2)
{
	$email=$_POST['email']; 
	$password=$_POST['password'];
	$select=mysqli_query($conn1,"select * from user where email='".$email."' && password='".$password."'");
	$data=mysqli_fetch_object($select);
	$count=mysqli_num_rows($select);
	if($count==1)
	{
		echo 1;
		$_SESSION['name']=$data->name;
	}
	else{
		echo 0;
		}
	}
 ?>
