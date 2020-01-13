<?php

include 'db.php';

// abfrage nach Kategorien und dazu gehörigem thema
$sql = "SELECT bereich.b_id, bereich.b_name, bereich.b_inhalt, COUNT(thema.t_id) AS thema
		FROM bereich LEFT JOIN thema ON thema.t_id = bereich.b_id GROUP BY bereich.b_name, bereich.b_inhalt, bereich.b_id";

$result = mysqli_query($con, $sql);

if(!$result)
{
	echo 'Fehler beim Abrufen der Kategorien.';
}
else
{
	if(mysqli_num_rows($result) >= 0)
	{
		// erstellen der Tabelle
		echo '<table class="table table-hover" id="forum">
			  <tr> <th style="width:50%">Kategorie</th>
					<th>Letzer Eintrag</th>
			  </tr>';

		while($row = mysqli_fetch_assoc($result))
		{
			echo '<tr>';
			echo '<td class="leftpart">';
			echo '<h3><a href="index.php?content=forum&subnav=category&id=' . $row['b_id'] . '">' . $row['b_name'] . '</a></h3>' . $row['b_inhalt'];
			echo '</td>';
			echo '<td class="rightpart">';

			//letzter Eintrag dieser Kategorie
			$lastEntry = "SELECT t_id, t_subject, t_date, t_bereich FROM thema
								WHERE t_bereich = " . $row['b_id'] . " ORDER BY t_date DESC LIMIT 1";

			$lastEntryresult = mysqli_query($con, $lastEntry);

			if($lastEntryresult)
			{
				// gibt es in kategorie noch keinen Eintrag/Thema dann...
				if(mysqli_num_rows($lastEntryresult) == 0)
				{
					echo 'noch keine Themen angelegt ';
				}
				else
				{
					while($topicrow = mysqli_fetch_assoc($lastEntryresult))
						echo '<a href="index.php?content=forum&subnav=topics&id=' . $topicrow['t_id'] . '">' . $topicrow['t_subject'] . '</a> at ' . date('d-m-Y', strtotime($topicrow['t_date']));
				}
			}
			echo '</td>';
			echo '</tr>';
		}echo '</table>';
	}
}


?>

