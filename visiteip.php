<!DOCTYPE html>
<html lang="fr">

<head>
  
<title>On met en production ?</title>
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="Content-Type" content="UTF-8">

</head>

<?php

echo "<p class='titre'>IP of users</p>";
echo "<br>";

$fichier = 'compteur.txt';

if ( (file_exists($fichier)) && (is_readable($fichier)) ){
    $text = file_get_contents($fichier);
    echo'<p>COMPTEUR</p>';
    echo'<p> The TOTRACK page was visited : '.$text.' times.</p>';
    echo "<br>";
}
else
{
    echo 'The file :  '.$fichier.' don\'t exist or is\'t available ';
    echo "<br>";
}


$array = file("ip.txt");
foreach($array as $line)
       {
           echo "<p>".$line."</p>";
       }

?>