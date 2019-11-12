<?php
echo "Startseite<br>";

include ('db.php');

if (isset($_SESSION['user_id']))
{
	$x= $_SESSION['user_id'];
	$sql = "SELECT name FROM user WHERE user_id='$x'";
	$result = mysqli_query($con, $sql);
	while($row = mysqli_fetch_assoc($result)) {
	echo 'Welcome Nutzer:'.$row["name"];}
}
else
{
	echo "You are not logged in!";
}

?>
				
				
	

		