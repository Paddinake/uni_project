<?php
include_once('simple_html_dom.php');
include_once('scraper.php');

$mysqli = new mysqli("127.0.0.1", "root", "", "uni_project", 3306);
$con = mysqli_connect('127.0.0.1','root','','uni_project');

//@TODO replace with loading icon?
set_time_limit(0);
ignore_user_abort();



/**
 * Returns URL from symbol for given timespan, interval and crumb.
 * $dh = true for dividends, = false for history.
 * @param $symbol
 * @param $dh
 * @param $startT
 * @param $endT
 * @param $crumb
 * @return string
 */
function getURL($symbol, $dh, $startT, $endT, $crumb){

    if($dh==false){
        $dh = "history";
    } else {
        $dh = "div";
    }
    //echo "https://query1.finance.yahoo.com/v7/finance/download/".$symbol."?period1=".$startT."&period2=".$endT."&interval=1mo&events=".$dh."&crumb=".$crumb."  ";
    return "https://query1.finance.yahoo.com/v7/finance/download/".$symbol."?period1=".$startT."&period2=".$endT."&interval=1mo&events=".$dh."&crumb=".$crumb;
}

/**
 * Returns URL from symbol for max timeframe till now with default crumb.
 * Crumb is valid for a year(?)
 * @param $symbol
 * @param $dh
 * @return string
 */
function getURL_maxT($symbol, $dh){
    return getURL($symbol, $dh, "-900000000", getPOSIXDate(), "UO48Nwtc0Va");
}

/**
 * Loads CSV from given URL.
 * If the httpcode is not 200, it retries a set time while waiting before each attempt.
 * @param $url
 * @return bool|string
 */
function getCSV($url)
{
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'POST');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);



    $c = 0;
    $loop = true;
    while($loop==true){

        $resp = curl_exec($ch);
        $httpcode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        if($httpcode==200){
            //echo "NIIIIICEEEEEE";
            $loop = false;
        } else if($c>10){
            echo "<br>Externe Datenquelle reagiert nicht.<br>";
            $loop = false;
        } else {
            sleep(1);
            //echo "<br>loop<br>";
            $c=$c+1;
        }

    }



    if(!$resp) {
        die('Error: "' . curl_error($ch) . '" - Code: ' . curl_errno($ch));
    }
    curl_close($ch);
    //echo $resp;
    return $resp;
}

/**
 * Converts downloaded csv into array for further processing.
 * @param $resp
 * @return array
 */
function CSVToArray($resp){

    $lines = explode("\n", $resp);
    $array = array();

    foreach ($lines as $line) {
        $array[] = str_getcsv($line);
    }
    return ($array);
}

/**
 * Returns date in POSIX format.
 * @return int
 */
function getPOSIXDate(){
    $mt = explode(' ', microtime());
    return ((int)$mt[1]);
}

/**
 * Checks if primary key already exists in DB, returns true if it does.
 * @param $symbol
 * @param $mysqli
 * @return bool
 */
function primKeyExists($symbol, $mysqli){
    $r = false;
    $s = "SELECT COUNT(*) FROM stocks WHERE Symbol='".$symbol."';";
    $return = mysqli_query($mysqli, $s);
    $return = mysqli_fetch_assoc($return);


    if(intval($return["COUNT(*)"])>0){
        $r = true;
    }

    return $r;
}

/**
 * Checks if timestamp is older than 24 hours returns true.
 * @param $symbol
 * @param $mysqli
 * @return bool
 * @throws Exception
 */
