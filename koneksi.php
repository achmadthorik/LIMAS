
<?php
//Connect To Mysql
$host="localhost";
$user="root";
$password="";
$db_name="bosmasem";
$conn=mysqli_connect($host,$user,$password,$db_name);
if($conn->connect_error)
{
  die("Connection Failed : ".$conn->connect_error);
}
?>