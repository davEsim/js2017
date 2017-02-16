<?
session_start();
include_once("../../php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once("../../php/connection.php");


$lang = $_GET["lang"];

$film = $db->queryOne("SELECT * FROM xFilms WHERE id=?", array($_GET["filmId"]));
echo "<img src='".$film["imageUrl"]."' />";
echo "<h3>".$film["title$lang"]."<small> / ".$film["TITLE_ORIGINAL"]."</small></h3>";
echo "<p>".$film["synopsys$lang"]."</p>";
?>