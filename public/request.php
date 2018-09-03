<?php
session_start();
// error_reporting(E_ALL);
// ini_set("display_errors", "On");

require_once __DIR__ . '/../src/api.php';

$action = $_REQUEST['action'];
// if($action !== 'Authentication') {
//     if(isset($_SESSION['authentication_key']) && $_SESSION['authentication_key'] !== '') {
//         echo json_encode(array('status'=> false, 'msg'=> 'Authentication Key is Required'))
//     }
// }

if($action == 'Authentication')
{
    if(isset($_SESSION['authentication_key'])) {
        $response = array('status' => true, 'msg' => 'Authentication exists', 'key' => $_SESSION['authentication_key']);
        echo json_encode($response);
    } else {
        $idarts = new IDartsMarketDataAPIConnect();
        $idarts->is_authkey_required = false;
        $response = $idarts->getAuthenticationKey();
        echo json_encode($response);
    }
}
else if($action == 'Logout')
{
    if(isset($_SESSION['authentication_key'])) {
        unset($_SESSION['authentication_key']);
    }

    echo json_encode(array('status' => true));
}
else if($action == 'Snapshot')
{
    $tokens = '[' . $_REQUEST['tokens'] . ']';

    $idarts = new IDartsMarketDataAPIConnect();
    $response = $idarts->getSnapshot($tokens);
    echo json_encode($response);
}
else if($action == 'EOD')
{
    $token = $_REQUEST['token'];
    $no_of_days = $_REQUEST['noOfDays'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];

    $idarts = new IDartsMarketDataAPIConnect();
    $response = $idarts->getEOD($token, $no_of_days, $start_date, $end_date);
    echo json_encode($response);
}
else if($action == 'IEOD')
{
    $token = $_REQUEST['token'];
    $no_of_days = $_REQUEST['noOfDays'];
    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];

    $idarts = new IDartsMarketDataAPIConnect();
    $response = $idarts->getIEOD($token, $no_of_days, $start_date, $end_date);
    echo json_encode($response);
}
else if($action == 'AllExchangeMessage')
{
    $idarts = new IDartsMarketDataAPIConnect();
    $response = $idarts->getAllExchangeMessage();
    echo json_encode($response);
}
else if($action == 'AllExchangeMessageList')
{
    $idarts = new IDartsMarketDataAPIConnect();
    $response = $idarts->getAllExchangeMessage();
    echo json_encode($response);
}

?>