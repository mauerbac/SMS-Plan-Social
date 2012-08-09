<?php 
include ('constants.php');
mysql_connect(HOST,DB_NAME,DB_PASS) or die("cannot connect"); 


mysql_select_db(DB_NAME)or die("cannot select DB");



$email= $_POST['email'];
$todo=$_POST['todo'];



  function getUserId($email){
    	$query= "SELECT `id` FROM users WHERE email='$email'";
    	$result = mysql_query($query);
		$row=  mysql_fetch_assoc($result);
		$id= $row['id'];
		return $id;	
    }

    $user_id= getUserId($email);

$sql = "INSERT INTO todos (`text`,`user_id`, `level`) VALUES ('".$todo."','".$user_id."', '1')"; 

mysql_query($sql);

echo "<meta http-equiv='refresh' content='0;url=index.php'>";


mysql_close();

?> 