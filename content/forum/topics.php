<?php
include 'db.php';

$sql = "SELECT * FROM thema WHERE thema.t_id = " . mysqli_real_escape_string($con, $_GET['id']);
$result = mysqli_query($con,$sql);

while($row = mysqli_fetch_assoc($result))
{
    //Name des Thema darstellen (obige SQL Abfrage)
    echo ' 	<div class="container">
	<h2>' . $row['t_subject'] . '</h2>
	<table class="table">';
    //Posts aus der SQL Datenbank abfragen
    $posts_sql = "SELECT posts.p_thema, posts.p_inhalt, posts.p_date, posts.p_ersteller, user.user_id, user.name
					FROM posts LEFT JOIN user ON posts.p_ersteller = user.user_id
					WHERE posts.p_thema = " .mysqli_real_escape_string($con, $_GET['id']);

    $posts_result = mysqli_query($con,$posts_sql);
    while($posts_row = mysqli_fetch_assoc($posts_result))
    {
        echo ' <table class="table table-striped table-bordered table-hover table-condensed">
    				<tbody>
					<tr class="topic-post">
					<td width="70%"  class="post-content">' . htmlentities(stripslashes($posts_row['p_inhalt'])) . '</td>
					<td width="30%" class="user-post">' . $posts_row['name'] . '<br/>' . date('d-m-Y H:i', strtotime($posts_row['p_date'])) . '</td> ';
    }

    //Antwortbox
    echo '	<tr><td colspan="2"><br />
			<form method="post" action="index.php?content=forum&subnav=reply&id=' . $row['t_id'] . '">
			<div class="form-group">
			<label for = "reply-content">Antworten</label>
			<textarea name="reply-content" class = "form-control" rows = "3"></textarea> </br>
			<button type="submit" class="btn btn-primary">Antworten</button>
			</form> </td></tr>
			</tbody></div>';

    //Tabelle schließen
    echo '</table>';
}

?>