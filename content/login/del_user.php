<?php
include ('db.php');
session_start();
if (isset($_SESSION['user_id']))
{	
	$message = "Account gelöscht";
    echo "<script type='text/javascript'>alert('$message');</script>";
    $x= $_SESSION['user_id'];
	$sql="DELETE FROM user WHERE user_id = '$x'";
	

if (mysqli_query($con, $sql)) {
    #$message = "Account gelöscht";
    #echo "<script type='text/javascript'>alert('$message');</script>";
    session_destroy();
	#header('Location: login.php');
	header( "refresh:url=3;login.php" );
    
} else {
    echo "Fehlgeschlagen " . mysqli_error($con);
}
}
?>
<html>
<head>
</head>
<body>


</body>
</html>