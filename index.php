<?php
    if(!isset($_SESSION)) 
    { 
        session_start(); 
    }
?>

<!DOCTYPE html>
<html lang="de">
<head>
    <title>HYPE</title>
    <meta charset="utf-8">
<!--    TODO: Welche Scripte wir wirklich brauchen raussuchen und dann runterladen-->
    <link rel="icon" type="image/png" sizes="32x32" href="img/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="img/favicon-16x16.png">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="main.css">
    <link href = "https://code.jquery.com/ui/1.10.4/themes/ui-lightness/jquery-ui.css"
          rel = "stylesheet">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
    <script src="https://code.jquery.com/ui/1.10.4/jquery-ui.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">

</head>
<body>

<!--Navigation-->
<nav class="navbar navbar-expand-md navbar-light bg-light sticky-top">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php"><img src="img/hype.png" width="150" height="50" alt="Error">
		
        </a>
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarResponsive">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarResponsive">
            <ul class="navbar-nav ml-auto">
			<?php 
			if (isset($_SESSION["loggedin"]) && $_SESSION['loggedin'] == true){
				?>
                <li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
			<li class="nav-item active"><a class="nav-link" href="index.php?content=analysen">Analysen</a></li>
			<li class="nav-item dropdown active"><a class="nav-link dropdown-toggle" data-toggle="dropdown" href="#">Forum</a>
				<div class="dropdown-menu">
					<a href="index.php?content=forum&subnav=home2" class="dropdown-item"> Home</a>
					<a href="index.php?content=forum&subnav=t_erst" class="dropdown-item"> Create a topic</a>
				</div>
				</li>
			<li class="nav-item active"><a class="nav-link" href="index.php?content=settings">Einstellungen</a></li>
			<li class="nav-item active"><a class="nav-link" href="index.php?content=logout">Log out</a></li>
				<?php 
			} else{
			?>
			<li class="nav-item active"><a class="nav-link" href="index.php">Home</a></li>
				<li class="nav-item active"><a class="nav-link" href="index.php#prices">Preise</a></li>
				<li class="nav-item active"><a class="nav-link" href="index.php#examples">Beispiele</a></li>
				<li class="nav-item active"><a class="nav-link" href="index.php?content=login">Log in</a></li>
				<li class="nav-item active"><a class="nav-link" href="index.php?content=register">Register</a></li>
			<?php
			}
			?>
				
            </ul>
        </div>
    </div>
</nav>

