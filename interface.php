<?php  
  
interface MyInterfaceName{ 
  
    public function db_connect($host,$user,$password,$db_name); 
    public function insert($name,$email,$phone,$address,$password,$state,$district,$conn); 
    public function read($conn); 
	public function update($name,$email,$phone,$address,$conn,$condition); 
     
  
} 
  
class MyClassName implements MyInterfaceName{ 
    public $sel,$data;
    public $conn;
    public function db_connect($host,$user,$password,$db_name){ 
       $this->host=$host;
       $this->user=$user;
       $this->password=$password;
       $this->db_name=$db_name;
	   $this->conn=mysqli_connect($this->host,$this->user,$this->password,$this->db_name);
	   return $this->conn;
    } 
  
    public function insert($name,$email,$phone,$address,$password,$state,$district,$conn){ 
       $this->name=$name;
       $this->email=$email;
       $this->phone=$phone;
       $this->address=$address;
       $this->password=$password;
       $this->state=$state;
       $this->district=$district; 
       mysqli_query($conn,"insert into user set name='$this->name',email='$this->email',address='$this->address',password='$this->password',phone='$this->phone',
       state='$this->state',district='$this->district'");
       //echo "insert into user set name='$this->name',email='$this->email',address='$this->address',password='$this->password',phone='$this->phone',
      //state='$this->state',district='$this->district'";
       echo "<script>alert('Success')</script>";
    }
	public function read($conn){
		$sel=mysqli_query($conn,"select * from user");
		echo "<table border=1><tr><th>Name</th><th>Email</th><th>Contact</th><th>Address</th></tr>";
		while($data=mysqli_fetch_object($sel))
		{
			echo "<tr><td>".$data->name."</td><td>".$data->email."</td><td>".$data->phone."</td><td>".$data->address."</td></tr>";
			
		}
		echo "</table>";
	}
	public function update($name,$email,$phone,$address,$conn,$condition)
	{
	   $this->name=$name;
       $this->email=$email;
       $this->phone=$phone;
       $this->address=$address;
       mysqli_query($conn,"update user set name='$this->name',email='$this->email',address='$this->address',phone='$this->phone' where user_id='".$condition."'");
	   echo "<script>alert('Update Successfully')</script>";
	}
}  
  
$obj =new MyClassName(); 
$conn=$obj->db_connect('localhost','phptest','phptest','phptest'); 
//$obj->insert('Sandeep','sandeep@gmail.com','7765913404','Bihar','123456','1','1',$conn); 
 
//$obj->update('Sandeep Singh','sks@gmail.com','6202035471','Bihar','123456','1','1',$conn,31); 
//$obj->read($conn); 
?> 
