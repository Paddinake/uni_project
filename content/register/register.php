<?php
echo"register.php";

?>

<html>

<form method="POST" action="index.php?content=register.php" style="text-align:center;">

    <p> <b> Nutzerame </b></p>
    <input type="text" name="Nutzername" required> <br>

    <p> <b> E-Mail </b></p>
    <input type="text" name="email" required>  <br>

    <p><b> Passwort</b></p>
    <input type="password" name="Passwort"  required> <br>

    <input type="submit" value="Senden">
    <input type="reset" value="Löschen">

</form>

</html>
