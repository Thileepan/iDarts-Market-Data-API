<?php

/*
 * This is the example PHP code which demonstrates how to work with iDarts Market Data API.
 * 
 * How to try this example?
 * ========================
 * 
 * Just Uncomment the desired/any one of the below API and 
 * just browse this file (example.php) from your browser to see the response.
 * 
 */

require_once __DIR__ . '/../src/api.php';

//Base Class to connect the iDarts
$idarts = new IDartsMarketDataAPIConnect();

//Provide all segment published messages
$response = $idarts->getAllExchangeMessage();

//Provide segment specific message
//$segment_id = 5;
//$idarts->getSpecificExchangeMessage($segment_id);

//Api to get available exchange list
//$idarts->getAllExchangeList();

//Api to get available instrument list
//$idarts->getAllInstrumentList();

// PRINT THE RESPONSE AS PRETTY JSON
header('Content-Type: application/json');
$pretty_output = json_encode($response);
echo $pretty_output;

?>