<?php
include_once('funcDB.php');

/**
 * Returns all Dividend datapoints for a Symbol prepared for the ChartJS framework
 *
 * @param $symbol
 * @return array
 */
function getDividendforGraph($symbol){
    $mysqli = new mysqli("127.0.0.1", "root", "", "uni_project", 3306);
    $array = loadAllDividendsToArray($symbol, $mysqli);
    $dataPoints = array();
    for($i = 0; $i < count($array)-1; $i++){
        if ($array[$i][2]==0){
        } else {
            $javaTimestamp = strtotime($array[$i][1]) * 1000;
            array_push($dataPoints, array("x" => $javaTimestamp, "y" => $array[$i][2]));
        }

    }
    return $dataPoints;
}


/**
 * Returns all History datapoints for a Symbol prepared for the ChartJS framework
 *
 * @param $symbol
 * @return array
 */
function getHistoryforGraph($symbol){
    $mysqli = new mysqli("127.0.0.1", "root", "", "uni_project", 3306);
    $array = loadAllHistoryToArray($symbol, $mysqli);
    //$array = loadAllDividendsToArray($symbol, $mysqli);
    $dataPoints = array();
    for($i = 0; $i < count($array)-1; $i++){
        if ($array[$i][2]==0){
        } else {
            $javaTimestamp = strtotime($array[$i][1]) * 1000;
            array_push($dataPoints, array("x" => $javaTimestamp, "y" => $array[$i][6]));//adjClose=6
        }

    }
    return $dataPoints;
}