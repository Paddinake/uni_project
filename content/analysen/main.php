<?php
include_once('funcDB.php');
if (!isset($_SESSION["user_id"])) {
    header('Location: index.php');
}

function getDividendenRendite($lastStockprice, $sumDiviInYear){
    return number_format((float)(($sumDiviInYear/$lastStockprice)*100), 2, '.','') ;
}

?>
<script type="text/javascript" src="content/analysen/stocks.js"></script>
<script>

    // Enable tooltip toggle
    $(function(){
        $('[data-toggle="tooltip"]').tooltip();
    });

    /**
     * returns the Name for a symbol
     *
     * @param symbol Symbol for that the name is needed
     */
    function getNameForSymbol(symbol) {
        var name;
        var symbol;
        for (var i = 0; i < stocks.length; i++) {
            if (stocks[i].value == symbol) {
                name = stocks[i].label;
                symbol = stocks[i].value;
            }
        }

        if (typeof name!=="undefined"){
            return name;
        } else {
            return symbol;
        }

    }

    /**
     * Function to create a KPI Row
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
</script>

<!-- Welcome -->
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


<div class="row container-fluid padding center">
    <!-- Searchbar -->
    <div class="col-8 container-fluid">
        <div id="searchbar">
            <?php
            include "searchbar.php";
            ?>
        </div>
    </div>
<!--  Top 5 Stocks  -->
    <div class="col-4 text-right">
        <table class="table table-sm">
            <th>Top 5 meistgesuchten Aktien</th>
            <?php
            foreach (getTop5($mysqli) as $item){
                echo"<tr>";
                echo '<td >
                                <a href="index.php?content=analysen&symbol='.$item.'">
                                    <div style="height:100%;width:100%" id="'.$item.'">
                                        <script>
                                            document.getElementById("'.$item.'").innerHTML =getNameForSymbol("'.$item.'");
                                        </script>
                                    </div>
                                </a>
                            </td>';
                echo "</tr>";
            }
            ?>
        </table>
    </div>
</div>

<div class="clearfix"</div>
</div>

<!--Only if Symbol is selected-->

<?php

if(!empty($_GET['symbol'])){
    if (userUpdate($_SESSION["user_id"], $mysqli)==0){
        echo '<META HTTP-EQUIV="refresh" content="0;URL=index.php?content=maxRequests">';
    }

    include('graphHelper.php');
    $s = strtoupper($_GET['symbol']);
    updateDB($s, $mysqli);
    $datapoints_STOCK = getHistoryforGraph($s);
    $datapoints_DIVIDEND = getDividendforGraph($s);
    $generalData = getStockData($s, $mysqli);

    $x =  payedDividendsInYear(2019, $s, $mysqli);
    $amountDivinYear =$x[0];
    $sumDiviinYear =$x[1];

    $dividendenRendite = getDividendenRendite($generalData[3], $sumDiviinYear);

    $dividendGrowth = number_format((float)geometrischesMittel($s, 2019, 5, $mysqli), 4, '.','') ;
    $dividendGrowth10 = number_format((float)geometrischesMittel($s, 2019, 10, $mysqli), 4, '.','') ;


    //ToDo: mit dem yield machen wir bis jetzt noch nichts
?>

<script>
    // get Name for the symbol and place it
    var mainName = getNameForSymbol("<?php echo $s; ?>");
    $( document ).ready(function() {
        $('#name').text(mainName);
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
         //KPIRow("howLong", "Anzahl Jahre in denen min. einmal Dividende gezahlt wurde", 20, 5, <?php echo numYearsDividendPayed($_GET['symbol'], 2019, $mysqli)?>, true);
         //KPIRow("kgv", "KGV", 10, 50, <?php echo $generalData[4]; ?>, false);
         //KPIRow("dividendenRendite", "Momentane Dividendenrendite in %", 3, 7, <?php echo $dividendenRendite; ?>, false);
         //KPIRow("payOutRatio", "Pay-Out-Ratio in %", 60, 85, <?php echo str_replace('%', '', $generalData[6]);; ?>, false);

        // KPIs that cant be filled with KPIRow() due to special red/green conditions
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
            '<a data-toggle="tooltip" title="Die Bewertung der Anzahl an Auszahlungen ist hauptsächlich psychologischer Natur: Einkommensinvestoren bevorzugen oft Unternehmen mit den in der USA üblichen vier Auszahlungen, da so mit drei Aktien, deren Auszahlungstermine entsprechend versetzt getaktet sind, monatliche Auszahlungen erreicht werden können, analog zu einem klassischen Gehalt. Eine jährliche oder halbjährliche Dividende hat nur den Nachteil, dass man mit der Auszahlung länger haushalten muss. Mehr als vier Auszahlungen im Jahr oder gar tägliche Auszahlungen sind ungewöhnlich und mit Vorsicht zu betrachten."><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td>== 4</td>' +
            '<td>>= 20 oder == 0</td>' +
            '<td>'+payedDividendsinYear+'</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');


        var howLong=<?php echo numYearsDividendPayed($_GET['symbol'], 2019, $mysqli)?>;
        if (howLong>=20){
            img = "img/lights/greenlight.PNG";
        } else if (howLong < 5){
            img = "img/lights/redlight.PNG";
        } else {
            img = "img/lights/orangelight.PNG";
        }
        $('#howLong').append('' +
            '<td> Anzahl Jahre in denen min. einaml Dividende gezahlt wurde ' +
            '<a data-toggle="tooltip" title="Eine hohe Anzahl an Auszahlungsjahren ist ein guter Hinweis auf ein dauerhaft stabiles Unternehmen und sichere Dividende. Daher werden Unternehmen die 25 Jahre oder länger Dividende zahlen auch als \'Dividendenaristokraten\' bezeichnet. Dieses Qualitätsmerkmal geben Managments ungern auf, sodass auch in wirtschaflich schlechteren Zeiten versucht wird weiterhin Dividende zu zahlen um zu vermeiden, dass die Auszahlungsserie unterbrochen wird."><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td>>= 20</td>' +
            '<td>< 5</td>' +
            '<td>'+howLong+'</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');



        var kgv=<?php echo $generalData[4]; ?>;
        if (kgv > 0 && kgv <= 10){
            img = "img/lights/greenlight.PNG";
        } else if (kgv > 50 || kgv <= 0 || kgv == "N/A"){
            img = "img/lights/redlight.PNG";
        } else {
            img = "img/lights/orangelight.PNG";
        }
        $('#kgv').append('' +
            '<td> KGV' +
            '<a data-toggle="tooltip" title="Das Kurs-Gewinn-Verhältnis besagt, wie oft der Gewinn im aktuellen Kurs einer Aktie enthalten ist oder nach wie vielen Jahren der Gewinn den Preis der Aktie „bezahlt“ hat. Diese Deutung gilt jedoch nicht mehr, wenn das Unternehmen Verluste schreibt. Denn nach Definition ist das KGV somit negativ und die Aktie würde niemals durch den Gewinn „bezahlt“ werden können. Um diese Definitionslücke für Werte kleiner 0 zu umgehen, wird anstatt des Gewinns oft der Kapitalfluss (so genannter Cash-Flow) errechnet und alternativ das Kurs-Cash-Flow-Verhältnis KCV oder KCF verwendet. Für Dividendenstrategien ist der KGV interessant um schnell zu erkennen ob ein Unternehmen überhaupt Gewinn erziehlt und dadurch stabil erscheint."><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td>> 0 und <= 10</td>' +
            '<td>> 50 oder <= 0</td>' +
            '<td>'+kgv+'</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');



        var dividendenRendite=<?php echo $dividendenRendite; ?>;
        if (dividendenRendite<=3 && dividendenRendite > 0){
            img = "img/lights/greenlight.PNG";
        } else if (dividendenRendite > 7 || dividendenRendite <= 0 || dividendenRendite == "N/A"){
            img = "img/lights/redlight.PNG";
        } else {
            img = "img/lights/orangelight.PNG";
        }
        $('#dividendenRendite').append('' +
            '<td> Momentane Dividendenrendite' +
            '<a data-toggle="tooltip" title="Die momentane Dividendenrendite beschreibt den Anteil der Jahresdividende am Preis einer einzelnen Aktie, vergleichbar zur Berechnung von Zinsen. Viele Unternehmen zahlen zwischen einem bis drei Pozent Dividende. Höhere Werte müssen genauer betrachtet werden, da sie oft auf einen Kurseinbruch hinweisen, den man erst verstehen sollte bevor man in einer hohen Dividendenrendite eine Chance bzw. Unterbewertung sieht."><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td><= 3%</td>' +
            '<td>> 7% oder <= 0%</td>' +
            '<td>'+dividendenRendite+'%</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');



        var payOutRatio=<?php echo strval(str_replace('%', '', $generalData[6])); ?>;
        if (payOutRatio<=60 && payOutRatio > 0){
            img = "img/lights/greenlight.PNG";
        } else if (payOutRatio > 85 || payOutRatio <= 0){
            img = "img/lights/redlight.PNG";
        } else {
            img = "img/lights/orangelight.PNG";
        }
        $('#payOutRatio').append('' +
            '<td> Pay-Out-Ratio ' +
            '<a data-toggle="tooltip" title="Die Pay-Out-Ratio zeigt den Anteil der Dividende am Gewinn an. Hohe Pay-Out-Ratios schränken die Möglichkeit zur Weiterentwicklung des Unternehmens ein. Ratios über 100% bedeuten bei AGs in der Regel, dass die Auszahlung nicht allein vom Gewinn gedeckt wird sondern auch aus dem bereits vorhanden Kapital. Ausnahmen gelten für einige Unternehmensformen wie REITs, die dazu verpflichtet sind mehr als 100% auszuzahlen. Dort wird als Massstab der Anteil am freien Cash-Flow (FFO) zu Grunde gelegt." data-placement="top"><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td><= 60%</td>' +
            '<td>> 85% oder <= 0%</td>' +
            '<td>'+payOutRatio+'%</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');




        var growth=<?php echo $dividendGrowth; ?>;
        if (growth<=3){
            img = "img/lights/redlight.PNG";
        } else if (growth>=10){
            img = "img/lights/greenlight.PNG";
        }
        else {
            img = "img/lights/orangelight.PNG";
        }
        $('#growth').append('' +
            '<td> Durchschnittliches jährliches Wachstum in den letzten 5 Jahren ' +
            '<a data-toggle="tooltip" title="Durch das geometrische Mittel wird das Wachstum der Dividende in Prozent innerhalb der letzten fünf Jahre berechnet. Dies hilft die weitere Entwicklung der Dividende abzuschätzen. Eine stetig wachsende Dividende ist in der Regel einer gleichbleibenden Dividende vorzuziehen, solange dadurch nicht der Gewinn (Pay-Out-Ratio) oder freie Cash-Flow (FFO) gefährdet wird." data-placement="top"><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td>> 10%</td>' +
            '<td><= 3%</td>' +
            '<td>'+growth+'%</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');


        var growth10=<?php echo $dividendGrowth10; ?>;
        if (growth10<=3){
            img = "img/lights/redlight.PNG";
        } else if (growth10>=100){
            img = "img/lights/greenlight.PNG";
        }
        else {
            img = "img/lights/orangelight.PNG";
        }
        $('#growth10').append('' +
            '<td> Durchschnittliches jährliches Wachstum in den letzten 10 Jahren ' +
            '<a data-toggle="tooltip" title="Durch das geometrische Mittel wird das Wachstum der Dividende in Prozent innerhalb der letzten zehn Jahre berechnet. Dies hilft die weitere Entwicklung der Dividende abzuschätzen. Eine stetig wachsende Dividende ist in der Regel einer gleichbleibenden Dividende vorzuziehen, solange dadurch nicht der Gewinn (Pay-Out-Ratio) oder freie Cash-Flow (FFO) gefährdet wird." data-placement="top"><i class="fa fa-question-circle"></i></span></a></span>' +
            '</td>' +
            '<td>> 100%</td>' +
            '<td><= 3%</td>' +
            '<td>'+growth10+'%</td>' +
            '<td><img class="img-fluid" style="max-height: 30px" src="'+img+'"></td>');


    }
</script>

<!-- Grunddaten -->
<div class="container">
    <div class="row">
        <div class="col">
            <span class="mr-sm-2"> Name: </span>
            <span class="mr-sm-2" id="name">  </span>
        </div>
        <div class="col">
            <span class="mr-sm-2"> Symbol: </span>
            <span class="mr-sm-2"> <?php echo strtoupper($_GET['symbol']);?> </span>
        </div>
        <div class="col">
            <span class="mr-sm-2"> Preis in Heimatwährung: </span>
            <span class="mr-sm-2"> <?php echo $generalData[3];?> </span>
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

    <!--placeholder data table with traffic lights -->
    <br>
    <div class="container">
        <h2>Kennzahlen</h2>
        <p>Diese Zahlen erlauben eine schnelle Einschätzung der Qualität der Dividende. Splits werden derzeit nicht berücksichtigt.</p>
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
            <tr id ="growth10">
            </tr>
            <tr id ="payOutRatio">
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