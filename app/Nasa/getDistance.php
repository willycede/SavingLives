<?php
function distance($lat1, $lon1, $lat2, $lon2) {

    $theta = floatval(floatval($lon1) - floatval($lon2));
    $dist = floatval(sin(deg2rad($lat1)) )* floatval(sin(deg2rad($lat2))) +  floatval(cos(deg2rad($lat1))) * floatval(cos(deg2rad($lat2))) * floatval(cos(deg2rad($theta)));
    $dist = floatval(acos($dist));
    $dist = floatval(rad2deg($dist));
    $miles = floatval($dist * 60 * 1.1515);
    $unit = "K";
  
    if ($unit == "K") {
      return floatval($miles * 1.609344);
    } else if ($unit == "N") {
        return floatval($miles * 0.8684);
      } else {
          return floatval($miles);
        }
  }

?>