<?php

include 'db.php';

if (!$con) {
	die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION)) {
	session_start();
}


echo '<h2>Neues Thema erstellen</h2>';

if($_SERVER['REQUEST_METHOD'] != 'POST')
{
	//Bereich auswählen in der Beitrag erscheinen soll
	$sql = "SELECT * FROM bereich";

	$result = mysqli_query($con, $sql);

	// formular für neues Thema
	echo '<div class="container">';
	echo '<form method="post" action=""> 
				<div class="form-group"> 
				<label for="t_subject">Thema</label>
				<input class="form-control" name="t_subject" type="text"> <br>
				<label for="t_bereich">Themenbereich</label>';

	echo '<select class="form-control" name="t_bereich">';
	while($row = mysqli_fetch_assoc($result))
	{
		echo '<option value="' . $row['b_id'] . '">' . $row['b_name'] . '</option>';
	}
	echo '</select> <br>';

	echo '
						<label for = "post_content">Beitrag</label>
						<textarea name="post_content" class = "form-control" rows = "3"></textarea> <br>
						<button type="submit" class="btn btn-primary">Senden</button>
						</form>
						</div>
						</div>';
}


else
{
	//SQL Abfrage starten
	$query  = "Start;";
	$result = mysqli_query($con, $query);

	// Einträge des "Forumlars" speichern
	// themendaten in SQL-Tabelle Thema einfügen, danach den Beitrag zum Thema in der Tabelle "posts" speichern
	$sql = "INSERT INTO thema(t_subject,t_date, t_bereich, t_ersteller)
			   VALUES('" . mysqli_real_escape_string($con, $_POST['t_subject']) . "',NOW(),"
		. mysqli_real_escape_string($con, $_POST['t_bereich']) . "," . $_SESSION['user_id'] . ")";
	$result = mysqli_query($con, $sql);

	// in tabelle posts den Beitrag zum Thema einfügen, sowie die nötigen weiteren Daten (datum, ersteller...)
	$topicid = mysqli_insert_id($con);
	$sql = "INSERT INTO posts(p_inhalt, p_date, p_thema, p_ersteller) VALUES 
				('" . mysqli_real_escape_string($con, $_POST['post_content']) . "',NOW(), "
		. $topicid . ", " . $_SESSION['user_id'] . ")";
	$result = mysqli_query($con, $sql);
	$sql = "Senden;";
	$result = mysqli_query($con, $sql);
	//bei erfolgreicher Abfrage -> Thema erstellt
	echo 'Dein Thema wurde erfolgreich erstellt. <a href="index.php?content=forum&subnav=topics&id='. $topicid . '"> Zum Thema</a>.';

}




?>
