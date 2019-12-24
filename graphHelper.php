<?php
include('scraping.php');

//returns datapoints prepared for ChartJS
// vielleicht muss man den Index auch al variable übergeben
function getDataforGraph($url){
    $array = CSVToArray(getCSV($url));
    $dataPoints = array();
    for($i = 1; $i < count($array)-1; $i++){
        $javaTimestamp = strtotime($array[$i][0]) * 1000;
        array_push($dataPoints, array("x" => $javaTimestamp, "y" => $array[$i][1]));
    }
    return $dataPoints;
}