<?
session_start();
include_once("../../php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once("../../../../data/private/2017/connection.php");


$lang = $_GET["lang"];

$film = $db->queryOne("SELECT * FROM xBrusselFilms WHERE id=?", array($_GET["filmId"]));
echo "<img src='".$film["imageUrl"]."' />";
echo "<h3>".$film["title$lang"]."<small> / ".$film["TITLE_ORIGINAL"]."</small></h3>";
echo "<p>".$film["synopsys$lang"]."</p>";

$fileMp4="../../download/trailers/mp4/".$film["id_datakal"].".mp4";
?>

<div class="reveal" id="trailerModal<?=$film["id"]?>" data-reveal>
  <h2 id="videoModalTitle"><?=$film["title$lang"]?></h2>
  <div class="flex-video widescreen vimeo">
    <video poster="<?=$film["imageUrl"]?>" controls>
    	<source src="<?=$fileMp4?>" type="video/mp4">
    </video>
  </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>