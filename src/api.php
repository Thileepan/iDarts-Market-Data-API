<?php

/*
 * This is the sample PHP class which explains how to connect the iDarts Market Data 
 * REST and Streaming API and get the response for different supported API's.
 *
 * API Documents are available online at https://infini.tradeplusonline.com/api/documents
 */

// error_reporting(E_ALL);
// ini_set("display_errors", "On");

class IDartsMarketDataAPIConnect
{
	private $eod_url  = 'http://www.dartstech.com/iddataservice/diDataservice.aspx';
	private $ieod_url  = 'http://www.dartstech.com/iddataservice/diIntra.aspx';
	private $snapshot_url  = 'http://180.179.151.146/api/snapshot/Quotes';
	private $authentication_url = 'http://180.179.151.146/IDAUTH/login.aspx';
	private $username = 'Darts002';
	private $password = 'darts002';
	private $response = array();

	//Authentication Key is required for every API request
	public $is_authkey_required = true;

	// public function __construct()
	// {
	// 	if($this->is_authkey_required) {
	// 		if(isset($_SESSION['authentication_key']) && $_SESSION['authentication_key'] !== '') {

	// 		}
	// 	}
	// }

	private function writeToLog($message)
	{
		if ( file_exists($this->config_file) && ($fp = fopen($this->config_file, "w"))!==false ) {
		  fwrite($fp, date("Y-m-d H:i:s") . " : " . $message . "\n");
		  fclose($fp);
		}
	}

	public function getAuthenticationKey()
	{
		$this->response['status'] = false;
		$this->response['msg'] = 'Unable to get the authentication key';
		$this->response['key'] = '';
		$this->authentication_url .= "?UserId=" . $this->username . "&Password=" . $this->password . "&Provider=TRUEDATA";
		$this->is_authkey_required = false;
		
		$response = $this->callAPI('POST', $this->authentication_url, '', 'text');
		if($response['code'] == 200) {
			$authentication_data = $response['data'];
			if (strpos($authentication_data, 'STLK') === 0) {
			   $this->response['msg'] = 'Account Locked';
			} else if (strpos($authentication_data, 'IV') === 0) {
			   $this->response['msg'] = 'Invalid User Name and Password';
			} else if (strpos($authentication_data, 'SE') === 0 || strpos($authentication_data, 'DU') === 0 || strpos($authentication_data, 'EX') === 0) {
			   $this->response['msg'] = 'Authentication failed.. Please try after 3 mins';
			} else {
				$this->response['status'] = true;
				$this->response['msg'] = 'Authentication Received';
				$this->response['key'] = preg_split('/\r\n|\r|\n/', $authentication_data)[0];
				$_SESSION['authentication_key'] = $this->response['key'];
			}
		}
		return $this->response;
	}

	public function getSnapshot($tokens)
	{
		$this->response['status'] = false;
		$this->response['msg'] = 'Unable to get the snapshot values';

		$data_to_post = $tokens;
		$response = $this->callAPI('POST', $this->snapshot_url, $data_to_post, 'json');
		if($response['code'] == 200) {
			$this->response['status'] = true;
			$this->response['msg'] = 'Snapshot values are received';
			$this->response['data'] = $response['data'];
		}
		return $this->response;
	}

	public function getEOD($token, $no_of_days, $start_date, $end_date)
	{
		$this->response['status'] = false;
		$this->response['msg'] = 'Unable to get the EOD values';
		$this->eod_url .= "?cmd=hdly&r=1&t=" . $token;
		if($no_of_days > 0) {
			$this->eod_url .= "&nd=" . $no_of_days;
		} else {
			$this->eod_url .= "&sd=" . $start_date . "&ed=" . $end_date;
		}

		$response = $this->callAPI('GET', $this->eod_url, '', 'text');
		if($response['code'] == 200) {
			$this->response['status'] = true;
			$this->response['msg'] = 'Snapshot values are received';
			$this->response['data'] = $response['data'];
		}
		return $this->response;
	}

	public function getIEOD($token, $no_of_days, $start_date, $end_date)
	{
		$this->response['status'] = false;
		$this->response['msg'] = 'Unable to get the IEOD values';
		$this->ieod_url .= "?cmd=hmin&min=1&t=" . $token;
		if($no_of_days > 0) {
			$this->ieod_url .= "&nd=" . $no_of_days;
		} else {
			$this->ieod_url .= "&sd=" . $start_date . "&ed=" . $end_date;
		}

		$response = $this->callAPI('GET', $this->ieod_url, '', 'text');
		if($response['code'] == 200) {
			$this->response['status'] = true;
			$this->response['msg'] = 'Snapshot values are received';
			$this->response['data'] = $response['data'];
		}
		return $this->response;
	}

	public function getAllExchangeMessage()
	{
		$api = 'ExchangeMessage';
		return $this->callAPI('GET', $api, '', 'json');
	}

	public function getSpecificExchangeMessage($segment_id)
	{
		$api = 'ExchangeMessage/' . $segment_id;
		return $this->callAPI('GET', $api, '', 'json');
	}

	public function getAllExchangeList()
	{
		$api = 'Masters/Exchanges';
		return $this->callAPI('GET', $api, '', 'json');
	}

	public function getAllInstrumentList()
	{
		$api = 'Masters/Instruments';
		return $this->callAPI('GET', $api, '', 'json');
	}

	private function callAPI($http_method, $url, $data_to_post, $return_type)
	{
		$headers = array();
		$headers[0] = "Content-Length: " . strlen($data_to_post);
		
		if($this->is_authkey_required) {
			$headers[1] = "X-AuthZ: " . $_SESSION['authentication_key'];
		}

		// create a new cURL resource
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $url);
		if($data_to_post !== '') {
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data_to_post);	
		}
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, $http_method);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);

		$data = curl_exec($ch);
		if($return_type == 'json') {
			$data = json_decode($data, JSON_PRETTY_PRINT);
		}

		//print_r($headers);

		/* Check for 404 (file not found). */
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

	    // Check the HTTP Status code
	    switch ($httpCode) {
	        case 200:
	            $error_status = "200: Success";
	            break;
	        case 404:
	            $error_status = "404: API Not found";
	            break;
	        case 500:
	            $error_status = "500: servers replied with an error.";
	            break;
	        case 502:
	            $error_status = "502: servers may be down or being upgraded. Hopefully they'll be OK soon!";
	            break;
	        case 503:
	            $error_status = "503: service unavailable. Hopefully they'll be OK soon!";
	            break;
	        default:
	            $error_status = "Undocumented error: " . $httpCode . " : " . curl_error($ch);
	            break;
	    }
	    curl_close($ch);

	    $to_return = array();
	    $to_return['code'] = $httpCode;
	    $to_return['msg'] = $error_status;
	    $to_return['data'] = $data;

	    //print_r($to_return);
	    return $to_return;
	}
}

?>