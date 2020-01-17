<?php
include_once('db.php');

/**
 * Returns top 5 most clicked stock names.
 * @param $mysqli
 * @return array
 */
function getTop5($mysqli){
    $s = "SELECT Symbol FROM stocks ORDER BY clicks DESC LIMIT 5;";
    $result = mysqli_query($mysqli, $s);

    $top5 = array();

    while($row = mysqli_fetch_array($result)){
        array_push($top5, $row['Symbol']);
    }
    return $top5;
}