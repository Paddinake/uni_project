<?php

function JSONRequest(){
    $API_KEY = "H29RHD627K8CRWPT";
    $curl = curl_init();
    $service_url = "https://www.alphavantage.co/query?function=TIME_SERIES_WEEKLY&symbol=MSFT&apikey=".$API_KEY;


    curl_setopt_array($curl, array(
        CURLOPT_RETURNTRANSFER => 1,
        CURLOPT_URL => $service_url
    ));

    $result = curl_exec($curl); //Response von Server als JSON

    curl_close($curl);
    return ($result);
}

