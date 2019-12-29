<?php
include_once('simple_html_dom.php');

//@TODO fix scrapper
function scrape($symbol){
    {
        $html = file_get_html("https://finance.yahoo.com/quote/".$symbol."/financials");

        $operatingIncome=0;
        foreach ($html->find('span') as $span)
        {
            if (isset($span-> attr['data-reactid'])){
                if($span->attr['data-reactid']==179){

                    $operatingIncome = $span->plaintext;
                }
            }
        }
        echo "\noperating income ".$operatingIncome;

        $html = file_get_html("https://finance.yahoo.com/quote/".$symbol."/cash-flow");

        $dividendsPaid=0;
        foreach ($html->find('span') as $span)
        {
            if (isset($span-> attr['data-reactid'])){
                if($span->attr['data-reactid']==431){
                    $dividendsPaid = $span->plaintext;
                }
            }
        }
        echo "\ndividendspaid ".$dividendsPaid;


        $html = file_get_html("https://finance.yahoo.com/quote/".$symbol);


        $currentStockValue = 0;
        $KGV=0;
        $FDAndYield="";
        foreach ($html->find('span') as $span)
        {
            if (isset($span-> attr['data-reactid'])){
                if($span->attr['data-reactid']==34){
                    $currentStockValue = $span->plaintext;
                }
                if($span->attr['data-reactid']==95){
                    $KGV = $span->plaintext;
                }
                if($span->attr['data-reactid']==111){
                    $FDAndYield = $span->plaintext;
                }
            }
        }
        echo "\ncurrentStockValue ".$currentStockValue;
        echo "\nkgv ".$KGV;
        echo "\nFDAndYield ".$FDAndYield."\n";

        return array($currentStockValue, $operatingIncome, $dividendsPaid, $KGV, $FDAndYield);
    }
}

//scrape("SKT");


