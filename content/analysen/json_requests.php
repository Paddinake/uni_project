<?php

function mainCurl($service_url){
    $response = file_get_contents($service_url);
    return ($response);

}

function JSONRequest($symbol){
    $API_KEY = "H29RHD627K8CRWPT";
    $service_url = "https://www.alphavantage.co/query?function=TIME_SERIES_WEEKLY&symbol=".$symbol."&apikey=".$API_KEY;
    $result = mainCurl($service_url);
    return ($result);
}

//function = SYMBOL_SEARCH
function JSONRequestSearch($function, $input){
    $API_KEY = "H29RHD627K8CRWPT";
    $service_url = "https://www.alphavantage.co/query?function=".$function."&keywords=".$input."&apikey=".$API_KEY;
    $result = mainCurl($service_url);
    return ($result);

}


function JSONRequestSTOCH($symbol){
    $API_KEY = "H29RHD627K8CRWPT";
    $service_url = "https://www.alphavantage.co/query?function=STOCH&symbol=". $symbol."&interval=daily&apikey=".$API_KEY;
    $result = mainCurl($service_url);
    return ($result);
}


