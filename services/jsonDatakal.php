<?
ini_set("display_errors",1);
define("YEAR_ID",27); // 27 - 2015

include("../php/classes/dbPdo.class.php");
include("../php/connection.php");

//$stream = fopen("http://entries.jedensvet.cz/images/json_films.aspx?IDE=27", 'r');
$stream = file_get_contents("http://entries.jedensvet.cz/images/json_films.aspx?IDE=27");
$json = json_decode($stream);

print_r($json);

?>
