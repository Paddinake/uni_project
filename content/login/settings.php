<?php
include ('db.php');
if (isset($_SESSION['user_id']))
{
	$y= $_SESSION['user_id'];
	if($y==52){
		echo '<form method="get" action="index.php?content=home">
		<input type="reset" value="Der User ADMIN kann nicht gelöscht werden">
		</form>';
	}
	else
	{
		echo '<form method="get" action="del_user.php"><input type="submit" value="Account löschen"></form>';
	}
}

