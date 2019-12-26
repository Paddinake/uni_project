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
</head>
<body>
<div class="container">
  <h2>Registierung</h2>
	<form method="POST" action="index.php?content=register" >
			
		<div class="form-group">
			<label for="email">Nutzername:</label>
			<input type="text" class="form-control" id="Nutzerame" placeholder="Enter Nutzername" name="Nutzername">
			<label for="email">Email:</label>
			<input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
		</div>
		<div class="form-group">
			<label for="pwd">Password:</label>
			<input type="password" class="form-control" id="Passwort" placeholder="Enter passwort" name="Passwort">
		</div>
		<button type="submit" class="btn btn-primary">Senden</button>
		<button type="reset" class="btn btn-danger">Löschen</button>
	</form>
	</br>	
</div>
   
</body>
</html>