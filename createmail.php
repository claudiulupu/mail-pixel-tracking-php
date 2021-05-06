<?php
    $dsn = "mysql:host={{host}};dbname={{dbname}}";
    $user = "{{username}}";
    $passwd = "{{password}}";
    $pdo = new PDO($dsn, $user, $passwd);

    if ($_SERVER['REQUEST_METHOD'] == 'GET' && isset($_GET['subject'])) {
        date_default_timezone_set('Europe/Paris');
        $datetime = date('Y-m-d H:i:s', time());
        $sql = "INSERT INTO mail (subject, datetime) VALUES (?, ?)";
        $pdo->prepare($sql)->execute([$_GET['subject'], $datetime]);
        echo $pdo->lastInsertId();
    }