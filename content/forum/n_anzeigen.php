<?php

include 'db.php';

$sql = "SELECT * FROM user";
$result = mysqli_query($con, $sql);

if (mysqli_num_rows ($result) ==0) {
	echo "Kein Ergebnis";
}

else {
    echo '<table>';
    while($row = mysqli_fetch_assoc($result)) {
        $u_name = $row["name"];
        echo '<tr><td><a href="profil.php?first='.$u_name.'">'.$u_name.'</a><br /></td></tr>';
		
    }
	echo '<tr><td><a href="profil.php">Alle Nutzer anzeigen</a><br /></td></tr>';
    echo '</table>';
}

?>

<html>
<head> </head>
<body>
    <label for="Nach Nutzern suchen"> </label>
    <form action="index.php?content=n_anzeigen" method="post" enctype="multipart/form-data">
        <input type="text" name="name" placeholder="Nutzername" required>
        <input type="submit" value="Search" name="submit">
    </form>

<?php

if (isset($_POST['name']))
{
    $u_name = $_POST['name'];

    $sql = "SELECT * FROM user WHERE name='$u_name';";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows ($result) == 0) {
        echo "Kein Ergnis"; }
    else {

        ?>

        <h3>Search results:</h3>

        <?php
        while($row = mysqli_fetch_assoc($result)) {
            echo '<table>';
            echo '<tr><td>User-ID:</td><td>'.$row["user_id"].'</td></tr>';
            echo '<tr><td>Nutzername:</td><td>'.$row["name"].'</td></tr>';
            echo '<tr><td>E-Mail:</td><td>'.$row["email"].'</td></tr>';
            echo '</table>';
            echo '<hr />';
        }
    }

}

?>
</body>
</html>
