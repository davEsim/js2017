<?
$regionId = $_ENV["regionId"];
$lang = $_ENV["lang"];
$regionCities = new xRegionCities($db, "xRegionCities");
$regionCity = $regionCities->findById($regionId);

$regionPersons = new xRegionPersons($db, "xRegionPersons");
$images = new Images($db, "media");
$logos = $images->getAllForItem("xRegionCities",$regionId);

if($regionCity["FBlink"]){?><a target="_blank" title="Facebook <?=$regionCity["xRegionCities"]?>" href="<?=$regionCity["FBlink"]?>"><img src="<?=$_ENV["serverPath"]?>imgs/logo-fb.png" alt="Facebook <?=$regionCity["xRegionCities"]?>" /></a><? }?>
<? if($regionCity["TWlink"]){?><a target="_blank" title="Twitter <?=$regionCity["xRegionCities"]?>" href="<?=$regionCity["TWlink"]?>"><img src="<?=$_ENV["serverPath"]?>imgs/logo-tw.png" alt="Twitter <?=$regionCity["xRegionCities"]?>" /></a><? }?>
<?
if($regionCity["TWlink"] || $regionCity["FBlink"]){?>
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



