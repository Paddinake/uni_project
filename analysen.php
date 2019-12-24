<html lang="de">
<head>
    <title>HYPE</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
    <script src="https://use.fontawesome.com/releases/v5.0.8/js/all.js"></script>
    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <link rel="stylesheet" href="main.css"
</head>
<!--Welcome-->
<div class="container-fluid padding" id="prices">
    <div class="row welcome text-center">
        <div class="col-12">
            <h1 class="display-4"> Analyse </h1>
        </div>
        <hr>
        <div class="col-12">
            <p class="lead">
                Alles auf einer Seite
            </p>
        </div>
    </div>
</div>


<!-- Suche -->
<div class="row container-fluid padding center">
    <div class="container-fluid">
        <div id="searchbar">
            <?php
            include "searchbar.php";
            ?>
        </div>
    </div>
</div>

<div class="clearfix"</div>
</div>

<?php
//default if no symbol was selected yet
if(empty($_GET['symbol'])) {
    echo"<h1>bitte erst eine Aktie auswählen</h1>";
} else{
    include ('graphHelper.php');
    $datapoints_STOCK = getDataforGraph("https://query1.finance.yahoo.com/v7/finance/download/".$_GET['symbol']."?period1=738540000&period2=1576796400&interval=1mo&events=div&crumb=UO48Nwtc0Va");
    $datapoints_DIVIDEND = getDataforGraph("https://query1.finance.yahoo.com/v7/finance/download/".$_GET['symbol']."?period1=738540000&period2=1576796400&interval=1mo&events=div&crumb=UO48Nwtc0Va");

?>

<!-- Daten -->
<div class="container">
    <div class="row">
        <div class="col">
            <span class="mr-sm-2"> Name: </span>
            <span class="mr-sm-2">  </span>
        </div>
        <div class="col">
            <span class="mr-sm-2"> WKN: </span>
            <span class="mr-sm-2"> Hier WKN: </span>
        </div>
        <div class="col">
            <span class="mr-sm-2"> ISIN: </span>
            <span class="mr-sm-2"> hier ISIN: </span>
        </div>
        <div class="col">
            <span class="mr-sm-2"> Symbol: </span>
            <span class="mr-sm-2"> <?php echo $_GET['symbol'];?> </span>
        </div>
    </div>

    <!--placeholder aktienkurs-->
    <div class="container">
        <div class="row">
            <label for="stock-symbol" class="mr-sm-2">Aktienkurs</label>
        </div>
        <div class="row">
            <script>
                window.onload = function () {

                    var chart = new CanvasJS.Chart("chartContainer_STOCK", {
                        theme: "light2", // "light1", "light2", "dark1", "dark2"
                        animationEnabled: true,
                        zoomEnabled: true,
                        title: {
                            text: "Aktienkurs"
                        },
                        data: [{
                            type: "area",
                            xValueType: "dateTime",
                            dataPoints: <?php echo json_encode($datapoints_STOCK, JSON_NUMERIC_CHECK); ?>
                        }]
                    }).render();

                }
            </script>
            <div id="chartContainer_STOCK" style="height: 370px; width: 100%;"></div>
        </div>
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Woche</a></li>
            <li class="page-item"><a class="page-link" href="#">Monat </a></li>
            <li class="page-item"><a class="page-link" href="#">Jahr</a></li>
            <li class="page-item"><a class="page-link" href="#">5 Jahre</a></li>
            <li class="page-item"><a class="page-link" href="#">25 Jahre</a></li>
        </ul>
    </div>

    <div class="clearfix"></div>

    <!--placeholder Dividendenverlauf-->
    <div class="container-fluid">
        <div class="row">
            <label for="stock-symbol" class="mr-sm-2">Dividendenverlauf</label>
        </div>
        <div class="row">
            <script>
                window.onload = function () {

                    var chart = new CanvasJS.Chart("chartContainer_DIVIDEND", {
                        theme: "light2", // "light1", "light2", "dark1", "dark2"
                        animationEnabled: true,
                        zoomEnabled: true,
                        title: {
                            text: "Aktienkurs"
                        },
                        data: [{
                            type: "area",
                            xValueType: "dateTime",
                            dataPoints: <?php echo json_encode($datapoints_DIVIDEND, JSON_NUMERIC_CHECK); ?>
                        }]
                    }).render();

                }
            </script>
            <div id="chartContainer_DIVIDEND" style="height: 370px; width: 100%;"></div>
        </div>
        <ul class="pagination">
            <li class="page-item"><a class="page-link" href="#">Woche</a></li>
            <li class="page-item"><a class="page-link" href="#">Monat </a></li>
            <li class="page-item"><a class="page-link" href="#">Jahr</a></li>
            <li class="page-item"><a class="page-link" href="#">5 Jahre</a></li>
            <li class="page-item"><a class="page-link" href="#">25 Jahre</a></li>
        </ul>
    </div>

    <div class="clearfix"></div>

    <!--placeholder data table -->
    <div class="container">
        <h2>Kennzahlen</h2>
        <p>Diese Zahlen erlauben eine schnelle Einschaetzung der Qualitaet der Dividende:</p>
        <table class="table table-striped">
            <thead>
            <tr>
                <th>Kennzahl</th>
                <th>Wert</th>
                <th>Ampel</th>
            </tr>
            </thead>
            <tbody>
            <tr>
                <td>KGV</td>
                <td>1.2</td>
                <td>GRUEN</td>
            </tr>
            </tbody>
        </table>
    </div>

</div>
<div class="clearfix"></div>
</html>
<?php
}
?>