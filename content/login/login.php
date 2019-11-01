<?php
echo"login.php";
?>


<html>

<body>
<body>
<div id="wrapper">
    <div id="header">
        <h1>Anmeldung</h1>
    </div>

    <div id= "login">
        <form action="login.php" method="POST" style="text-align:center;">
            <label for="Nutzername"> </label>
            <input type="text" placeholder="Nutzername" name="Nutzername"required></br>

            <label for="Passwort"> </label>
            <input type="password" name="Passwort" placeholder="Passwort" required ></br>
            <input type="submit" value="Login">

        </form>

    </div>
    <div class="clear">
    </div>
    <div id="footer">

    </div>
</body>

</html>