<div id="content">
        <?php
        $content=(isset($_GET['content']))?$_GET['content']:'home';
        switch($content){
            case "analysen":
                include 'content/analysen/main.php';
                break;
            case "forum":
                include 'content/forum/forum.php';
                break;
            case "settings":
                include 'content/settings/settings.php';
                break;
			case "login":
                include 'content/login/login.php';
                break;
			case "logout":
				include 'content/login/logout.php';
				break;
			case "register":
                include 'content/register/register.php';
                break;
            case "impressum":
                include 'content/sonstiges/impressum.php';
                break;
            case "kontakt":
                include 'content/sonstiges/kontakt.php';
                break;
            Default:
                
        ?>


<!--Image Slider-->
<div id="slides" class="carousel slide" data-ride="carousel">
    <ol class="carousel-indicators">
        <li data-target="#slides" data-slide-to="0" class="active"></li>
        <li data-target="#slides" data-slide-to="1" ></li>
        <li data-target="#slides" data-slide-to="2" ></li>
    </ol>
    <div class="carousel-inner">
        <div class="carousel-item active">
            <img src="img/stock.jpg">
            <div class="carousel-caption">
                <h1 class="display-2"> HYPE </h1>
                <h3> Einfaches Stock tool</h3>
                <button type="button" class="btn btn-outline-light btn-lg" onclick="window.location.href='index.php?content=register';"> Get Started</button>
            </div>
        </div>
        <div class="carousel-item">
            <img src="img/dividend.jpg">
        </div>
        <div class="carousel-item">
            <img src="img/hypeslide2.png">
        </div>
    </div>
	 <a class="left carousel-control" href="#slides" data-slide="prev">
    <span class="glyphicon glyphicon-chevron-left"></span>
    <span class="sr-only">Previous</span>
  </a>
  <a class="right carousel-control" href="#slides" data-slide="next">
    <span class="glyphicon glyphicon-chevron-right"></span>
    <span class="sr-only">Next</span>
  </a>
</div>


<!--Jumbotron-->
<div class="container-fluid">
    <div class="row jumbotron">
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9 col-xl-10"></div>
		<h4>Objektive Bewertung</h4>
        <p>
            Dividenden sind eine wichtige Kennzahl von Unternehmen. Wir haben uns als Ziel gesetzt diese 
			Kennzahl zu Analysieren und einfach Darzustellen. Mit Hilfe unsres Tools kann jeder - von Beginner bis Experte
			auf einen Blick sehen, ob sich ein Investment in die ausgewählte Aktie lohnt. </p>
		<p>
			Mit unserer einzigartigen "Ampelfunktion" muss man keine Wirtschaftswissenschaften mehr studiert haben, um zu 
			erkennen ob sich ein Investment - Dividenden fokussiert lohnt.
        </p>
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3 col-xl-2">
            <a href="index.php#examples"><button type="button" class="btn btn-outline-secondary btn-lg"> Mehr Erfahren</button> </a>
        </div>
    </div>
</div>


<!--Welcome-->
<div class="container-fluid padding" id="prices">
    <div class="row welcome text-center">
        <div class="col-12">
            <h1 class="display-4"> Einfaches Preisschema </h1>
        </div>
        <hr>
        <div class="col-12">
            <p class="lead">
                Im folgenden finden Sie eine Übersicht unserer Abo-Möglichkeiten
            </p>
        </div>
    </div>
</div>

<!--3 Spalten Preise-->
<section class="pricing py-5">
  <div class="container">
    <div class="row">
      <!-- Gratis -->
      <div class="col-lg-4">
        <div class="card mb-5 mb-lg-0">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Free</h5>
            <h6 class="card-price text-center">0€<span class="period">/month</span></h6>
            <hr>
            <ul class="fa-ul">
              <li><span class="fa-li"><i class="fas fa-check"></i></span>1 Abfrage pro Minute</li>
			  <li><span class="fa-li"><i class="fas fa-check"></i></span>Übersicht mit allen Kennzahlen</li>
            </ul>
            <a href="#" class="btn btn-block btn-primary">Register</a>
          </div>
        </div>
      </div>
      <!-- Standard -->
      <div class="col-lg-4">
        <div class="card mb-5 mb-lg-0">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Standard</h5>
            <h6 class="card-price text-center">9€<span class="period">/month</span></h6>
            <hr>
            <ul class="fa-ul">
				<li><span class="fa-li"><i class="fas fa-check"></i></span>unlimitierte Abfrage pro Minute</li>
				<li><span class="fa-li"><i class="fas fa-check"></i></span>Übersicht mit allen Kennzahlen</li>
			    <li><span class="fa-li"><i class="fas fa-check"></i></span>Muster-Depot</li>				
            </ul>
            <a href="#" class="btn btn-block btn-primary">Register</a>
          </div>
        </div>
      </div>
      <!-- Premium -->
      <div class="col-lg-4">
        <div class="card">
          <div class="card-body">
            <h5 class="card-title text-muted text-uppercase text-center">Premium</h5>
            <h6 class="card-price text-center">39€<span class="period">/month</span></h6>
            <hr>
            <ul class="fa-ul">
				<li><span class="fa-li"><i class="fas fa-check"></i></span>unlimitierte Abfrage pro Minute</li>
				<li><span class="fa-li"><i class="fas fa-check"></i></span>Übersicht mit allen Kennzahlen</li>
				<li><span class="fa-li"><i class="fas fa-check"></i></span>Muster-Depot</li>
				<li><span class="fa-li"><i class="fas fa-check"></i></span>24h Support</li>
				<li><span class="fa-li"><i class="fas fa-check"></i></span>Anbindung an unsere API</li>	
			</ul>
            <a href="#" class="btn btn-block btn-primary">Register</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- examples -->

<div class="container-fluid padding" id="examples">
    <div class="row welcome text-center">
        <div class="col-12">
            <h1 class="display-4"> Alles auf einer Seite </h1>
        </div>
        <hr>
        <div class="col-12">
            <p class="lead">
                ölkahdsfsklhafjkdfahkjdsfgahdskfasdhfjasdjflgjakdsfglakdjsgskldjfgalkdjsgkal
                kajdhfaöskdjhakjdsfhgakdjfsgasödkfj
                #kjasdfhajskdgkaldfgasfd
            </p>
        </div>
    </div>
</div>

<div class="container-fluid padding">
    <div class="row welcome text-center">
        <div class="col-12">
            <h1 class="display-4"> Genaue Analysen </h1>
        </div>
        <hr>
        <div class="col-12">
            <p class="lead">
                Wir haben diverse Kennzahlen, sowie genaue Graphen. Dadurch ist unsere Website
                nicht nur für Anfänger sondern auch für Profis ideal.
            </p>
            <p class="lead">
                In unseren Graphen können Sie selbst ganz einfach in einen gewünschten Zeitraum reinzoomen
            </p>
            <p class="col-12">
                <img class="img-fluid" src="img/Zoom-Graphs.gif">
            </p>
        </div>
    </div>
</div>
<?php
}
        ?>
<!--footer-->
<footer>
    <div class="container-fluid padding">
        <div class="row text-center">
            <div class="col-md-4">
                <br>
                <img style="max-width:60%" class="img-fluid" src="img/hype.png">
                <hr class="light">
                <p>Telefon: +49 1234 56789</p>
                <p>Email: @students.uni-mainz.de</p>
                <p>Adresse: Saarstraße 21, 55122 Mainz</p>
            </div>
            <div class="col-md-4">
                <hr class="light">
                <h5>Allgemeines</h5>
                <hr class="light">
                <p>erste</p>
                <p>zweite</p>
                <p>dritte</p>
            </div>
            <div class="col-md-4">
                <hr class="light">
                <h5>Unwichtiges</h5>
                <hr class="light">
                <p><a href="index.php?content=kontakt" style=" color: inherit; ">Kontakt</a> </p>
                <p><a href="index.php?content=impressum" style=" color: inherit; ">Impressum</a> </p>
                <p>dritte</p>
            </div>
            <div class="col-12">
                <hr class="light">
                <h5> &copy; Hagen, Yorick, Patrick</h5>
            </div>
        </div>
    </div>
</footer>


</body>
</html>