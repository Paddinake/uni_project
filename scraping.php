<?php
include_once('simple_html_dom.php');

$mysqli = new mysqli("127.0.0.1", "root", "", "uni_project", 3306);
if ($mysqli->connect_errno) {
    echo "Failed to connect to MySQL: (" . $mysqli->connect_errno . ") " . $mysqli->connect_error;
}

echo $mysqli->host_info . "\n";

//$result = mysqli_query($mysqli, "INSERT INTO stocks (Symbol, Name, LastValue) VALUES ( 'AAPL', 'Apple Inc.', 279.44 );");

//$result = mysqli_query($mysqli, 'SELECT * FROM stocks');

//while ($row = mysqli_fetch_array($result)){
//    echo $row[0]." ".$row[1]." ".$row[2]." ".$row[3]."\n";
//}

//$result = mysqli_query($mysqli, "INSERT INTO dividends (symbol, date, dividend) VALUES ( 'SKT', '2005-07-28', 0.3225 ), ( 'SKT', '2005-07-29', 0.3225 );");

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

function getPOSIX(){
    echo microtime();
    return microtime();
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

//@TODO: scrappe current stock value from yahoo
function getCurrentStockValue($symbol){
    return 0;
}
//@TODO: make it return the symbols current name of the stock.
function getStockName($symbol){
    return "FOO";
}

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

//Loads dividends from DB if last download is less than 24 hours.
//Else, deletes all corresponding entries from dividends and history and updates timestamp.
function loadAllDividends($symbol, $mysqli){

    loadStockIntoDB($symbol, $mysqli);

    if(isOld($symbol, $mysqli)){
        InsertAllDividends(getTestDiv($symbol), $symbol, $mysqli);
        updateTimestamp($symbol, $mysqli);
    }
    //InsertAllDividends(getTestDiv($symbol), $symbol, $mysqli);

    $s = "SELECT * FROM dividends WHERE symbol = '".$symbol."';";

    $result = mysqli_query($mysqli, $symbol);

    //while ($row = mysqli_fetch_array($result)){
    //    echo $row[0]." ".$row[1]."\n";
    //}

    return $result;

}

//Delete all entries of dividends were symbol is equal to each other
function deleteDividends($symbol, $mysqli){
    $s = "DELETE FROM dividends WHERE symbol = '".$symbol."';";
    mysqli_query($mysqli, $s);
}

//insert csv into DB. Deletes all entries with given symbol and writes new data from given array into DB.
function InsertAllDividends($array, $symbol, $mysqli){

    //should we reset DB for given symbol?
    deleteDividends($symbol, $mysqli);

    $statement = "INSERT INTO dividends (symbol, date, dividend) VALUES ";

    for($i=1; $i<count($array)-1; $i++){
        $statement = $statement."( '".$symbol."', '".$array[$i][0]."', '".$array[$i][1]."' ), ";
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

    $dividendA=getTestDiv($symbol);

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


//payedDividensInYear("2018");
//InsertAllDividends(getTestDiv("SKT"), "SKT", $mysqli);
//checkTime("AAPL", $mysqli);
loadAllDividends("SKT", $mysqli);

?>