function isOld($symbol, $mysqli){

    $s = "SELECT LastUpdated FROM stocks WHERE symbol='".$symbol."';";
    $result = mysqli_query($mysqli, $s);

    while ($row = mysqli_fetch_assoc($result)){
        $timeST = new DateTime($row["LastUpdated"]);//last updated in DB
        $timeN = new DateTime();//current time
        $i = $timeST->diff($timeN);
        if(intval($i->format("%Y")) > 0 or
            intval($i->format("%m")) > 0 or
            intval($i->format("%d")) > 0){

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
    return scrapeCurrentValue($symbol);
}

//@TODO: make it return the symbols current name of the stock.
/**
 * Returns stock name from URL
 * @param $symbol
 * @return string
 */
function getStockName($symbol){
    /*$html = file_get_html('https://finance.yahoo.com/quote/'.$symbol.'/history');
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
    */
    return "FOOO";
}

/**
 * Insert stock for given symbol in stocks table.
 *
 * @param $symbol
 * @param $mysqli
 * @param $array
 */
function loadStockIntoDB($symbol, $mysqli, $array){
    //$s = "INSERT INTO stocks (Symbol, Name, LastUpdated, LastValue, KGV, yield, payoutRatio, clicks) VALUES ('".$symbol."', '".getStockName($symbol)."', current_timestamp, '".$array[0]."', '".$array[1]."', '".$array[2]."', '".$array[3]."', 0);";
    $s = "INSERT INTO stocks (Symbol, Name, LastUpdated, LastValue, KGV, yield, payoutRatio, clicks) VALUES ('".$symbol."', '".$array[4]."', current_timestamp, '".$array[0]."', '0', '0', '0', 0);";

    mysqli_query($mysqli, $s);
}

/**
 * Updates timestamp to current time.
 * @param $symbol
 * @param $mysqli
 */
function updateTimestamp($symbol, $mysqli){
    $s = "UPDATE stocks SET LastUpdated=current_timestamp WHERE symbol='".$symbol."';";
    mysqli_query($mysqli, $s);
}

/**
 * Updates stock table with current values from yahoo.
 *
 * @param $symbol
 * @param $mysqli
 * @param $a
 */
function updateStocks($symbol, $mysqli, $a){
    $s = "UPDATE stocks SET LastValue = '".$a[0]."', KGV = ".$a[1].", yield = '".$a[2]."', payoutRatio = '".$a[3]."' WHERE Symbol = '".$symbol."';";

    mysqli_query($mysqli, $s);
}


/**
 * Checks if a stock is already in the DB or how old the timestamp is.
 * If stock is not in DB, downloads data into DB and sets timestamp.
 * If stock is in DB and timestamp is old, updates all entries for given symbol.
 * If stock is in DB and timestamp is not old, it does nothing.
 * Increase clicks.
 * @param $symbol
 * @param $mysqli
 */
function updateDB($symbol, $mysqli){
    $s = "UPDATE stocks SET clicks = clicks +1 WHERE Symbol = '".$symbol."';";
    $a = array();

    //If there is no entry with corresponding symbol, create it and download all dividends initially.
    if (primKeyExists($symbol,$mysqli)==false) {
        $a = scrape($symbol);
        loadStockIntoDB($symbol, $mysqli, $a);
        updateStocks($symbol, $mysqli, $a);
        InsertAllDividends(CSVToArray(getCSV(getURL_maxT($symbol, true))), $symbol, $mysqli);
        //InsertAllDividends(getTestDiv("SKT"), $symbol, $mysqli);
        InsertAllHistories(CSVToArray(getCSV(getURL_maxT($symbol, false))), $symbol, $mysqli);

    } elseif(isOld($symbol, $mysqli)){
        $a = scrape($symbol);
        //InsertAllDividends(getTestDiv("SKT"), $symbol, $mysqli);
        updateStocks($symbol, $mysqli, $a);
        InsertAllDividends(CSVToArray(getCSV(getURL_maxT($symbol, true))), $symbol, $mysqli);
        InsertAllHistories(CSVToArray(getCSV(getURL_maxT($symbol, false))), $symbol, $mysqli);
        updateTimestamp($symbol, $mysqli);
    } else {
        $s = "UPDATE stocks SET LastValue = ".getCurrentStockValue($symbol).", clicks = clicks +1 WHERE Symbol = '".$symbol."';";
    }

    mysqli_query($mysqli, $s);

}

/**
 * Function to download dividends from DB to array.
 *
 * @param $symbol
 * @param $mysqli
 * @return array
 */
function loadAllDividendsToArray($symbol, $mysqli){

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
 *
 * @param $symbol
 * @param $mysqli
 * @return array
 */
function loadAllHistoryToArray($symbol, $mysqli){

    $s = "SELECT * FROM histories WHERE symbol = '".$symbol."' ORDER BY date ASC;";

    $result = mysqli_query($mysqli, $s);
    $return = array();
    $i = 0;
    while ($row = mysqli_fetch_array($result)){
        $return[$i][0]=$row[0];//symbol
        $return[$i][1]=$row[1];//date
        $return[$i][2]=$row[2];//open
        $return[$i][3]=$row[3];//high
        $return[$i][4]=$row[4];//low
        $return[$i][5]=$row[5];//close
        $return[$i][6]=$row[6];//adjClose
        $return[$i][7]=$row[7];//volume
        //echo $row[0]." ".$row[1]." ".$row[2]."\n";
        $i+=1;
    }

    return $return;
}

/**
 * Deletes all histories for given symbol from DB.
 * @param $symbol
 * @param $mysqli
 */
function deleteHistories($symbol, $mysqli){
    $s = "DELETE FROM histories WHERE symbol = '".$symbol."';";
    mysqli_query($mysqli, $s);
}

/**
 * Deletes all dividends for given symbol from DB.
 * @param $symbol
 * @param $mysqli
 */
function deleteDividends($symbol, $mysqli){
    $s = "DELETE FROM dividends WHERE symbol = '".$symbol."';";
    mysqli_query($mysqli, $s);
}

/**
 * Deletes all existing dividend data for a symbol and inserts all dividends from given array into diidends-table.
 * Ignores entries with a dividend of <= 0.0.
 *
 * @param $array
 * @param $symbol
 * @param $mysqli
 */
function InsertAllDividends($array, $symbol, $mysqli){

    deleteDividends($symbol, $mysqli);

    $statement = "INSERT INTO dividends (symbol, date, dividend) VALUES ";

    for($i=1; $i<count($array)-1; $i++){

        if($array[$i][1]>0.0){
            $statement = $statement."( '".$symbol."', '".$array[$i][0]."', '".$array[$i][1]."' ), ";
        }
    }
    $statement = rtrim("$statement", ", ");
    $statement = $statement.";";

//    echo $statement;

    mysqli_query($mysqli, $statement);
}

/**
 * Inserts all histories for given symbol and array into histories-table.
 * @param $array
 * @param $symbol
 * @param $mysqli
 */
function InsertAllHistories($array, $symbol, $mysqli){

    deleteHistories($symbol, $mysqli);

    $s = "INSERT INTO histories (symbol, date, open, high, low, close, adjClose, volume) VALUES";

    for($i = 1; $i<count($array)-1; $i++){
        $s = $s."( '".$symbol."', '".$array[$i][0]."', '".$array[$i][1]."', '".$array[$i][2]."', '".$array[$i][3]."', '".$array[$i][4]."', '".$array[$i][5]."', '".$array[$i][6]."' ), ";
    }

    $s = rtrim("$s", ", ");
    $s = $s.";";

    mysqli_query($mysqli, $s);
}

/**
 * For testing.
 * Loads CSV and returns as array.
 *
 * @param $symbol
 * @return array
 */
function getTestDiv($symbol){
    return CSVToArray(getCSV("https://query1.finance.yahoo.com/v7/finance/download/".$symbol."?period1=738540000&period2=1576796400&interval=1mo&events=div&crumb=UO48Nwtc0Va"));
}

/**
 * For testing.
 * Returns sum of dividends payed in a year.
 * Echos to console.
 *
 * @param $year
 * @param $symbol
 */
function payedDividensInYearFromCSV($year, $symbol){
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

/**
 * Returns array with number of payed dividends and sum of payed dividend in a single year.
 *
 * @param $year
 * @param $symbol
 * @param $mysqli
 * @return array
 */
function payedDividendsInYear($year, $symbol, $mysqli){
    $s = "SELECT * FROM dividends WHERE symbol = '".$symbol."' AND date >= '".$year."-01-01' AND date <= '".$year."-12-31' ;";

    $result = mysqli_query($mysqli, $s);
    $return = array();
    $i = 0;
    $sum = 0;
    while ($row = mysqli_fetch_array($result)){
        $i+=1;
        $sum = $sum+$row[3];
    }

    $return[0]=$i;
    $return[1]=$sum;

    /*echo $sum."\n";
    echo $i."\n";*/

    return $return;

}

/**
 * Returns streak of years of dividend payouts.
 * @param $symbol
 * @param $startYear
 * @param $mysqli
 * @return int
 */
function numYearsDividendPayed($symbol, $startYear, $mysqli){
    $s = "SELECT * FROM dividends WHERE symbol = '".$symbol."';";
    $counter = 0;

    $result = mysqli_query($mysqli, $s);

    for($i = $startYear; $i>=1800; $i--){
        //echo $i."\n";
        $x = false;
        //$result = mysqli_query($mysqli, $s);
        while($row = mysqli_fetch_assoc($result)){
            //echo strval($row["date"]);
            if(strpos(strval($row["date"]), strval($i))>-1){
                $counter++;
                $x = true;
                //echo "\nbreak1 ".$counter."\n";
                mysqli_data_seek($result, 0);
                break;

            }
        }
        if($x==false){
            //echo "\nbreak2\n";
            break;
        }

    }

    return $counter;

}

/**
 * Returns all stock data from stocks table.
 * @param $symbol
 * @param $mysqli
 * @return array|null
 */
function getStockData($symbol, $mysqli){
    $s = "SELECT * FROM stocks WHERE symbol = '".$symbol."';";

    $result = mysqli_query($mysqli, $s);

    while ($row = mysqli_fetch_array($result)){
        return $row;
    }

}

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


/**
 * Calculates the average dividend growth in percentage over the last five years for a given stock.
 * Takes a year and goes backwarts from there
 *
 * @param $symbol
 * @param $mysqli
 * @return float|int
 */
function calc5YearsDivGrowth($symbol, $year, $mysqli){
    //$s = "SELECT dividend FROM dividends WHERE date <= '2019-12-31' AND date >= '2014-01-01' AND symbol = 'SKT';";
    //@TODO: Make more fancy, reduce sql queries
    $a = payedDividendsInYear($year, $symbol, $mysqli)[1];
    $year = $year-1;
    $b = payedDividendsInYear($year, $symbol, $mysqli)[1];
    $year = $year-1;
    $c = payedDividendsInYear($year, $symbol, $mysqli)[1];
    $year = $year-1;
    $d = payedDividendsInYear($year, $symbol, $mysqli)[1];
    $year = $year-1;
    $e = payedDividendsInYear($year, $symbol, $mysqli)[1];

    $sum = 0;
    if($b!=0){
        $sum = (($a-$b)/$b);
    }
    if($c!=0){
        $sum = $sum + (($b-$c)/$c);
    }
    if($d!=0){
        $sum = $sum + (($c-$d)/$d);
    }
    if($e!=0){
        $sum = $sum + (($d-$e)/$e);
    }

    return $sum/4;
}

function geometrischesMittel($symbol, $endYear, $range, $mysqli){
    $end = payedDividendsInYear($endYear, $symbol, $mysqli)[1];
    $start = payedDividendsInYear(($endYear-$range), $symbol, $mysqli)[1];

    $result = round((((($end-$start)/($start+0.000000001))+1)**(1/$range)-1)*100, 4);

    return $result;
}

/**
 * Returns if user is premium user or not.
 * 1 = TRUE for premium users, 0 for non-premium users.
 * @param $userID
 * @param $mysqli
 */
function isPremium($userID, $mysqli){
    $s = "SELECT premium FROM user WHERE user_id = '".$userID."';";
    $result = mysqli_query($mysqli, $s);
    while($row = mysqli_fetch_array($result)){
        $return = $row['premium'];
    }
    return $return;
}

/**
 * Sets premium status for user.
 * 1 = true, 0 = false.
 * @param $userID
 * @param $isPremium
 * @param $mysqli
 */
function setPremium($userID, $isPremium, $mysqli){
    $s = "UPDATE user SET premium = ".$isPremium." WHERE user_id = '".$userID."';";
    mysqli_query($mysqli, $s);
}

/**
 * Increases numCalls of an user by one.
 * @param $userID
 * @param $mysqli
 */
function increaseNumCalls($userID, $mysqli){
    $s = "UPDATE user SET numCalls = numCalls + 1 WHERE user_id ='".$userID."';";
    mysqli_query($mysqli, $s);
}

/**
 * Resets numCalls of an user to zero.
 * @param $userID
 * @param $mysqli
 */
function resetNumCalls($userID, $mysqli){
    $s = "UPDATE user SET numCalls = 0 WHERE user_id ='".$userID."';";
    mysqli_query($mysqli, $s);
}

/**
 * Returns numCalls of a single user.
 * @param $userID
 * @param $mysqli
 * @return mixed
 */
function getNumCalls($userID, $mysqli){
    $s = "SELECT numCalls FROM user WHERE user_id = ".$userID.";";
    $result = mysqli_query($mysqli, $s);

    while($row = mysqli_fetch_array($result)){
        $return = $row['numCalls'];
    }
    return $return;

}

/**
 * Returns a 1 if user is allowed to make an request, 0 if it is not a premium user and has exceeded
 * the limit of 5 requests.
 * @param $userID
 * @param $mysqli
 * @return mixed
 */
function callAllowed($userID, $mysqli){

    if(userIsOld($userID, $mysqli)==false) {

        $s = "SELECT IF(premium = 0 AND numCalls > 4, 0, 1) FROM user WHERE user_id = " . $userID . ";";

        $result = mysqli_query($mysqli, $s);
        while ($row = mysqli_fetch_array($result)) {
            $return = $row[0];
        }
        return $return;
    } else {

        $s = "UPDATE user SET timestamp = current_timestamp, numCalls = 0 WHERE user_id = ".$userID.";";
        mysqli_query($mysqli, $s);
        return 1;
    }

}

/**
 *  * Central function for user check.
 * Checks if user is allowed to make a call and returns 1 if it is allowed, 0 if not.
 * Increments numCalls if user is allowed to make a request.
 * @param $userID
 * @param $mysqli
 * @return mixed
 */
function userUpdate($userID, $mysqli){

    $return = callAllowed($userID, $mysqli);

    if($return==1){
        increaseNumCalls($userID, $mysqli);
    }
    return $return;
}

/**
 * Sets the user timestamp to current_timestamp.
 * @param $userID
 * @param $mysqli
 */
function setUserTimestampNow($userID, $mysqli){
    $s = "UPDATE user SET timestamp = current_timestamp WHERE user_id = ".$userID.";";
    mysqli_query($mysqli, $s);
}

/**
 * Checks if users timestamp is older than 24 hours.
 * @param $userID
 * @param $mysqli
 * @return bool
 * @throws Exception
 */
function userIsOld($userID, $mysqli){
    $s = "SELECT timestamp FROM user WHERE user_id='".$userID."';";
    $result = mysqli_query($mysqli, $s);

    while ($row = mysqli_fetch_assoc($result)){
        //echo $row["timestamp"]."\n";
        $timeST = new DateTime($row["timestamp"]);//last updated in DB
        $timeN = new DateTime();//current time
        $i = $timeST->diff($timeN);
        if(intval($i->format("%Y")) > 0 or
            intval($i->format("%m")) > 0 or
            intval($i->format("%d")) > 0){

            //echo $i->format('Age is: %y years %m monts %d days %h hours');
            return true;

        }
    }
    return false;
}





//loadStockIntoDB("AAPL", $mysqli);
//payedDividensInYear("2014", "SKT");
//InsertAllDividends(getTestDiv("SKT"), "SKT", $mysqli);
//checkTime("AAPL", $mysqli);
//calcDivGrowth(loadAllDividendsToArray("SKT", $mysqli));
//loadAllHistoryToArray("SKT", $mysqli);
//primKeyExists("SKT", $mysqli);
//echo getURL_maxT("SKT", true);
//echo "<h1>".getCurrentStockValue('SKT')."</h1>";
//updateDB("MSFT", $mysqli);
//payedDividendsInYear(2014, "SKT", $mysqli);
//getCurrentStockValue("SKT");
//updateStocks("AAPL", $mysqli);
//echo callAllowed(65, $mysqli);
//echo userUpdate(1, $mysqli);
//echo numYearsDividendPayed("SIE.DE", 2019, $mysqli);
//echo geometrischesMittel("SKT", 2019, 10, $mysqli);

?>