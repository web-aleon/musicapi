<?php


function wbh_getApiDate(){

	date_default_timezone_set('UTC');
	return date('d.m.Y', strtotime('now'));

}


function wbh_getDjbayTracks($datestring){
	
	if ( !$datestring || ($datestring == '') ){
		$date = wbh_getApiDate();
	} else {
		$date = $datestring;
	}
	
	$apiUrl = 'https://djbay.pro/api/tracks/' . $date;
	
	$djbayCurl = curl_init();
	
	$header = array('Accept: text/json','who: me');
	$options = array(
		CURLOPT_URL => $apiUrl, // 'https://djbay.pro/api/tracks/25.06.2017'
		CURLOPT_HEADER => FALSE,
		CURLOPT_HTTPHEADER => $header,
		CURLOPT_RETURNTRANSFER => TRUE
	);
	curl_setopt_array($djbayCurl, $options);

	$djbayJSON = curl_exec($djbayCurl);
	
	curl_close($djbayCurl);

	return json_decode($djbayJSON, true);
	
}

