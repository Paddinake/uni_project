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
<?php
if(empty($_GET['symbol'])) {
    echo "<div class=\"col-12\">
            <p class=\"lead\">
            bitte erst eine Aktie auswählen
            </p>
            </div>
    ";
}
?>
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

function getDividendenRendite($lastStockprice, $sumDiviInYear){
    return number_format((float)(($sumDiviInYear/$lastStockprice)*100), 2, '.','') ;
}

if(!empty($_GET['symbol'])){
    include('graphHelper.php');
    updateDB($_GET['symbol'], $mysqli);
    $datapoints_STOCK = getHistoryforGraph($_GET['symbol']);
    $datapoints_DIVIDEND = getDividendforGraph($_GET['symbol']);
    $generalData = getStockData($_GET['symbol'], $mysqli);

    $x =  payedDividendsInYear(2019, $_GET['symbol'], $mysqli);
    $amountDivinYear =$x[0];
    $sumDiviinYear =$x[1];

    $dividendenRendite = getDividendenRendite($generalData[3], $sumDiviinYear);

    $dividendGrowth = number_format((float)calcDivGrowth($_GET['symbol'], $mysqli)*100, 2, '.','') ;

?>

<script>

    /**
     *
     * @param trID Id des <tr> elements
     * @param name name der Kennzahl
     * @param critGreen
     * @param critRed
     * @param currentValue
     * @param biggerisGood true wenn große Werte gut sind
     */
    function KPIRow (trID, name, critGreen, critRed, currentValue, biggerisGood){
        var img;

        if (biggerisGood){
            if (currentValue>=critGreen){
                img = "img/lights/greenlight.PNG";
            } else if (currentValue<= critRed){
                img = "img/lights/redlight.PNG";
            } else {
                img = "img/lights/orangelight.PNG";
            }
            $('#'+trID+'').append('' +
                '<td>'+name+'</td>' +
                '<td>>='+critGreen+'</td>' +
                '<td><'+critRed+'</td>' +
                '<td>'+currentValue+'</td>' +
                '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');

        } else{
            if (currentValue<=critGreen){
                img = "img/lights/greenlight.PNG";
            } else if (currentValue>= critRed){
                img = "img/lights/redlight.PNG";
            } else {
                img = "img/lights/orangelight.PNG";
            }
            $('#'+trID+'').append('' +
                '<td>'+name+'</td>' +
                '<td><='+critGreen+'</td>' +
                '<td>>'+critRed+'</td>' +
                '<td>'+currentValue+'</td>' +
                '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');

        }
    }

    // get Name for the symbol
    var symbol = "<?php echo $_GET['symbol']; ?>";
    var name;
    for (var i=0; i<stocks.length; i++){
        if (stocks[i].value==symbol){
            name = stocks[i].label;
        }
    }
    $( document ).ready(function() {
        $('#name').text(name);
    });

    // fill charts with data
    window.onload = function () {

        new CanvasJS.Chart("chartContainer_STOCK", {
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

        new CanvasJS.Chart("chartContainer_DIVIDEND", {
            theme: "light2", // "light1", "light2", "dark1", "dark2"
            animationEnabled: true,
            zoomEnabled: true,
            type: "horizontalBar",
            title: {
                text: "Dividenden Kurs"
            },
            data: [{
                xValueType: "dateTime",
                dataPoints: <?php echo json_encode($datapoints_DIVIDEND, JSON_NUMERIC_CHECK); ?>
            }]
        }).render();


        // KPI's befüllen
         KPIRow("howLong", "Seit wie vielen Jahren wird mind. 1 mal Jährlich eine Dividende gezahlt", 20, 5, <?php echo yearsPayingDividend($_GET['symbol'], $mysqli)?>, true);
         KPIRow("kgv", "KGV", 10, 50, <?php echo $generalData[4] ?>, false);
         KPIRow("dividendenRendite", "DividendenRendite", 3, 7, <?php echo $dividendenRendite ?>, false);
         //KPIRow("payOutRatio", "Pay-Out-Ratio", 60, 85, <?php echo 1 ?>, false);


    }
</script>

<!-- Daten -->
<div class="container">
    <div class="row">
        <div class="col">
            <span class="mr-sm-2"> Name: </span>
            <span class="mr-sm-2" id="name">  </span>
        </div>
        <div class="col">
            <span class="mr-sm-2"> Symbol: </span>
            <span class="mr-sm-2"> <?php echo $_GET['symbol'];?> </span>
        </div>
    </div>

    <div class="container">
    <!--placeholder aktienkurs-->
    <div class="row">
        <div class = "col" id="chartContainer_STOCK" style="height: 370px; width: 100%;"></div>

        <div class = "col-1"></div>

    <!--placeholder Dividendenverlauf-->
        <div class = "col" id="chartContainer_DIVIDEND" style="height: 370px; width: 100%;"></div>
    </div>
    </div>


    <div class="clearfix"></div>

<!--    Info Button-->
    <script>
        $(function(){
            $('[data-toggle="tooltip"]').tooltip();
        })
    </script>
    <!--placeholder data table -->
    <br>
    <div class="container">
        <h2>Kennzahlen</h2>
        <p>Diese Zahlen erlauben eine schnelle Einschaetzung der Qualitaet der Dividende:</p>
        <table class="table table-striped text-center">
            <thead>
            <tr>
                <th>Kennzahl</th>
                <th colspan="2" >kritische Werte</th>
                <th>Aktueller Wert</th>
                <th>Ampel</th>
            </tr>
            <tr>
                <th></th>
                <th>Grün</th>
                <th>Rot</th>
                <th></th>
            </tr>
            </thead>
            <tbody>
            <tr id="payRate">
            </tr>
            <tr id ="howLong">
            </tr>
            <tr id ="kgv">
            </tr>
            <tr id ="dividendenRendite">
            </tr>
            <tr id ="growth">
            </tr>
<!--            <tr id ="payOutRatio">-->
<!--            </tr>-->
            </tbody>
        </table>
    </div>

    <script>
        var payedDividendsinYear=<?php echo $amountDivinYear; ?>;
        if (payedDividendsinYear==4){
            img = "img/lights/greenlight.PNG";
        } else if (payedDividendsinYear>= 20 || payedDividendsinYear==0){
            img = "img/lights/redlight.PNG";
        } else {
            img = "img/lights/orangelight.PNG";
        }
        $('#payRate').append('' +
            '<td> Häufigkeit der Auszahlungen im Jahr 2019 ' +
            '<a data-toggle="tooltip" title="Hooray!"><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td>== 4</td>' +
            '<td>>= 20 oder == 0</td>' +
            '<td>'+payedDividendsinYear+'</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');



        var growth=<?php echo $dividendGrowth; ?>;
        if (growth>= 10 || growth<=0){
            img = "img/lights/redlight.PNG";
        } else if (growth<10 && growth >5){
            img = "img/lights/greenlight.PNG";
        }
        else {
            img = "img/lights/orangelight.PNG";
        }
        $('#growth').append('' +
            '<td> Wachstum in den letzen 5 Jahren ' +
            '<a data-toggle="tooltip" title="Hooray!"><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td>< 10%</td>' +
            '<td>>= 10 oder <= 5</td>' +
            '<td>'+growth+'</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');
    </script>

</div>
<div class="clearfix"></div>
</html>
<?php
}
?>