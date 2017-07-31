<?php
/**
 * Created by PhpStorm.
 * User: Lilik Aleksandr
 * Date: 12.06.17
 * Time: 11:03
 */

error_reporting(0);

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

    //----------- channels asp response loop -------------------------------------

    $result = array();

    foreach($output->PROVIDER as $provider){
        $name = $provider->NAME ;                          // get the channel name in any case

        $key = strtoupper(trim($name)) ;                 //start to format KEY
        $key = str_replace(" ","",$key);
        $key = str_replace("%26","",$key); // delete %26 symbols from AT%26T
        $key = str_replace("-","",$key);   // delete - symbol from U-Verse

        $provider->KEY = $key ;                     // put the KEY into XML object

        if(empty($provider->CHANNEL)) {$provider->CHANNEL = ' - ';}

        $result['PROVIDER'][] = $provider;

    }
    // -----------------------------------------------


    $result['K2STATUS'] = (empty($result)) ? 'FAILED' : 'SUCCESS';

    echo json_encode($result);  // return JSON object with channel KEY

}
?>