<?php

if (empty($_REQUEST['submit_btn'])) {
    return;
}

$log = $_REQUEST['login'];
$pas = $_REQUEST['password'];

require 'PDO.php';

$pdo or exit('Error -db');
$query = "SELECT * FROM `users` WHERE `login`= '$log' and `password`= '$pas'";
$qResult = $pdo->query($query)->fetchAll();

$logined = $qResult;

$URL = 'http://localhost/sem_1/index.php';

header('Location: '.$URL);

foreach ($qResult as $user) {
    foreach ($user as $key => $value) {
        echo "$key -> $value <br>";
    }
}
