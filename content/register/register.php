<?php
echo"register.php"; ?>

<html>

<form method="POST" action="index.php?content=K_L_anlegen">

    <p> <b> Nutzerame </b></p>
    <input type="text" name="Nutzername" required> <br>

    <p> <b> E-Mail </b></p>
    <input type="text" name="Anschrift" required>  <br>

    <p><b> Passwort</b></p>
    <input type="password" name="Passwort" pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" title="Mindestenst eine Zahl, ein kleiner und ein großer Buchstabe und mindestenst 8 Zeichen"  required> <br>

    <input type="submit" value="Senden">
    <input type="reset" value="Löschen">

</form>

</html>
