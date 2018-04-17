<!DOCTYPE html>
<html lang="fr">

<head>
  
<title>To Track </title>


</head>


<?php

    include 'functions.php';

	echo"<p style='font-size: medium;'>You are tracked -- Demo purpose</p>";
    echo'<p style=""><a href="http://easy-track.mehdydriouech.fr/visiteip.php" aria-label="other tracked people">see other tracked people</a></p>';



    compteurvisite();
    IpVisiteur();

    $ipAdress = $_SERVER['REMOTE_ADDR'];

     $url = "http://ip-api.com/json/".$ipAdress;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    $resultData = json_decode($response, true);

    if ($status = $resultData[status]){
        $lat = $resultData[lat];
        $long = $resultData[lon];

        $fai = $resultData[isp];
        $city = $resultData[city];
        $region = $resultData[regionName];
        $codePostal = $resultData[zip];
    } else {
        $lat = "42";
        $long = "4.2";

        $fai = "NOPE";
        $city = "NOPE";
        $region = "NOPE";
        $codePostal = "NOPE";
    }



    echo '<iframe width="600" height="450" frameborder="0" style="border:0"src="https://www.google.com/maps/embed/v1/view?zoom=15&center='.$lat.'%2C'.$long.'&key=AIzaSyA9K0iXsKryBJal4HJir5UQKe_0VqXx0cY" allowfullscreen></iframe>';
    echo '<p style="">your ip is '.$ipAdress.' your isp is '.$fai.' your city is '.$city.' your Zip code is'.$codePostal.' and your region is '.$region.'</p>';
    echo'<p style=""><a href="https://github.com/MehdyDriouech/EasyTrack" aria-label="Dépot Github">Github </a></p>';
?>