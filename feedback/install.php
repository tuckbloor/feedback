<?php session_start();
error_reporting(0); ?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Install</title>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
<style type="text/css">
	#container {
		width: 400px;
		margin: 0 auto;
		text-align: center;
		background-color: #f3f3f3;
		padding: 10px;
		border-radius: 10px;
	}
	label {
		float: left;
		display: block;
		margin: 3px 0px;
		width: 160px;
		text-align: right;
	}

	input {
		margin: 3px 0px;
	}
	.left {
		text-align: left;
	}
</style>
</head>

<body>
<div id="container">	
<div id="database">	
<h2>Database Settings</h2>	
<form method="post">
	<label for="host">Host:</label>
	<input type="text" name="host" id="host" /><br />

	<label for="username">Username:</label>
	<input type="text" name="username" id="username" /><br />	

	<label for="password">Password:</label>
	<input type="text" name="password" id="password" /><br />

	<label for="database">Database:</label>
	<input type="text" name="database" id="database" /><br />

	<label>&nbsp;</label>
	<input type="submit" name="submit" value="Next" /><br />
</form>
</div>
<?php

 if(isset($_POST['submit']))
 {
 	$host = trim($_POST['host']);
	$username = trim($_POST['username']);
	$password = trim($_POST['password']);
	$database =  trim($_POST['database']);


$conn = mysql_connect($host, $username, $password);
if(!$conn)
{
 die('Not connected');
}


$db_select = mysql_select_db("$database");
if(!$db_select)
{
	 die('Database Not Available');
}



if($conn and $db_select)
{
$_SESSION['host']=$host;
$_SESSION['username']=$username;
$_SESSION['password']=$password;
$_SESSION['database']=$database;
?>
<p>The database looks Good Now For Emails And itemprop</p>
<p>Image should be the route to your logo or similar</p>
<form method="post">
	<label for="image">Image:</label>
	<input type="text" name="image" id="image" /><br /> 

	<label for="company">Company Name:</label>
	<input type="text" name="company" id="company" /><br />	

	<label for="to">Email Address:</label>
	<input type="text" name="to" id="to" /><br />

	<label for="from">From Email Address:</label>
	<input type="text" name="from" id="from" /><br />

	<label>&nbsp;</label>
	<input type="submit" name="finish" value="Finish" /><br />
</form>
<script type="text/javascript">
	$("#database").hide();
</script>
<?php }
}


if(isset($_POST['finish']))
{
	?>

<script type="text/javascript">
	$("#database").hide();
</script>
	<?php
	$host = $_SESSION['host'];
	$username = $_SESSION['username'];
    $password = $_SESSION['password'];
	$database = $_SESSION['database'];

	 mysql_connect($host, $username, $password) or die(mysql_error());
     mysql_select_db($database) or die(mysql_error());

     $image = $_POST['image'];
     $company = $_POST['company'];

     $to = $_POST['to'];
     $from = $_POST['from'];


mysql_query("CREATE TABLE comments(
id INT NOT NULL AUTO_INCREMENT, 
PRIMARY KEY(id),
 name VARCHAR(255), 
 email VARCHAR(255),
 url VARCHAR(255),
 comment text,
 rating VARCHAR(50),
 active int)")
 or die(mysql_error());  


			
            $openFile = "config.php";
            $fh = fopen($openFile, 'w') or die("can't open file");
            $info = "<?php
            \$db = '$database';
            \$host= '$host';
            \$username = '$username';
            \$password = '$password';
			
            \$photo = '$image';
	        \$company = '$company';

	        \$to = '$to';
	        \$from = '$from';
            ?>";
             fwrite($fh, $info);
             fclose($fh); 
 echo "<div class=\"left\">";
 echo "<p>1)Table Created!</p>"; 
 echo "<p>2) config.php Created</p>";
 echo "<p>3) Now change the permissions of config.php so that it is not writable</p>";
 echo "<p>4) Delete install.php</p>";
 echo "<p>5) Move / Rename admin.php to a password protected area";
 echo "<p>6) Database Configuration Complete</p>";
 echo "<h2>Now To Install The feedback.php</h2>";
 echo "<p>1) add to the &lt;head&gt;<p>&lt;link href=&quot;feedback/css/feedback.css&quot; style=&quot;text/css&quot; rel=&quot;stylesheet&quot;&gt;</p>";
 echo "<p>&lt;script type=&quot;text/javascript&quot; src=&quot;feedback/js/jquery-1.8.3.min.js&quot;&gt;&lt;/script&gt;</p>";
 echo "<p>2) add to the &lt;body&gt; where you want the feedback to show";
 echo "<p>&lt;?php <br />";
 echo "include &quot;feedback/feedback.php&quot;;<br />";
 echo "?>";
 echo "<p>Thats It.</p>";
 echo "</div>";
          }

?>
</div>
</body>
</html>