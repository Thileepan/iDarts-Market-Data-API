<?php

/*
 * This is the sample PHP class which explains how to connect the iDarts Market Data 
 * REST and Streaming API and get the response for different supported API's.
 *
 * API Documents are available online at https://infini.tradeplusonline.com/api/documents
 */

class IDartsMarketDataAPIConnect
{
	private $url = 'https://infini.tradeplusonline.com/api/';
	private $authentication = false;
	private $headers = "";

	private function callAPI($method, $api)
	{
	    // create a new cURL resource
		$ch = curl_init();
		// set URL and other appropriate options
		curl_setopt($ch, CURLOPT_URL, $this->url . $api);
		//curl_setopt($ch, CURLOPT_HTTPHEADER, $this->headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
		$response = curl_exec($ch);
		$data = json_decode($response, JSON_PRETTY_PRINT);

	    /* Check for 404 (file not found). */
	    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	    // Check the HTTP Status code
	    switch ($httpCode) {
	        case 200:
	            $error_status = "200: Success";
	            return ($data);
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
	    echo $error_status;
	    die;
	}

	public function useAuth()
	{ 
       $this->authentication = true;
    }

	public function getAllExchangeMessage()
	{
		$api = 'ExchangeMessage';
		return $this->callAPI('GET', $api);
	}

	public function getSpecificExchangeMessage($segment_id)
	{
		$api = 'ExchangeMessage/' . $segment_id;
		return $this->callAPI('GET', $api);
	}

	public function getAllExchangeList()
	{
		$api = 'Masters/Exchanges';
		return $this->callAPI('GET', $api);
	}

	public function getAllInstrumentList()
	{
		$api = 'Masters/Instruments';
		return $this->callAPI('GET', $api);
	}
}

?>