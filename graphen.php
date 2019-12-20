<?php
include "scraping.php";

$array = CSVToArray(getCSV());
$dataPoints = array();
for($i = 1; $i < count($array)-1; $i++){
    $javaTimestamp = strtotime($array[$i][0]) * 1000;
    array_push($dataPoints, array("x" => $javaTimestamp, "y" => $array[$i][1]));
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



