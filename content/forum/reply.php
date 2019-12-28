<?php
//create_cat.php
include 'db.php';
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
	}

if (!isset($_SESSION)) {
    session_start();
	}



		$sql = "INSERT INTO 
					posts(p_inhalt, p_date, p_thema, p_ersteller) 
				VALUES ('" . $_POST['reply-content'] . "',
						NOW(),
						" . mysqli_real_escape_string($con, $_GET['id']) . ",
						" . $_SESSION['user_id'] . ")"
						;
						
		$result = mysqli_query($con, $sql);
		header("Location: index.php?content=forum&subnav=topics&id=".$_GET['id'] );



?>