<script type="text/javascript">
$(document).ready(function() {
   
    $('#comment').bind("keyup", function(e) {
    count=$("#comment").val().length; 
    $('#comment').keypress(function(e) {
    var tval = $('#comment').val(),
        tlength = tval.length,
        set = 200,
        remain = parseInt(set - tlength);
    $('#count').text(remain);
    if (remain <= 0 && e.which !== 0 && e.charCode !== 0) {
        $('#comment').val((tval).substring(0, tlength - 1))
    }
})
	});
});
</script>

<?php
	include "config.php";
	include "classes/feedback.class.php";
	include "connect.php";
    $url =  $_SERVER['REQUEST_URI'];

	if(isset($_POST['submit']))
	{
		$name = trim(strip_tags(mysql_real_escape_string($_POST['name'])));
		$email = trim(strip_tags(mysql_real_escape_string($_POST['email'])));
		$rating = trim(strip_tags(mysql_real_escape_string($_POST['rating'])));
		$comment = trim(strip_tags(mysql_real_escape_string($_POST['comment'])));
		$lastname = trim($_POST['lastname']);

		$feedback = new Feedback();
		$feedback->name($name);
		$feedback->lastname($lastname);
		$feedback->email($email);
		$feedback->comment($comment);
		$feedback->rating($rating);
		$feedback->url($url);
		echo $feedback->validate();
	}
?>	

<div id="feedback-form">
<form method="post">
	<label for="name">Name: </label>
	<input type="text" name="name" id="name"/><br />
	<input type="text" name="lastname" style="display: none;" />
	<label for="email">Email: </label>
	<input type="text" name="email" id="email"/><br />	
	<label>Rating: </label>
	<select name="rating">
		<option value="1">Poor</option>
		<option value="2">Average</option>
		<option value="3">Good</option>
		<option value="4">Very Good</option>
		<option value="5" selected>Excellent</option>
	</select>
	<br />

	<label>Comment: </label>
	<textarea name="comment" id="comment"></textarea>
	<label id="count"></label>
	<br />
	<label>&nbsp;</label>
	<input type="submit" name="submit" value="Leave Comment">
</form>
</div>

<?php
 $numStars = 0;
 $select = mysql_query("SELECT * FROM comments where url = '$url' and active='1'") or die(mysql_error());
 while($row = mysql_fetch_array($select))
 {
 	$email = $row['email'];
 	$hash = md5($email);
 	$name = $row['name'];
 	$ratings = $row['rating'];
 	$rating = "$ratings" . "star.png";
 	$numStars = $numStars + $ratings;

 	echo "<div class=\"comments\">";
 	echo "<img src=\"http://www.gravatar.com/avatar/$hash?s=60\" class=\"float image\" alt=\"image\"/>";
 	echo "<p><strong>$name</strong> Gave This Product ";
  	echo "<img src= \"feedback/images/$rating\" alt = \"Rating\"  width=\"80\" /></p>";
    echo "<p>" . $row['comment'] . "</p>";
    echo "</div>";
 }

$num = mysql_num_rows($select);
if($num > 0)
{
$average = ($numStars / $num); 
}
else {
	$average = 0;
}
 ?>

  <div itemscope itemtype="http://data-vocabulary.org/Review-aggregate">
    <span itemprop="itemreviewed"><?php echo $company; ?></span>
    <img itemprop="photo" src="<?php echo $photo; ?>" width="80" alt="image" />
    <span itemprop="rating" itemscope itemtype="http://data-vocabulary.org/Rating">
      <span itemprop="average"><?php echo number_format($average,2); ?></span>
      out of <span itemprop="best">5</span>
    </span>
    based on <span itemprop="votes"><?php echo $num; ?></span> ratings.
    <span itemprop="count"><?php echo $num; ?></span> user reviews.
  </div>