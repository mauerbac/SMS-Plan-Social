<?php
include ('constants.php');

$link= mysql_connect(HOST,DB_NAME,DB_PASS); 
  if(!$link){

   die('cannot connect: ' . mysql_error()); 
}


 $db= mysql_select_db(DB_NAME);

  if(!$db){
    die('cannot select DB' . mysql_error());
  }


$user_id = $_GET['user_id'];
$level = $_GET['level'];

$query= mysql_query("DELETE FROM todos WHERE `user_id` = '".$user_id."' AND `level` = '".$level."'");
mysql_query($query);

mysql_close($link);


header("Location: index.php");

?>
