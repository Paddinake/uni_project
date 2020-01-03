<?php
if (isset($_SESSION["user_id"])) {
    header('Location: index.php');
}

//toDo: error handling if email is already in use
if (!empty($_POST['Nutzername'])&&!empty($_POST['email'])&&!empty($_POST['Passwort'])) {
 include'db.php';
 $Name = $_POST["Nutzername"];
 $email = $_POST["email"];
 $Passwort = $_POST["Passwort"];
 $hash = hash('sha256', $Passwort);

 $premium = 0;
 if (isset($_POST['premium'])){
     $premium = 1;
 }

 $sql="INSERT INTO user (name, email, passwort, premium) VALUES ('$Name', '$email', '$hash', '$premium')";
 mysqli_query($con, $sql) or die ("Fehlgeschlagen! SQL-Error: ".mysqli_error($con));
 echo "<b>  <span style='color:green'> gesendet  </span> </b>";
}

?>


<html>
<head>
</head>
<body>
<div class="container">
  <h2>Registierung</h2>
	<form method="POST" action="index.php?content=register" >
			
		<div class="form-group">
			<label for="Nutzername">Nutzername:</label>
			<input type="text" class="form-control" id="Nutzername" placeholder="Enter Nutzername" name="Nutzername">
			<label for="email">Email:</label>
			<input type="text" class="form-control" id="email" placeholder="Enter email" name="email">
			<label for="Passwort">Password:</label>
			<input type="password" class="form-control" id="Passwort" placeholder="Enter passwort" name="Passwort">
            <label for="premium">Ja, ich möchte Premiumnutzer sein:</label>
            <input type="checkbox" class="form-control" id="premium" value="true" name="premium">
		</div>
		<button type="submit" class="btn btn-primary">Registrieren</button>
		<button type="reset" class="btn btn-danger">Löschen</button>
	</form>
	</br>	
</div>
   
</body>
</html>