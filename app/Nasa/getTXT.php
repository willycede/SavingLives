
   <?php
   include 'row.php';

    
    $date=dayxD();
    //echo $date;
    
   $curl_h = curl_init('https://nrt4.modaps.eosdis.nasa.gov/api/v2/files/contents/FIRMS/viirs/South_America/VIIRS_I_South_America_VNP14IMGTDL_NRT_'.$date.'.txt');
  
   
   curl_setopt($curl_h, CURLOPT_HTTPHEADER,
       array(
           'Authorization: Bearer 20CCD92A-D496-11E8-8EFF-D1089B439298',
       )
   );
   
   # do not output, but store to variable
   curl_setopt($curl_h, CURLOPT_RETURNTRANSFER, true);
   
   $response = curl_exec($curl_h);
   //echo $response;

   $split1=  explode("\n",$response);
  // $split2;
$split2=array();
   for($i=0;$i<count($split1);$i++){
      
      $split2[$i]= explode(",",$split1[$i]);

   }
   
      
   // echo  (strval($split2[0][1]));
   $data= array();

   for($i=1;$i<count($split1)-1;$i++){
    $p1=$split2[$i][0];
    $p2=$split2[$i][1];
    
    $p6=$split2[$i][5];
    
    $p13=$split2[$i][12];

    //echo $split2[$i][1];
    $object = (object) [
        'latitud' => $p1,
        'longitud' => $p2,
        'daynight' => $p13,
        'date' => $p6,        
      ];
    array_push($data,$object);
    



}

$myJSON = json_encode($data);
echo $myJSON;


 
 



   function dayxD()
    {
        $month=date("m");
        $day=date("d");
        $year=date("Y");;
        $julian=0;
        $months = array(31,28,31,30,31,30,31,31,30,31,30,31);
        for($i=0;$i<$month-1;$i++)
        {
            $julian+=$months[$i];
            //echo $julian;
        }

        $julian+=$day;

        return strval($year.($julian-1));
 
    }

   
?>
