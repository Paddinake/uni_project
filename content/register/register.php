<?php


if (!empty($_POST['Nutzername'])) {
 include'db.php';
 $Name = $_POST["Nutzername"];
 $email = $_POST["email"];
 $Passwort = $_POST["Passwort"];
 $hash = hash('sha256', $Passwort);
 

#$x1 = (int)(rand(0, 10));
#$x2 = (int)(rand(0, 10));

/*if ( isset( $_POST['Ergebnis'] ) ) {
    $Ergebnis = $_POST['Ergebnis'];
	$trueValue = $_POST['trueValue'];
	echo $Ergebnis;
	echo $trueValue;

	if ($Ergebnis != $trueValue ) {
        $message = "falsches ergebnis";
	echo "<script type='text/javascript'>alert('$message');</script>";}
	echo "fehler";} 
	
	
	## aus html teil ###
	<p><b> Zum fortfahren folgende Aufgabe lösen</b></p>
       <input type="text" placeholder="<?php echo $x1; ?> + <?php echo $x2; ?>" name="Ergebnis" required/>
        <br>
<input type="hidden" name="trueValue" value="<?php echo $x1+$x2; ?>" > 
	
	
	*/
	$sql="INSERT INTO user (name, email, passwort) VALUES ('$Name', '$email', '$hash')";
		mysqli_query($con, $sql) or die ("Fehlgeschlagen! SQL-Error: ".mysqli_error($con));
	echo "<b>  <span style='color:green'> gesendet  </span> </b>";  
}


	#else {
	#	echo "gesendet";
	#}

    

?>


<html>
<head>
    <link rel="stylesheet" type="text/css" href="main.css" />
    <title>Aktien</title>
</head>
<body>
<div id="wrapper">
    <div id="header">
        <h1>Registierung </h1>
		<div id= "login">
		<form method="get" action="login.php" style="text-align:right;">
			<input type="submit" value="Login">
		</form>
		</div>
		
    </div>
    <style>
        body  {

            background-color: #cccccc;
        }
    </style>

<form method="POST" action="register.php">

<p> <b> Nutzername </b></p>
<input type="text" name="Nutzername" required> <br>

<p> <b> E-Mail </b></p>
<input type="text" name="email" required>  <br>

<p><b> Passwort</b></p>
<input type="password" name="Passwort" required> <br>
<input type="submit" value="Senden"> <input type="reset" value="Löschen">

</form>
</body>
</html>