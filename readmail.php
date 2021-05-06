<?php
    header('Content-Type: image/gif');
    readfile('tracking.gif');
    // Simple browser and OS detection script. This will not work if User Agent is false.
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    // Detect Device/Operating System
    if(preg_match('/Linux/i',$useragent)) $os = 'Linux';
    elseif(preg_match('/Mac/i',$useragent)) $os = 'Mac'; 
    elseif(preg_match('/iPhone/i',$useragent)) $os = 'iPhone'; 
    elseif(preg_match('/iPad/i',$useragent)) $os = 'iPad'; 
    elseif(preg_match('/Droid/i',$useragent)) $os = 'Droid'; 
    elseif(preg_match('/Unix/i',$useragent)) $os = 'Unix'; 
    elseif(preg_match('/Windows/i',$useragent)) $os = 'Windows';
    else $os = 'Unknown';
    // Browser Detection
    if(preg_match('/Firefox/i',$useragent)) $browser = 'Firefox'; 
    if(preg_match('/Thunderbird/i',$useragent)) $browser = 'Thunderbird'; 
    elseif(preg_match('/Mac/i',$useragent)) $browser = 'Mac';
    elseif(preg_match('/Chrome/i',$useragent)) $browser = 'Chrome'; 
    elseif(preg_match('/Opera/i',$useragent)) $browser = 'Opera'; 
    elseif(preg_match('/MSIE/i',$useragent)) $browser = 'IE'; 
    else $browser = 'Unknown';
    // IP and Port Detection
    $ip = $_SERVER['REMOTE_ADDR'];
    $port = $_SERVER['REMOTE_PORT'];

    $details = json_decode(file_get_contents("http://ip-api.com/json/{$ip}"));
    $isp = $details->isp;
    $city = $details->city;
    $zip = $details->zip;
    $region = $details->regionName;
    $country = $details->country;
    $lat = $details->lat;
    $lon = $details->lon;

    $dsn = "mysql:host={{host}};dbname={{dbname}}";
    $user = "{{username}}";
    $passwd = "{{password}}";
    $pdo = new PDO($dsn, $user, $passwd);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['idmail'])) {
        $sqlsearchmail = $pdo->prepare("SELECT * FROM mail WHERE id=?");
        $sqlsearchmail->execute([$_GET['idmail']]);
        $rowmail = $sqlsearchmail->fetch(PDO::FETCH_ASSOC);
        if ( ! $rowmail) {
            $sqlsearchclient = $pdo->prepare("SELECT * FROM client WHERE ip=? AND useragent=? AND isp=? AND lat=? AND lon=?");
            $sqlsearchclient->execute([$ip,$useragent,$isp,$lat,$lon]);
            $rowclient = $sqlsearchclient->fetch(PDO::FETCH_ASSOC);
            if ( ! $rowclient) {
                $sqlinsertclient = "INSERT INTO client (ip, port, useragent, browser, os, isp, zip, city, region, country, lat, lon) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
                $pdo->prepare($sqlinsertclient)->execute([$ip, $port, $useragent, $browser, $os, $isp, $zip, $city, $region, $country, $lat, $lon]);
                $idclient = $pdo->lastInsertId();
            }
            else {
                $idclient = $rowclient['idclient'];
            }
            date_default_timezone_set('Europe/Paris');
            $datetime = date('Y-m-d H:i:s', time());
            $sqlinsertlog = "INSERT INTO log (idmail, idclient, datetime) VALUES (?, ?, ?)";
            $pdo->prepare($sqlinsertlog)->execute([$_GET['idmail'], $idclient, $datetime]);
        }
        
    }

