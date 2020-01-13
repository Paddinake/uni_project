<?php

include 'db.php';
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
}

if (!isset($_SESSION)) {
    session_start();
}


//Alle Themen der Kategorie abfrage (mit $_GET['cat_id'] )
$sql = "SELECT * FROM bereich WHERE b_id = " . mysqli_real_escape_string($con, $_GET['id']);

$result = mysqli_query($con,$sql);

if(!$result)
{
    echo 'Es gab einen Fehler...' . mysqli_error($con);
}
else
{
    while($row = mysqli_fetch_assoc($result))
    {
        echo '<h2>Themen in Kategorie:  '. $row['b_name'] . '</h2><br />';
    }

    $sql = "SELECT * FROM thema WHERE t_bereich = " . mysqli_real_escape_string($con,$_GET['id']);

    $result = mysqli_query($con,$sql);

    if($result)
    {
        if(mysqli_num_rows($result) == 0)
        {
            echo 'Bisher gibt es noch keine Themen in dieser Kategorie! <a href="index.php?content=forum&subnav=createTopic"> Jetzt Thema erstellen</a>';
        }
        else
        {
            //Tabelle anlegen wo Themen zu sehen sind
            echo ' <div class="container">
				<table class="table table-hover">
					  <tr>
						<th>Thema</th>
						<th>Erstellt am</th>
					  </tr>';

            while($row = mysqli_fetch_assoc($result))
            {
                echo '<tr>';
                echo '<td class="leftpart">';
                echo '<h3><a href="index.php?content=forum&subnav=topics&id=' . $row['t_id'] . '">' . $row['t_subject'] . '</a><br /><h3>';
                echo '</td>';
                echo '<td class="rightpart">';
                echo date('d-m-Y', strtotime($row['t_date']));
                echo '</td>';
                echo '</tr>';
            }
            echo "</table>";
        }
    }
}


?>