<?php

include 'db.php';
echo '<h2>Neue Kategorie erstellen</h2>';
if($_SERVER['REQUEST_METHOD'] != 'POST')
{
    // Formular erstellen um Kategorie anzulegen
    echo '<div class="container">';
    echo '<form method="post" action="">
				<div class="form-group">
				<label for="b_name">Name</label>
				<input class="form-control" name="b_name" type="text"> <br>
				<label for = "b_inhalt">Beschreibung</label>
				<textarea name="b_inhalt" class = "form-control" rows = "3"></textarea> <br>
				<button type="submit" class="btn btn-primary">Senden</button>
				</form> </div> </div>';
}
else
{
    // Daten aus Formular in DB eintragen
    $sql = "INSERT INTO bereich(b_name, b_inhalt)
		   VALUES('" . mysqli_real_escape_string($con, $_POST['b_name']) . "',
				 '" . mysqli_real_escape_string($con, $_POST['b_inhalt']) . "')";
    $result = mysqli_query($con, $sql);
    if($result)
    {
        echo 'Die Kategorie wurde erfolgreich erstellt. <a href="index.php?content=forum&subnav=createTopic"> Jetzt Thema posten</a>.';

    }
}


?>

<html>

<html>