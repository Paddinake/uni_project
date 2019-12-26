<?php

include 'db.php';

if($_SERVER['REQUEST_METHOD'] != 'POST')
	{
		//the form hasn't been posted yet, display it
		echo '<form method="post" action="">
			Category name: <input type="text" name="b_name" /><br />
			Category description:<br /> <textarea name="b_inhalt" rows="20" cols="100" /></textarea><br /><br />
			<input style= "width:200px" type="submit" value="Add category" />
		 </form>';
	}
	else
	{
		//the form has been posted, so save it
		$sql = "INSERT INTO bereich(b_name, b_inhalt)
		   VALUES('" . mysqli_real_escape_string($con, $_POST['b_name']) . "',
				 '" . mysqli_real_escape_string($con, $_POST['b_inhalt']) . "')";
		$result = mysqli_query($con, $sql);
		if(!$result)
		{
			//something went wrong, display the error
			echo 'Error' . mysqli_error();
		}
		else
		{
			echo "<b>  <span style='color:green'> neue Kategorie erfolgreich erstellt  </span> </b>";
			
		}
	}


?>

<html>

<html>