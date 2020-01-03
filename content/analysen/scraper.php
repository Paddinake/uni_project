<?php
include_once('simple_html_dom.php');

//@TODO fix operating income & dividends Paid

/**
 * Scrapes currentStockValue, dividend-yield-value, PE-ratio and KGV from yahoo.
 *
 * @param $symbol
 * @return array
 */
function scrape($symbol){

    $html = file_get_html("https://finance.yahoo.com/quote/".$symbol);

    $currentStockValue = 0;
    $KGV=0;
    $FDAndYield="";
    foreach ($html->find('td') as $td)
    {
        if (isset($td-> attr['data-test'])){
            if($td->attr['data-test']=="OPEN-value"){
                $currentStockValue = $td->plaintext;
            }
            if($td->attr['data-test']=="DIVIDEND_AND_YIELD-value"){
                $FDAndYield = $td->plaintext;
            }
            if($td->attr['data-test']=="PE_RATIO-value"){
                $KGV = $td->plaintext;
            }
        }
    }
    //echo $currentStockValue;


    // worst website ever
    //due to changing id u have to find the coulmn with the Payout hours spent on: 3
    $html = file_get_html("https://finance.yahoo.com/quote/".$symbol."/key-statistics");
    $payoutRatio=0;
    $list = $html->find('td');
    $i=0;
    foreach($list as $item){
        if (strpos($item, 'Payout') !== false) {
            if (strpos($list[$i + 1], '%') !== false) {
                $payoutRatio = $list[$i + 1]->innertext();
            }
        }
        $i++;
    }

    return array($currentStockValue, $KGV, $FDAndYield, $payoutRatio);

}


//toDo: ist das wirklich nötig??
/**
 * Scrapes currentStockValue from Yahoo.
 * @param $symbol
 * @return int
 */
function scrapeCurrentValue($symbol){
    $html = file_get_html("https://finance.yahoo.com/quote/".$symbol);

    $currentStockValue = 0;

    foreach ($html->find('td') as $td)
    {
        if (isset($td-> attr['data-test'])){
            if($td->attr['data-test']=="OPEN-value"){
                $currentStockValue = $td->plaintext;
            }
        }
    }

    return $currentStockValue;
}


