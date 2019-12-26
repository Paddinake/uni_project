<?php
include('db.php');

if (!isset($_SESSION)) {
    session_start();
	}

if (isset($_POST['Nutzername']) && isset($_POST['Passwort'])) {
	$Name = $_POST["Nutzername"];
	$Passwort = $_POST["Passwort"];
    
    $hash = hash('sha256', $Passwort);

    $sql = "SELECT user_id FROM user WHERE name='$Name' AND passwort = '$hash'  ";

    $result = mysqli_query($con, $sql);
	$user=mysqli_fetch_array($result,MYSQLI_NUM);
    #$user = mysqli_fetch_array($result);


    if ($user != null) {

        $_SESSION["user_id"] = $user[0];
		$_SESSION["loggedin"] = true;
		
		
        header('Location: index.php');
    } else {
        $message = "falsche Zugangsdaten";
        echo "<script type='text/javascript'>alert('$message');</script>";


    }

}


if (isset($_SESSION["user_id"])) {
	header('Location: index.php');

} else {
	?>

    <div id= "login" style="padding: 40px 100px">
        <form action="index.php?content=login" class="was-validated" method="POST" style="text-align:center;">
            <div class="form-group">
				<input type="text" class="form-control" placeholder="Nutzername" name="Nutzername" required>
				<div class="valid-feedback">Valid.</div>
    <div class="invalid-feedback">Please fill out this field.</div>
			</div>
			
			<div class="form-group">
            <input type="password" class="form-control" name="Passwort" placeholder="Passwort"  required></br>
			<div class="valid-feedback">Valid.</div>
    <div class="invalid-feedback">Please fill out this field.</div>
			</div>
			
			<input type="submit" class="btn btn-primary" value="Login">
        </form>
		</br>
		<form method="get" action="register.php" style="text-align:center;">
			<input class="btn btn-primary" type="submit" value="Registrieren">
		</form>
    </div>
    </br>

<?php
}
?>