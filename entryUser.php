<?php 
require "Services/Twilio.php";
include ('constants.php');

mysql_connect(HOST,DB_NAME,DB_PASS)or die("cannot connect"); 


mysql_select_db(DB_NAME)or die("cannot select DB");



$name= $_POST['name'];
$email=$_POST['email'];
$number= $_POST['number'];
 
 $sql ="INSERT INTO users (`name`, `email`, `number`) VALUES('".$name."', '".$email."', '".$number."')";  
     
$result=mysql_query($sql);


  if($result){

}

else {
echo "ERROR";
}

	// Step 2: set our AccountSid and AuthToken from www.twilio.com/user/account
	$AccountSid = ACCOUNT_SID;
	$AuthToken = AUTH_TOKEN;

	// Step 3: instantiate a new Twilio Rest Client
	$client = new Services_Twilio($AccountSid, $AuthToken);

	// Step 4: make an array of people we know, to send them a message. 
	// Feel free to change/add your own phone number and name here.
	$people = array(
		"$number" => "$name");

	// Step 5: Loop over all our friends. $number is a phone number above, and 
	// $name is the name next to it
	foreach ($people as $number => $name) {

		$sms = $client->account->sms_messages->create(

		// Step 6: Change the 'From' number below to be a valid Twilio number 
		// that you've purchased, or the Sandbox number
			NUMBER, //

			// the number we are sending to - Any phone number
			$number,

			// the sms body
			"Thank you for registering!"
		);

		// Display a confirmation message on the screen
		echo "Welcome! You must enter in a first todo! <br />";
		echo "<br /><form name='firstTodo' action='entryFirst.php' method='POST'>

  First Todo: <input type='text' name='todo'  size='20' maxlength='40'/> <br /> 
        <input type='hidden' name='email' value='$email'/> <br />
        <input type='Submit' value='Submit'/>  </form>";

	}

mysql_close();

?> 