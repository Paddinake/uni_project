<?php

function JSONRequest($symbol){
    $API_KEY = "H29RHD627K8CRWPT";
    $curl = curl_init();
    $service_url = "https://www.alphavantage.co/query?function=TIME_SERIES_WEEKLY&symbol=".$symbol."&apikey=".$API_KEY;


    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $service_url
    ));

    $result = curl_exec($curl); //Response von Server als JSON

    curl_close($curl);
    return ($result);
}

//function = SYMBOL_SEARCH
function JSONRequestSearch($function, $input){
    $API_KEY = "H29RHD627K8CRWPT";
    $curl = curl_init();
    $service_url = "https://www.alphavantage.co/query?function=".$function."&keywords=".$input."&apikey=".$API_KEY;


    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $service_url
    ));

    $result = curl_exec($curl); //Response von Server als JSON

    curl_close($curl);
    return ($result);

}


function JSONRequestSTOCH($symbol){
    $API_KEY = "H29RHD627K8CRWPT";
    $curl = curl_init();
    $service_url = "https://www.alphavantage.co/query?function=STOCH&symbol=". $symbol."&interval=daily&apikey=".$API_KEY;


    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $service_url
    ));

    $result = curl_exec($curl); //Response von Server als JSON

    curl_close($curl);
    return ($result);
}


