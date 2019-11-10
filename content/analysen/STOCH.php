<?php
include "json_requests.php";


if(isset($_GET['symbol'])) {
    $result = JSONRequestSTOCH($_GET['symbol']);
    $result = json_decode($result, true);


    foreach ($result["Meta Data"] as $metadata => $values) {
        echo $metadata . ":" . $values . "<br>";
    }

    $key = "Meta Data";

    $dataPointsSlowD = array();
    $dataPointsSlowK = array();
    $times = array();

    foreach ($result["Technical Analysis: STOCH"] as $timestamp => $values) {
        $javaTimestamp = strtotime($timestamp) * 1000;
        array_push($times, strtotime($timestamp) * 1000);
        array_push($dataPointsSlowD, array("x" => $javaTimestamp, "y" => $values["SlowD"]));
        array_push($dataPointsSlowK, array("x" => $javaTimestamp, "y" => $values["SlowK"]));
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
                    type: "line",
                    xValueType: "dateTime",
                    dataPoints: <?php echo json_encode($dataPointsSlowD, JSON_NUMERIC_CHECK); ?>
                },{
                    type: "line",
                    xValueType: "dateTime",
                    dataPoints: <?php echo json_encode($dataPointsSlowK, JSON_NUMERIC_CHECK); ?>

                }
                ]
            }).render();

        }
    </script>

    <script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
    <div id="chartContainer" style="height: 370px; width: 100%;"></div>
    <?php
} else{
    echo "wähle eine Aktie aus";
}
