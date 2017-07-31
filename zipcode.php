<?php
/**
 * Created by PhpStorm.
 * User: Alex Lilik
 * Date: 20.06.2017
 * Time: 8:08
 */

error_reporting(0);

require_once('adminpanel/assets/php/db_params.php') ;
require_once('adminpanel/assets/php/dbDriver.php') ;

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['zipcode'])) {
	$zipCode = $_POST['zipcode'];

	$url = 'http://xmlapi.viewerlink.tv/collectXML.asp';

	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_POST, true );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, array('Content-Type: text/xml'));
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, "<K2DATACOLLECTOR><CLIENT>21D35A1A</CLIENT><ZIPCODE>".$zipCode."</ZIPCODE></K2DATACOLLECTOR>" );

	$result = curl_exec($ch);
	curl_close($ch);

	$output = simplexml_load_string($result);


	// Loading from db providers list -------------------------------------------


    $mysqli = new dbDriver($dbHostName, $dbUser, $dbPassword, $dbName);
    $urlarray = $mysqli->readDbList() ;
    $mysqli->dbCloseConnect();


    $urls = array() ;
	foreach ($urlarray as $item => $value ){
        $urls[$value['key']] = $value['link'] ;
	}

	//----------- channels asp response loop -------------------------------------

	$result = array();
	foreach($output->PROVIDER as $provider){

		if (empty($provider->CHANNEL)){
			continue;
		}


		$key = $provider->NAME ;                          // get the channel name
		$key = strtoupper(trim($key)) ;
		$key = str_replace(" ","",$key);
		$key = str_replace("%26","",$key); // delete %26 symbols from AT$26T
		$key = str_replace("-","",$key);   // delete - symbol from U-Verse
		$hrefLink = $urls[$key] ;                         //get the channel URL from array $urls


		if(strlen($hrefLink) > 0){                           // put the real or empty  link into XML object
			$provider->LINK = $hrefLink ;
		}

		$result['PROVIDER'][] = $provider;

	}
	// -----------------------------------------------

	// ----  Append YouTube TV  and Hulu TV to the JSON outout object -----------------

	$youtube = array ('NAME'=> 'YouTube TV'   , 'STATUS' => '1', 'CHANNEL' => '', 'HDCHANNEL' => '', 'LINK' => 'https://tv.youtube.com/') ;
	$hulu    = array ('NAME'=> 'Hulu' , 'STATUS' => '1', 'CHANNEL' => '', 'HDCHANNEL' => '', 'LINK' => 'https://hulu.com/') ;

	$result['PROVIDER'][] = $hulu ;
	$result['PROVIDER'][] = $youtube ;

	// --------------------------------------------------------------------------------------------------------------

	$result['K2STATUS'] = (empty($result)) ? 'FAILED' : 'SUCCESS';





	echo json_encode($result);  // return JSON object

}
?>
