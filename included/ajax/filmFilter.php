<?
session_start();
include_once("../../php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once("../../../../data/private/2017/connection.php");


$lang = $_GET["lang"];

if($lang == "CZ"){
	$filmPath = "./filmy-a-z/";
}else{
	$filmPath = "./films-a-z/";
}


if($_GET["type"]=="alpha") {
    $letter = urldecode($_GET["value"]) . "%";
    $filteredFilms = $db->queryAll("SELECT * FROM xFilms WHERE type LIKE 'film' AND title$lang LIKE ?", array($letter));

}

if(count($filteredFilms)){
	echo "<div class='row films listing'>";
	$i=0;
	foreach($filteredFilms AS $filteredFilm){
			echo "<div class='medium-3 columns end'>\n";
						echo "<a href='$filmPath".$filteredFilm["id"]."-".string2domainName($filteredFilm["title$lang"])."' title='".$filteredFilm["title$lang"]."'>";
							echo "<img src='".modifyImgPathfromSB($filteredFilm["imageUrl"],2)."' alt='".$filteredFilm["title$lang"]."'>";
							echo "<h2>".$filteredFilm["title$lang"]."</h2>";
						echo "</a>";	
						echo "<p>".showStringPart($filteredFilm["synopsys$lang"]," ",300)."</p>";
			echo "</div>\n";
			if(!(++$i % 4)) echo "</div>\n<div class='row listing'>";
	}
	echo "</div>";
}
?>