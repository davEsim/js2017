<?
$regionId = $_ENV["regionId"];
$lang = $_ENV["lang"];
$regionCities = new xRegionCities($db, "xRegionCities");
$regionCity = $regionCities->findById($regionId);

$regionPersons = new xRegionPersons($db, "xRegionPersons");
$images = new Images($db, "media");
$logos = $images->getAllForItem("xRegionCities",$regionId);

 if($regionCity["FBlink"]){?>
    <a class="btn btn-icon btn-facebook" href="<?=$regionCity["FBlink"]?>"><i class="fa fa-facebook"></i><span>Facebook</span></a>
<? }?>
<? if($regionCity["TWlink"]){?>
    <a class="btn btn-icon btn-twitter" href="<?=$regionCity["FBlink"]?>"><i class="fa fa-twitter"></i><span>Twitter</span></a>
<? }?>
<? if($regionCity["IGlink"]){?>
    <a class="btn btn-icon btn-instagram" href="<?=$regionCity["IGlink"]?>"><i class="fa fa-instagram"></i><span>Instagram</span></a>
<? }?>


<?
if($regionCity["TWlink"] || $regionCity["FBlink"] || $regionCity["IGlink"]){?>
	<hr />
<?
}

$regionPerson = $regionPersons->listOne(" id_xRegionCities = '$regionId'");
if($regionPerson["id"] && $regionPerson["descr$lang"]) {
    echo getFirstMedia("xRegionPersons", $regionPerson["id"], 1, "", "", "img", "small/", FALSE);
    ?>
    <h3><?= $regionPerson["name$lang"]; ?></h3>
    <p class="credits"><?= $regionPerson["position$lang"] ?></p>
    <?= $regionPerson["descr$lang"] ?>
    <hr/>
<?
}
foreach($logos AS $logo){
?>
	<div class="regionLogoWrapper"><a href="<?=$logo["media"]?>" target="_blank"><img src="<?=$_ENV["serverPath"]?>download/imgs/small/<?=$logo["seo"]?>" alt="<?=$logo["media"]?>" /></a></div>
<?		
}
?>



