<htmL>
<head>
<title>SMS Plan Social</title>

<style type="text/css">

body{
  font-family: 'Open Sans', sans-serif;
  font-size: 14px;
  line-height: 24px;
  background-image: url(img/natural_paper.png);
}

h1{
  font-family: Average;
  font-size: 95px;
  background-color: rgba(0, 0, 0, 0.1);
  height: 50px;
  border-top: 19px solid rgba(0, 0, 0, 0.01);
  width: 850px;
}

div.box{
  width: 300px;
  display: inline;
  float: left;
  margin-right: 10px;
  border-right: 1px solid #d0d0d0;
  height: 400px;
}

p.title{
  line-height: 25px;
  font-size: 21px;
  font-family: Average;
  font-weight: bold;
  padding-left: 10px;
}

p.body{
 
}
  strong {
    font-size: 14px;
    font-family: 'Open Sans', sans-serif;
    line-height: 24px;
    font-weight: bold;

  }

li{
  list-style-image: none;
  list-style-type: none;
}

.darkbtn{
  float: left;
  margin: 0 7px 0 0;
  text-decoration: none;
  background-color: whiteSmoke;
  border: 1px solid #DEDEDE;
  border-top: 1px solid #EEE;
  border-left: 1px solid #EEE;
  padding: 5px 15px 6px 15px;
  display: block;
  cursor: pointer;
  font-size: 100%;
  line-height: 130%;
  color: #333;
  font-weight: bold;
}

.darkbtn:hover{
  background-color: #df2f2f2;
}

</style>

<link href='http://fonts.googleapis.com/css?family=Average' rel='stylesheet' type='text/css'>
<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,300' rel='stylesheet' type='text/css'>

</head>
<body>

  <h1><center>SMS Plan Social</h1></center><p />

<a href="entry.html" class="darkbtn"> Add User </a> <br />
<h2>SMS Number: </h2><h1> (914) 368-7725</h1>
<h4> Functions</h4> 
<h4> <u> newuser</u> name task. ex: newuser matt clean house </h4>
<h4> <u>add</u> your task </h4>
<h4> <u>all</u> view all tasks </h4> 
<h4> <u>done</u> task number </h4>

<p /><br />


<?php
include ('constants.php');


$link= mysql_connect(HOST,DB_NAME,DB_PASS); //your DB info
  if(!$link){

   die('cannot connect: ' . mysql_error()); 
}


 $db= mysql_select_db(DB_NAME); //your db name

  if(!$db){
    die('cannot select DB' . mysql_error());
  }

$result = mysql_query("SELECT * FROM todos ORDER BY level ASC") //print all todos
  or die(mysql_error());

//create a todo
function createTodo($user_id){
  echo"<br /><form name='userTodo' action='entryTodo.php' method='POST'>

  Todo: <input type='text' name='todo'  size='20' maxlength='40'/> <br /> 
        <input type='hidden' name='user_id' value='$user_id'/> <br />
        <input type='Submit' class='darkbtn' value='Submit'/>  </form>";
}

    $tasks = array();
    $namesarr = array();
    $i = 0;
    while($row = mysql_fetch_assoc($result)){
      $uid = $row['user_id'];
      $tasks[$uid][$row['level']] = $row['text']; // appends new item to value array
      $newresult = mysql_query("SELECT `name` FROM `users` WHERE `id` LIKE '".$uid."'") or die(mysql_error());
          if ($newresult) {
              while ($col = mysql_fetch_assoc($newresult)) {
              $namesarr[$i++] = $col['name'];
             } 
          }
    }
    //print name
    $j = 0;
    foreach( $tasks as $user_id => $items){
        $name = $namesarr[$j++];
        echo "<div class='box'><p /><p class='title'>$name</p>";
    //print tasks
      foreach ($items as $level=>$item){
        echo "<a href='delete.php?user_id=$user_id&level=$level'><img src='img/delete.png'></a> &nbsp; $item<br />";
      }
        createTodo($user_id); 
        echo "</div>";
    }


  mysql_close($link);
?>
</body>
</html>