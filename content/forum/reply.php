<?php
//create_cat.php
include 'db.php';
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
	}

if (!isset($_SESSION)) {
    session_start();
	}


if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//someone is calling the file directly, which we don't want
	echo 'This file cannot be called directly.';
}
else
{
	//a real user posted a real reply
		$sql = "INSERT INTO 
					posts(p_inhalt, p_date, p_thema, p_ersteller) 
				VALUES ('" . $_POST['reply-content'] . "',
						NOW(),
						" . mysqli_real_escape_string($con, $_GET['id']) . ",
						" . $_SESSION['user_id'] . ")"
						;
						
		$result = mysqli_query($con, $sql);
						
		if(!$result)
		{
			echo 'Your reply has not been saved, please try again later.';
		}
		else
		{
			header("Location: index.php?content=forum&subnav=topics&id=".$_GET['id'] );
		}
	}

#
?>