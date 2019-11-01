<?php
include "json_requests.php";

header('Content-Type: application/json');

$aResult = array();

if( !isset($_POST['functionname']) ) { $aResult['error'] = 'No function name!'; }

if( !isset($_POST['arguments']) ) { $aResult['error'] = 'No function arguments!'; }

if( !isset($aResult['error']) ) {

    switch($_POST['functionname']) {
        case 'JSONRequestSearch':
            if( !is_array($_POST['arguments']) || (count($_POST['arguments']) < 2) ) {
                $aResult['error'] = 'Error in arguments!';
            }
            else {
                $json = JSONRequestSearch($_POST['arguments'][0], $_POST['arguments'][1]);
                //Wir brauchen nur Name und Symbol
                $result = json_decode($json, true);

                $bestResults = array();

                foreach ($result["bestMatches"] as $entry){
                    array_push($bestResults, array($entry["1. symbol"], $entry["2. name"]));
                    }
                $aResult['result'] = $bestResults;
            }
            break;

        default:
            $aResult['error'] = 'Not found function '.$_POST['functionname'].'!';
            break;
    }

}

echo json_encode($aResult);

?>
