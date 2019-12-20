<?php
include_once('simple_html_dom.php');

$period1 = 0;
$period2 = 1;

//$historyA = array();
//$dividendA = array();

function getCSV($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
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
    return ($array);
}

//@TODO Datenbank anbinden
//@TODO echo oder return?
//@TODO datenquelle anpassen
//gibt die die summe der bezahlten dividenden und die anzahl der auszahlungen aus.
function payedDividensInYear($year){
    $sum=0;//summiert die in dem Jahr bisher tatsaechlich bezahlten Dividenden
    $counter=0;//anzahl der bezahlten Dividenden

    $dividendA=CSVToArray(getCSV("https://query1.finance.yahoo.com/v7/finance/download/SKT?period1=738540000&period2=1576796400&interval=1mo&events=div&crumb=UO48Nwtc0Va"));

    for($i=1; $i<count($dividendA)-1;$i++){
        if(strpos($dividendA[$i][0],$year)>-1){
            //echo "true"."\n";
            $sum+=$dividendA[$i][1];
            $counter+=1;
        } else {
            //echo "false"."\n";
        }
    }

    echo "Sum: ".$sum." Payouts: ".$counter;
}


payedDividensInYear("2019");


?>