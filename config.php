<?php
define('DBSERVER', 'localhost');
define('DBUSERNAME', 'root');
define('DBPASSWORD', 'DtB-JC-OfS23');
define('DBNAME', 'belgarumportfolio.users');

$db = mysqli_connect(DBSERVER, DBUSERNAME, DBPASSWORD, DBNAME);

if($db === false){
    die("Errot: connection error. " . mysqli_connect_error());
}