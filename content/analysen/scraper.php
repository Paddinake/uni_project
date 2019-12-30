<?php
include_once('simple_html_dom.php');

//@TODO fix operating income & dividends Paid
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

    $html = file_get_html("https://finance.yahoo.com/quote/".$symbol."/key-statistics");
    //echo $html;
    $payoutRatio=0;
    foreach ($html->find('td') as $td)
    {
        if (isset($td-> attr['data-reactid'])){
            if($td->attr['data-reactid']==291){
                $payoutRatio = $td->plaintext;
            }
        }
    }
//        echo "\ncurrentStockValue ".$currentStockValue;
//        echo "\nkgv ".$KGV;
//        echo "\nFDAndYield ".$FDAndYield."\n";

        return array($currentStockValue, $KGV, $FDAndYield, $payoutRatio);

}

