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

    echo '<iframe width="600" height="450" frameborder="0" style="border:0"src="https://www.google.com/maps/embed/v1/view?zoom=15&center='.ipvisiteur()[lat].'%2C'.ipvisiteur()[long].'&key=AIzaSyA9K0iXsKryBJal4HJir5UQKe_0VqXx0cY" allowfullscreen></iframe>';
    echo '<p style="">your ip is '.ipvisiteur()[IP].' your isp is '.ipvisiteur()[isp].' your city is '.ipvisiteur()[city].' your Zip code is'.ipvisiteur()[zip].' and your region is '.ipvisiteur()[region].'Navigateur : '.getBrowser()[name].' OS : '.getBrowser()[platform].'</p>';
    echo'<p style=""><a href="https://github.com/MehdyDriouech/EasyTrack" aria-label="Dépot Github">Github </a></p>';
?>