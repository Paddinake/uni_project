<?php
include ('edit.php');
if (isset($_SESSION['user_id']))
{
	$y= $_SESSION['user_id'];
	if($y==52){
		echo '<form method="get" action="index.php?content=home">
		<input style= "width:400px" type="reset" value="Der User ADMIN kann nicht gelöscht werden">
		</form>';
	}
	else
	{
		echo '<div style="padding-left:10px; padding-bottom:20px;"><form method="get" action="del_user.php"><input class="btn btn-danger" style= "width:200px" type="submit" value="Account löschen"></form></div>';
	}
}
?>