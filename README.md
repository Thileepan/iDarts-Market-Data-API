# iDarts-Market-Data-API
This is the sample PHP examples which explains how to connect the iDarts Market Data REST and Streaming API and get the response for different supported API's.

# Documentation
Documentation is available at https://infini.tradeplusonline.com/api/documents

# Example
To run the example, please open the example.php and UNCOMMENT the desired API and browse the same file from your browser which will print the response in JSON format.

Sample:
//Provide all segment published messages
$idarts = new IDartsMarketDataAPIConnect();
$response = $idarts->getAllExchangeMessage();

//Provide all segment published messages
$idarts = new IDartsMarketDataAPIConnect();
$segment_id = 5;
$response = $idarts->getSpecificExchangeMessage($segment_id);
