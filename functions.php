<?php

function compteurvisite(){

    if(file_exists('compteur.txt'))
    {
        $compteur_f = fopen('compteur.txt', 'r+');
        $compte = fgets($compteur_f);
    }
    else
    {
        $compteur_f = fopen('compteur.txt', 'a+');
        $compte = 0;
    }
    $compte++;
    fseek($compteur_f, 0);
    fputs($compteur_f, $compte);
    fclose($compteur_f);

    // return $compte;
}

function getBrowser()
{
    $u_agent = $_SERVER['HTTP_USER_AGENT'];
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }

    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Internet Explorer';
        $ub = "MSIE";
    }
    elseif(preg_match('/Firefox/i',$u_agent))
    {
        $bname = 'Mozilla Firefox';
        $ub = "Firefox";
    }
    elseif(preg_match('/Chrome/i',$u_agent))
    {
        $bname = 'Google Chrome';
        $ub = "Chrome";
    }
    elseif(preg_match('/Safari/i',$u_agent))
    {
        $bname = 'Apple Safari';
        $ub = "Safari";
    }
    elseif(preg_match('/Opera/i',$u_agent))
    {
        $bname = 'Opera';
        $ub = "Opera";
    }
    elseif(preg_match('/Netscape/i',$u_agent))
    {
        $bname = 'Netscape';
        $ub = "Netscape";
    }

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
        ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
}

function IpVisiteur(){

    $file="ip.txt";
    $currentFile=fopen($file,'a');
    $current="";
    $today = new DateTime('NOW', new DateTimeZone('Europe/Paris'));
    $today = $today->format('d/m/Y - H:i:s');
    $ipAdress = $_SERVER['REMOTE_ADDR'];

// Fai part

    try {

    $url = "http://ip-api.com/json/".$ipAdress;

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    $response = curl_exec($ch);
    $resultData = json_decode($response, true);

    if ($status = $resultData[status]){
        $fai = $resultData[isp];
        $city = $resultData[city];
        $region = $resultData[regionName];
        $codePostal = $resultData[zip];
        $organisation = $resultData[org];
    } else {
        $fai = "failed to get";
        $city = "failed to get";
        $region = "failed to get";
        $codePostal = "failed to get";
        $organisation = "failed to get";
    }


    } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }

// End Fai part

// meteo part

    try {

        $url = "http://api.openweathermap.org/data/2.5/weather?lat=".$lat."&lon=".$long."&lang=fr&APPID=".$meteoKey; //Go get a key to openWeathermap.com
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-type: application/json')); // Assuming you're requesting JSON
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        $response = curl_exec($ch);
        $resultData = json_decode($response, true);

        $meteo=$resultData[weather][0][description];

    } catch (Exception $e) {
        echo 'Exception reçue : ',  $e->getMessage(), "\n";
    }

// End meteo part

    fwrite($currentFile,$current);
    fclose($currentFile);
    echo ""; //close call

    return array(
        'IP' => $ipAdress,
        'city'      => $city,
        'zip'   => $codePostal,
        'region'  => $region,
        'isp'    => $fai,
        'oragnisation'    => $organisation,
        'meteo'    => $meteo
    );

}
