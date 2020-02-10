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
		$_SESSION['name']=$data->name;
		echo json_encode(array("name"=>$_SESSION['name'],"message"=>'success'));
		exit;
	}
	else{
		echo 0;
		exit;
		}
	}

  if($id== 'edit')
  {
  $user_id=$_POST['user_id'];
  $name=$_POST['name']; 
  $email=$_POST['email'];
  $phone=$_POST['phone']; 
  $address=$_POST['address']; 
  $sql= mysqli_query($conn1,"update user set name='$name',email='$email',address='$address',phone='$phone' where user_id='".$user_id."'");
	  if($sql)
	  {
	 echo 1;
	   exit;
	}
else{
	echo 0;
  exit;
 }
}
if($id== 'add')
  {
  $name=$_POST['name']; 
  $email=$_POST['email'];
  $phone=$_POST['phone']; 
  $address=$_POST['address']; 
  $password=$_POST['password'];
  $state=$_POST['state']; 
  $district=$_POST['district']; 
  $sql= mysqli_query($conn1,"insert into user set name='$name',email='$email',address='$address',phone='$phone' ,password='$password',state='$state',district='$district'");
	  if($sql)
	  {
	 echo 1;
	   exit;
	}
else{
	echo 0;
  exit;
 }
}


if($id== 'del')
  {
  $user_id=$_POST['user_id'];
  $sql= mysqli_query($conn1,"delete from user where user_id='".$user_id."'");
	  if($sql)
	  {
	 echo 1;
	   exit;
	}
else{
	echo 0;
  exit;
 }
}


if($id== '4')
  {
  $stateId_new=$_POST['stateId_new'];
  $sql= mysqli_query($conn1,"select * from district where state_id in($stateId_new) order by district_name asc");
 $rowcount=mysqli_num_rows($sql);
  if($rowcount>0)
  {
	  $html="<option>Select District</option>";
	  while($seldist=mysqli_fetch_object($sql))
	  {
		$html.= "<option value='".$seldist->district_id."'>".$seldist->district_name."</option>";
	  } 
  }
  else{
	  $html.= '<option>District Not Available</option>';
  }
  echo $html;
 exit;
}
 ?>
