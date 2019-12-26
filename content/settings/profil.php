<?php
include 'db.php';
include 'index.php';

if (isset($_GET['first']))
{
    $u_name = $_GET['first'];
    $sql = "SELECT * FROM user WHERE name='$u_name'";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows ($result) == 0) {
        echo "Kein Ergebnis";
        }
    else {
        if($row = mysqli_fetch_assoc($result)) {
            echo '<h1>Profil von: '.$row["name"]."</h1>";
            echo '<table>';
            echo '<tr><td>User-ID:</td><td>'.$row["user_id"].'</td></tr>';
            echo '<tr><td>Nutzername:</td><td>'.$row["name"].'</td></tr>';
            echo '<tr><td>E-Mail:</td><td>'.$row["email"].'</td></tr>';
            }
        echo '</table>';
    }

}
else {

    echo '<h2>Alle Nutzer:</h2>';

    $sql = "SELECT * FROM user";

    $result = mysqli_query($con, $sql);

    if (mysqli_num_rows ($result)==0) {
        echo "Kein Ergebnis";
        }
    else {
        while($row = mysqli_fetch_assoc($result)) {

            echo '<hr />';
            echo '<table>';
            echo '<tr><td>User-ID:</td><td>'.$row["user_id"].'</td></tr>';
            echo '<tr><td>Nutzername:</td><td>'.$row["name"].'</td></tr>';
            echo '<tr><td>E-Mail:</td><td>'.$row["email"].'</td></tr>';
            echo '</table>';

        }
    }


}