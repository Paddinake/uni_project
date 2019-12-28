<?php
include_once('simple_html_dom.php');
include('db.php');

echo $mysqli->host_info . "\n";

//$result = mysqli_query($mysqli, "INSERT INTO stocks (Symbol, Name, LastValue) VALUES ( 'AAPL', 'Apple Inc.', 279.44 );");

//$result = mysqli_query($mysqli, 'SELECT * FROM stocks');

//while ($row = mysqli_fetch_array($result)){
//    echo $row[0]." ".$row[1]." ".$row[2]." ".$row[3]."\n";
//}

//$result = mysqli_query($mysqli, "INSERT INTO dividends (symbol, date, dividend) VALUES ( 'SKT', '2005-07-28', 0.3225 ), ( 'SKT', '2005-07-29', 0.3225 );");


//returns URL from symbol for given timespan, interval and crumb
//$dh = true for dividends, = false for history
function getURL($symbol, $dh, $startT, $endT, $crumb){

    if($dh==false){
        $dh = "history";
    } else {
        $dh = "div";
    }
    return "https://query1.finance.yahoo.com/v7/finance/download/".$symbol."?period1=".$startT."&period2=".$endT."&interval=1mo&events=".$dh."&crumb=".$crumb;
}


//returns URL from symbol for max timeframe till now with default crumb
function getURL_maxT($symbol, $dh){
    return getURL($symbol, $dh, "-900000000", getPOSIXDate(), "UO48Nwtc0Va");
}

//Loads csv from given URL
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

//converts downloaded csv into array for further processing.
function CSVToArray($resp){

    $lines = explode("\n", $resp);
    $array = array();

    foreach ($lines as $line) {
        $array[] = str_getcsv($line);
    }
    echo "".$array[1][0]." ".$array[1][1]."\n";
    return ($array);
}

function getPOSIXDate(){
    $mt = explode(' ', microtime());
    return ((int)$mt[1]);
}

//Checks if primary key already exists in DB, returns true if it does.
function primKeyExists($symbol, $mysqli){
    $r = false;
    $s = "SELECT COUNT(*) FROM stocks WHERE Symbol='".$symbol."';";
    $return = mysqli_query($mysqli, $s);
    $return = mysqli_fetch_assoc($return);

    echo $return["COUNT(*)"];

    if(intval($return["COUNT(*)"])>0){
        $r = true;
    }

    return $r;
}


//Checks if timestamp is older than 24 hours returns true.
function isOld($symbol, $mysqli){

    $s = "SELECT LastUpdated FROM stocks WHERE symbol='".$symbol."';";
    $result = mysqli_query($mysqli, $s);

    while ($row = mysqli_fetch_assoc($result)){
        echo $row["LastUpdated"]."\n";
        $timeST = new DateTime($row["LastUpdated"]);//last updated in DB
        $timeN = new DateTime();//current time
        $i = $timeST->diff($timeN);
        if(intval($i->format("%Y")) > 0 or
            intval($i->format("%m")) > 0 or
            intval($i->format("%d")) > 0){

            echo "\nUpdate the db bitch!\n";
            echo $i->format('Age is: %y years %m monts %d days %h hours');
            return true;

        }
    }
    return false;
}

/**
 * Scrapes yahoo for current Symbol stock value
 *
 * @param $symbol
 * @return string
 */
function getCurrentStockValue($symbol){
    {
        $html = file_get_html('https://finance.yahoo.com/quote/'.$symbol.'/history');
        $currentStockValue = "";
        foreach ($html->find('span') as $span)
        {
            if (isset($span-> attr['data-reactid'])){
                if($span->attr['data-reactid']==34){
                    $currentStockValue = $span;
                }
            }
        }
        return $currentStockValue;
    }
}

//@TODO: make it return the symbols current name of the stock.
function getStockName($symbol){
    {
        $html = file_get_html('https://finance.yahoo.com/quote/'.$symbol.'/history');
        $currentStockValue = "";
        foreach ($html->find('span') as $span)
        {
            if (isset($span-> attr['data-reactid'])){
                if($span->attr['data-reactid']==7){
                    $currentStockValue = $span;
                }
            }
        }
        //return $currentStockValue;
        return "FOOO";
    }
}

//Erzeugt eintrag mit timestap in stocks table damit timestamps daraus gelesen werden können.
function loadStockIntoDB($symbol, $mysqli){
    $s = "INSERT INTO stocks (symbol, Name, LastValue) VALUES ('".$symbol."', '".getStockName($symbol)."', ".getCurrentStockValue($symbol).");";
    mysqli_query($mysqli, $s);
}

//Updates timestamp to current time.
function updateTimestamp($symbol, $mysqli){
    $s = "UPDATE stocks SET LastUpdated=current_timestamp WHERE symbol='".$symbol."';";
    mysqli_query($mysqli, $s);
    echo "\nUpdated timestamp of ".$symbol."\n";
}

