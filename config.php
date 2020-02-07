<?php
error_reporting(0);
session_start();

	class Dbconnect{
		public $host,$user,$password,$dbname;
		public function set_connect($host , $user , $password , $dbname){
				$this->host=$host;
				$this->user=$user;
				$this->password=$password;
				$this->dbname=$dbname;
			}
		public function get_connect(){
			$conn=array($this->host,$this->user,$this->password,$this->dbname);
			$conn1=mysqli_connect($conn[0],$conn[1],$conn[2],$conn[3]);
			return $conn1;
			}
		}
		$connect = new Dbconnect;
		$connect->set_connect("localhost","phptest","phptest","phptest");
	    $conn1=$connect->get_connect();
	    //print_r($conn1);
		
?>
