<?php
include('db.php');
if (!$con) {
    die("Connection failed: " . mysqli_connect_error());
	}

if (!isset($_SESSION)) {
    session_start();
	}

if (isset($_POST['Nutzername']) && isset($_POST['Passwort'])) {
	$Name = $_POST["Nutzername"];
	$Passwort = $_POST["Passwort"];
    
    $hash = hash('sha256', $Passwort);

    $sql = "SELECT user_id FROM user WHERE name='$Name' AND passwort = '$hash'  ";

    $result = mysqli_query($con, $sql);
    $user = mysqli_fetch_array($result);


    if ($user != null) {

        $_SESSION["user_id"] = $user[0];
		
		
        header('Location: index.php?content=home');
    } else {
        $message = "falsche Zugangsdaten";
        echo "<script type='text/javascript'>alert('$message');</script>";


    }

}


if (isset($_SESSION["user_id"])) {
	header("Location: index.php?content=home");

} else {
	?>
<html>
<head>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>Aktien</title>
</head>
<body>
<body>
<div id="wrapper">
    <div id="header">
        <h1>Anmeldung</h1>
    </div>
<style>
	body  {
  
  background-color: #cccccc;
}
	</style>

    <div id= "login">
        <form action="login.php" method="POST" style="text-align:center;">
            <label for="Nutzername"> </label>
            <input type="text" placeholder="Nutzername" name="Nutzername"required></br>

            <label for="Passwort"> </label>
            <input type="password" name="Passwort" placeholder="Passwort" required ></br>
            <input type="submit" value="Login">
			
        </form>
		<form method="get" action="register.php" style="text-align:center;">
			<input type="submit" value="Registrieren">
		</form>
    </div>
    
	
</body>

</html>
<?php
}
?>