<?php 
include ('constants.php');
mysql_connect(HOST,DB_NAME,DB_PASS) or die("cannot connect"); 


mysql_select_db(DB_NAME)or die("cannot select DB");



$user_id= $_POST['user_id'];
$todo=$_POST['todo'];


function getTodo($user_id){
		$query = "SELECT `text` FROM todos WHERE user_id= $user_id";
		// Perform Query
		$result = mysql_query($query);
		$todos = array();
		while ($row = mysql_fetch_assoc($result)) {
			$todos[] = $row['text'];
		}
		return implode(',', $todos);

	}

    $fulltodo= getTodo($user_id);

    function getLevel($user_id){
    	$query= "SELECT max(level) as level FROM todos WHERE user_id=$user_id";
    	$result = mysql_query($query);
		$row=  mysql_fetch_assoc($result);
		$result = $row['level'];
		
		if($result== NULL){
    		return 0;
    	}else{
    		return $result;
    	}
    }

    $level= getLevel($user_id) + 1;

$sql = "INSERT INTO todos (`text`,`user_id`, `level`) VALUES ('".$todo."','".$user_id."', '".$level."')"; 

mysql_query($sql);

echo "<meta http-equiv='refresh' content='0;url=index.php'>";


mysql_close();

?> 