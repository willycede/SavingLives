<?php

include 'getDistance.php';

$curl_h = curl_init('http://localhost/Nasa/getTXT.php');
  

# do not output, but store to variable
curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);

$response = curl_exec($curl_h);

$datos=json_decode($response,true);

foreach($datos as $key=> $dato)
{
    $dist=distance(floatval($datos[$key]['latitud']),floatval($datos[$key]['longitud']),floatval($datos[$key]['latitud']),floatval($datos[$key]['longitud']));
    if (is_nan($dist) || $dist<=0.001)
    {
        $dist=0;
    }
    if($dist<=2)
    {

    }


}
    
?>