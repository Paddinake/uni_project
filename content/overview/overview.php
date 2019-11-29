<?php
include "json_requests.php";
include "searchbar.php";

if(isset($_GET['symbol'])) {
    $result = JSONRequest($_GET['symbol']);
    $result = json_decode($result, true);

    $key = "Meta Data";
    echo substr($result["Meta Data"]["1. Information"],0,-37) . " (closing)<br/>";
    echo "Symbol: ".$result["Meta Data"]["2. Symbol"] . "<br/>";
    echo "Last Refreshed: ".$result["Meta Data"]["3. Last Refreshed"] . "<br/>";
    echo "Timezone: ".$result["Meta Data"]["4. Time Zone"] . "<br/>";

    $dataPoints = array();

    foreach ($result["Weekly Time Series"] as $timestamp => $values) {
        $javaTimestamp = strtotime($timestamp) * 1000;
        array_push($dataPoints, array("x" => $javaTimestamp, "y" => $values["4. close"]));
    }
    ?>

    <script>
        window.onload = function () {

            var chart = new CanvasJS.Chart("chartContainer", {
                theme: "light2", // "light1", "light2", "dark1", "dark2"
                animationEnabled: true,
                zoomEnabled: true,
                title: {
                    text: "Aktienkurs"
                },
                data: [{
                    type: "area",
                    xValueType: "dateTime",
                    dataPoints: <?php echo json_encode($dataPoints, JSON_NUMERIC_CHECK); ?>
                }]
            }).render();

        }
    </script>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <?php
} else{
    echo "wähle eine Aktie aus";
}


