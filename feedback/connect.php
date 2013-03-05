<?php
		mysql_connect("$host", "$username", "$password") or die(mysql_error());
        mysql_select_db("$db") or die(mysql_error());
?>