<?php

header ('Content-type: application/json');
header('Access-Control-Allow-Origin: *');
	
$appid = "Universi-6e5f-4c10-8731-fc5231d4d60d";
$url = "http://svcs.eBay.com/services/search/FindingService/v1?siteid=0&SECURITY-APPNAME=$appid&OPERATION-NAME=findItemsAdvanced&SERVICE-VERSION=1.0.0&RESPONSE-DATA-FORMAT=XML&";
$eBay = $_GET["ebayUrl"];
$eBay = str_replace("%3D","=",$eBay);
$eBay = str_replace("%26","&",$eBay);
$eBay = str_replace("%5B","[",$eBay);
$eBay = str_replace("%5D","]",$eBay);
$url .= $eBay;
$obj = simplexml_load_file($url);
$results = $obj->searchResult;
$AdvResp = $obj->findItemsAdvancedResponse;
$pagout = $obj->paginationOutput;
$count = $results['count'];

$arr["ack"] = $obj->ack;
$arr["resultCount"] = $pagout->totalEntries;
$arr["pageNumber"] = $pagout->pageNumber;
$arr["itemCount"] = $pagout->entriesPerPage;
//$arr["totalEntries"] = $pagout->totalEntries;


  for ($x = 0; $x <$count; $x++) 
  {
    $item = array();
	$bi = array();
	$si = array();
	$shi= array();
	
	//Fill basic info
	if($results->item[$x]->title)
	$bi["title"] = $results->item[$x]->title;
	if($results->item[$x]->viewItemURL)
	$bi["viewItemURL"] = $results->item[$x]->viewItemURL;
	if($results->item[$x]->galleryURL)
	$bi["galleryURL"] = $results->item[$x]->galleryURL;
	if($results->item[$x]->pictureURLSuperSize)
	$bi["pictureURLSuperSize"] = $results->item[$x]->pictureURLSuperSize;
	if($results->item[$x]->sellingStatus->convertedCurrentPrice)
	$bi["convertedCurrentPrice"] = $results->item[$x]->sellingStatus->convertedCurrentPrice;
	
	if($results->item[$x]->shippingInfo->shippingServiceCost)
		$bi["shippingServiceCost"] = $results->item[$x]->shippingInfo->shippingServiceCost;
	if($results->item[$x]->condition->conditionDisplayName)
	$bi["conditionDisplayName"] = $results->item[$x]->condition->conditionDisplayName;
	if($results->item[$x]->listingInfo->listingType)
	$bi["listingType"] = $results->item[$x]->listingInfo->listingType;
	if($results->item[$x]->location)
	$bi["location"] = $results->item[$x]->location;
	if($results->item[$x]->primaryCategory->categoryName)
	$bi["categoryName"] = $results->item[$x]->primaryCategory->categoryName;
	if($results->item[$x]->topRatedListing)
	$bi["topRatedListing"] = $results->item[$x]->topRatedListing;
	
	//Fill seller info
	if($results->item[$x]->sellerInfo->sellerUserName)
	$si["sellerUserName"] = $results->item[$x]->sellerInfo->sellerUserName;
	if($results->item[$x]->sellerInfo->feedbackScore)
	$si["feedbackScore"] = $results->item[$x]->sellerInfo->feedbackScore;
	if($results->item[$x]->sellerInfo->positiveFeedbackPercent)
	$si["positiveFeedbackPercent"] = $results->item[$x]->sellerInfo->positiveFeedbackPercent;
	if($results->item[$x]->sellerInfo->feedbackRatingStar)
	$si["feedbackRatingStar"] = $results->item[$x]->sellerInfo->feedbackRatingStar;
	if($results->item[$x]->sellerInfo->topRatedSeller)
	$si["topRatedSeller"] = $results->item[$x]->sellerInfo->topRatedSeller;
	if($results->item[$x]->storeInfo->storeName)
	$si["sellerStoreName"] = $results->item[$x]->storeInfo->storeName;
	if($results->item[$x]->storeInfo->storeURL)
	$si["sellerStoreURL"] = $results->item[$x]->storeInfo->storeURL;
	
	//Fill Shipping info
	if($results->item[$x]->shippingInfo->shippingType)
	$shi["shippingType"] = $results->item[$x]->shippingInfo->shippingType;
	if($results->item[$x]->shippingInfo->shipToLocations)
	$shi["shipToLocations"] = $results->item[$x]->shippingInfo->shipToLocations;
	if($results->item[$x]->shippingInfo->expeditedShipping)
	$shi["expeditedShipping"] = $results->item[$x]->shippingInfo->expeditedShipping;
	if($results->item[$x]->shippingInfo->oneDayShippingAvailable)
	$shi["oneDayShippingAvailable"] = $results->item[$x]->shippingInfo->oneDayShippingAvailable;
	if($results->item[$x]->returnsAccepted)
	$shi["returnsAccepted"] = $results->item[$x]->returnsAccepted;
	if($results->item[$x]->shippingInfo->handlingTime)
	$shi["handlingTime"] = $results->item[$x]->shippingInfo->handlingTime;
	
	//--------------
	$item['basicInfo'] = $bi;
	$item['sellerInfo'] = $si;
	$item['shippingInfo'] = $shi;
	$arr['item'.$x] = $item; 
  }
  

echo $_GET['callback'] . '('.json_encode($arr).');';
?>
