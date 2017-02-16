<?php

// dev

$sql = new tMysql;
$sql->dbName = 'oneworld2017';
$sql->dbServer= 'localhost';
$sql->dbUser= 'oneworld2017';
$sql->dbPassword= 'UDaTGZiQ';
$sql->connect();
MySQL_Query("SET NAMES utf8 COLLATE utf8_czech_ci");


// prod

/*
$sql = new tMysql;
$sql->dbName = 'varianty2';
$sql->dbServer= 'localhost';
$sql->dbUser= 'varianty2';
$sql->dbPassword= 'M8Effaqv';
$sql->connect();
MySQL_Query("SET NAMES utf8 COLLATE utf8_czech_ci");
*/


?>