function updateDB($symbol, $mysqli){
    //If there is no entry with corresponding symbol, create it and download all dividends initially.
    if (primKeyExists($symbol,$mysqli)==false) {
        loadStockIntoDB($symbol, $mysqli);
        InsertAllDividends(getTestDiv($symbol), $symbol, $mysqli);
        echo "\nCreating entry in stocks table for ".$symbol."\n";

    } elseif(isOld($symbol, $mysqli)){
        echo "\n Updateing timestamp and downloading dividends.\n";
        InsertAllDividends(getTestDiv($symbol), $symbol, $mysqli);
        updateTimestamp($symbol, $mysqli);
    }
}


//Zentrale Funktion um Dividenden herunterzuladen. Aktualisiert bei Bedarf den Datensatz.
//Loads dividends from DB if last download is less than 24 hours.
//Else, deletes all corresponding entries from dividends and history and updates timestamp.
function loadAllDividendsToArray($symbol, $mysqli){

    updateDB($symbol, $mysqli);

    $s = "SELECT * FROM dividends WHERE symbol = '".$symbol."' ORDER BY date ASC;";

    $result = mysqli_query($mysqli, $s);
    $return = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)){
        $return[$i][0]=$row[1];//symbol
        $return[$i][1]=$row[2];//date
        $return[$i][2]=$row[3];//dividend
        //echo $row[1]." ".$row[2]." ".$row[3]."\n";
        $i+=1;
    }

    return $return;
}

/**
 * Loads complete history from DB to array in ascending order of dates.
 * Updates DB if needed.
 *
 * @param $symbol
 * @param $mysqli
 * @return array
 */
function loadAllHistoryToArray($symbol, $mysqli){

    updateDB($symbol, $mysqli);

    $s = "SELECT * FROM histories WHERE symbol = '".$symbol."' ORDER BY date ASC;";

    $result = mysqli_query($mysqli, $s);
    $return = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)){
        $return[$i][0]=$row[1];//symbol
        $return[$i][1]=$row[2];//date
        $return[$i][2]=$row[3];//dividend
        //echo $row[1]." ".$row[2]." ".$row[3]."\n";
        $i+=1;
    }

    return $return;

}

//Delete all entries of dividends were symbol is equal to each other
function deleteHistories($symbol, $mysqli){
    $s = "DELETE FROM histories WHERE symbol = '".$symbol."';";
    mysqli_query($mysqli, $s);
}

//Delete all entries of dividends were symbol is equal to each other
function deleteDividends($symbol, $mysqli){
    $s = "DELETE FROM dividends WHERE symbol = '".$symbol."';";
    mysqli_query($mysqli, $s);
}

/**
 * Deletes all existing dividend data for a symbol and inserts all dividends from given array into DB.
 * Ignores entries with a dividend of <= 0.0.
 *
 * @param $array
 * @param $symbol
 * @param $mysqli
 */
function InsertAllDividends($array, $symbol, $mysqli){

    //should we reset DB for given symbol?
    deleteDividends($symbol, $mysqli);

    $statement = "INSERT INTO dividends (symbol, date, dividend) VALUES ";

    for($i=1; $i<count($array)-1; $i++){

        if($array[$i][1]>0.0){
            $statement = $statement."( '".$symbol."', '".$array[$i][0]."', '".$array[$i][1]."' ), ";
        }
    }
    $statement = rtrim("$statement", ", ");
    $statement = $statement.";";

    echo $statement;

    mysqli_query($mysqli, $statement);

}

//fuer testing, sollte spaeter ueberall ersetzt werden mit datenbankzugriffen und funktion fuer zugriffe auf dynamische urls
function getTestDiv($symbol){
    return CSVToArray(getCSV("https://query1.finance.yahoo.com/v7/finance/download/".$symbol."?period1=738540000&period2=1576796400&interval=1mo&events=div&crumb=UO48Nwtc0Va"));
}

//@TODO Datenbank anbinden
//@TODO echo mit passendem return ersetzen?
//@TODO datenquelle anpassen
//gibt die die summe der bezahlten dividenden und die anzahl der auszahlungen aus.
function payedDividensInYear($year, $symbol){
    $sum=0;//summiert die in dem Jahr bisher tatsaechlich bezahlten Dividenden
    $counter=0;//anzahl der bezahlten Dividenden

    $dividendA=CSVToArray(getCSV(getURL_maxT($symbol,true)));

    for($i=1; $i<count($dividendA)-1;$i++){
        //prueft datum und das tatsaechlich ein Betrag ausgezahlt wurde
        if((strpos($dividendA[$i][0],$year)>-1)&&(($dividendA[$i][1]>0.0))){
            //echo $dividendA[$i][1]."\n";
            $sum+=$dividendA[$i][1];
            $counter+=1;
        } else {
            //echo "false"."\n";
        }
    }

    echo "Sum: ".$sum." Payouts: ".$counter;
}


payedDividensInYear("2014", "SKT");
//InsertAllDividends(getTestDiv("SKT"), "SKT", $mysqli);
//checkTime("AAPL", $mysqli);
//loadAllDividendsToArray("SKT", $mysqli);
//primKeyExists("SKT", $mysqli);
//echo getPOSIXDate();
//echo getURL_maxT("SKT", true);
//echo "<h1>".getCurrentStockValue('SKT')."</h1>";

?>