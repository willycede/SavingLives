<?php

class Row
{
   public $latitude;
   public $longitude;
   public $date;
   public $daynight;
   

   function __construct($latitude,$longitude,$daynight,$date) {

    $GLOBALS['longitude']=$longitude;
    $GLOBALS['latitude']=$latitude;
    $GLOBALS['daynight']=$daynight;
    $GLOBALS['date']=$date;    
}




}

?>