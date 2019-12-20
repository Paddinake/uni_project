<?php
include_once('simple_html_dom.php');

$period1 = 0;
$period2 = 1;

function getCSV()
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, 'https://query1.finance.yahoo.com/v7/finance/download/SKT?period1=738540000&period2=1576796400&interval=1mo&events=history&crumb=zqM3WbGRGZX');
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $resp = curl_exec($ch);

    if(!$resp) {
        die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
    }
    curl_close($ch);
    return $resp;
}

function CSVToArray($resp){

    $lines = explode("\n", $resp);
    $array = array();

    foreach ($lines as $line) {
        $array[] = str_getcsv($line);
    }
    print_r($array);
}

CSVToArray(getCSV());
?>