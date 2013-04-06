<?php
	include "config.php";
	include "classes/feedback.class.php";
	include "connect.php";
?>
<!doctype html>
<html>
<head>
<meta charset="UTF-8">
<title>Title Goes Here</title>
<script type="text/javascript" src="js/jquery-1.8.3.min.js"></script>
</head>

<body>
	<h2>Feedback Admin</h2>
	<style type="text/css">
 label {
 	float: left;
 	width: 140px;
 	margin-right: 10px;
 	text-align: right;
 }

 input[type="text"] , select, textarea {
 	margin-bottom: 5px;
 	width: 250px;
 }

 #feedback-form {
 	width: 500px;
 	background-color: #f3f3f3;
 	padding: 20px 0;
 	border-radius: 10px;
 }

 .float {
 	float: left;
 	margin-right: 10px;
 }

 .comments {
 	width: 450px;
 	background-color: #F3F3F3;
 	padding: 10px;
 	margin-bottom: 10px;
 }

 .image {
 	background-color: #FFFFFF;
 	padding: 10px;
 	border: solid 1px #333333;
 }
	</style>
<?php
if(isset($_POST['submit']))
{
	$id = $_POST['id'];
	$select = $_POST['select'];
	if($select == "Approve")
	{
		mysql_query("UPDATE comments SET active='1' where id='$id'") or die(mysql_error());
	}
	if($select == "Delete")
	{
		mysql_query("DELETE FROM comments where id='$id'") or die(mysql_query());
	}
}
 $numStars = 0;
$select = mysql_query("SELECT * FROM comments where active='0'") or die(mysql_error());
 while($row = mysql_fetch_array($select))
{
 	$id=$row['id'];
    $email = $row['email'];
 	$hash = md5($email);
 	$name = $row['name'];
 	$ratings = $row['rating'];
 	$rating = "$ratings" . "star.png";
 	$numStars = $numStars + $ratings;
 	echo "<form method=\"post\" action=\"\">";
    echo "<div class=\"comments\">";
 	echo "<p><strong>$name</strong>";
 	echo "<img src=\"http://www.gravatar.com/avatar/$hash?s=60\" class=\"float image\" alt=\"image\"/>";
 	echo "<p><strong>$name</strong> Gave This Product ";
  	echo "<img src= \"images/$rating\" alt = \"Rating\"  width=\"80\" /></p>";
    echo "<p>" . $row['comment'] . "</p>";
    echo "<select name=\"select\">";
    echo "<option>Approve</option>";
    echo "<option>Delete</option>";
    echo "</select>";
    echo "<input type=\"hidden\" name=\"id\" value=\"$id\">";
    echo "<input type=\"submit\" name=\"submit\" value=\"Update\">";
    echo "</div>";
    echo "</div>";
    echo "</form>";
 }
 $num = mysql_num_rows($select);
 if($num == 0)
 {
 	echo "<p>There are no reviews to approve</p>";

 }
 ?>
</body>
</html>