<?php
header("content-type: text/xml");
echo "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>";
//Twilio Response and logging
//�2012 Matt Auerbach
//Written for Twilio Jacket App
include ('constants.php');

date_default_timezone_set('America/New_York'); //set time zone


//Initialize all variables
$SmsSid = '';
$AccountSid = '';
$From = '';
$To = '';
$Body = '';
$FromCity = '';
$FromState = '';
$FromZip = '';
$FromCountry = '';
$ToCity = '';
$ToState = '';
$ToZip = '';
$ToCountry = '';

//Populate variables(if they exist)
isset($_POST['SmsSid'])?$SmsSid = $_POST['SmsSid']:$SmsSid = '';
isset($_POST['AccountSid'])?$AccountSid = $_POST['AccountSid']:$AccountSid = '';
isset($_POST['From'])?$From = $_POST['From']:$From = '';
isset($_POST['To'])?$To = $_POST['To']:$To = '';
isset($_POST['Body'])?$Body = $_POST['Body']:$Body = '';
isset($_POST['FromCity'])?$FromCity = $_POST['FromCity']:$FromCity = '';
isset($_POST['FromState'])?$FromState = $_POST['FromState']:$FromState = '';
isset($_POST['FromZip'])?$FromZip = $_POST['FromZip']:$FromZip = '';
isset($_POST['FromCountry'])?$FromCountry = $_POST['FromCountry']:$FromCountry = '';
isset($_POST['ToCity'])?$ToCity = $_POST['ToCity']:$ToCity = '';
isset($_POST['ToState'])?$ToState = $_POST['ToState']:$ToState = '';
isset($_POST['ToZip'])?$ToZip = $_POST['ToZip']:$ToZip = '';
isset($_POST['ToCountry'])?$ToCountry = $_POST['ToCountry']:$ToCountry = '';



$link = mysql_connect(HOST,DB_NAME,DB_PASS);
	if (!$link) {
		die('Could not connect: ' . mysql_error());
	}
	$db_selected = mysql_select_db(DB_NAME);
	if (!$db_selected) {
		die ('Can\'t use foo : ' . mysql_error());
	}


$currentnumber=$_POST['From'];
$currentmessage=$_POST['Body'];
 

$search = strtolower($_POST['Body']);

	
	$array = explode(" ", $search);
	$firstWord= $array[0];
	$secondItem=$array[1];
	$thirdItem=$array[2];
	$fourthItem=$array[3];
	$fifthItem=$array[4];



	function getUserId($currentnumber){
		$query = "SELECT `number`, `id` FROM users WHERE `number`=$currentnumber";
		// Perform Query
		$number = mysql_query($query);
		if ($row = mysql_fetch_assoc($number)) {
    	
			return $row['id'];
		}
		 return "Unauthorized"; 
	}

	$user_id= getUserId($currentnumber);
	
	$message = str_ireplace('add', '', $search);	
	

	function getTodo($user_id){
		$query = "SELECT `text`, `level` FROM todos WHERE user_id= $user_id";
		// Perform Query
		$result = mysql_query($query);
		$todos = array();
		while ($row = mysql_fetch_assoc($result)) {
			$todos[] = $row['level'].")".$row['text'];
		}

		return implode(', ', $todos);

	}
    
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

    function removeTodo($user_id,$level){
    	$query= "DELETE FROM todos WHERE user_id=$user_id AND level=$level";
    	mysql_query($query);

    }


	if($firstWord=="add"){
	$sql = "INSERT INTO todos (`text`,`user_id`, `level`) VALUES ('".$message."','".$user_id."', '".$level."')"; 
	mysql_query($sql);
	$num=getLevel($user_id);
	$output= "Your new task is: ".$num.":".$message."";
	finals($output);
	}else if($firstWord=="all"){
  		finals(getTodo($user_id));
	} else if($firstWord== "done"){
		removeTodo($user_id, $secondItem);
		$output= "Item #".$secondItem." was deleted";
		finals($output);
	}else if ($firstWord=="newuser"){
		//newuser matt buy computer 
		$name= $secondItem;
		$number= $currentnumber;
		$text= array_slice($array, 2); 
		$text= implode(" ", $text);


	$sql = "INSERT INTO users (`name`,`email`, `number`) VALUES ('".$name."','sms add', '".$number."')"; 
	mysql_query($sql);
	$user_id= getUserId($number);

	$sql = "INSERT INTO todos (`text`,`level`, `user_id`) VALUES ('".$text."','1', '".$user_id."')"; 
	mysql_query($sql);
	finals("Thanks ".$name.". Your first todo is: ".$text.".");
	}else if($firstWord=="help"){
		finals("Add: adds todo item. Done: removes task. All: shows all tasks for completion");
	}else {
		finals("Invaild Command. Text Help");
	}



	
	
function finals($response){

$finals=str_ireplace('&','&amp;',"<Response> \n <Sms> \n ".$response."\n</Sms> \n</Response>");

 echo $finals;
}
	
?>