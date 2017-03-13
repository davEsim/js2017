<?php
$juries = new xJuries($db, "xJuries");
$juryMembers = new xJuryMembers($db, "xJuryMembers");
$lang = $_ENV["lang"];
?>
<div class="row">
	<div class="medium-12 columns">
	  <h1><?=$metaTitle?></h1>
    </div>
</div>
<?
$i = 0;
$juries = $juries->listing("", "id", "ASC", 0, 0);
foreach($juries AS $jury) {
    ?>
    <div class="row">
        <div class="medium-12 columns">
            <a name="<?=string2domainName($jury["name$lang"])?>"></a>
            <?if($i++) echo "<hr>";?>
            <h2><?=$jury["name$lang"] ?></h2>
            <?=$jury["text$lang"] ?>
        </div>
    </div>
    <div class="row listing">
        <?
        $ii = 0;
        $members = $juryMembers->listing("id_xJuries='".$jury["id"]."'", "sequence", "ASC", 0, 0);
        foreach ($members AS $member) {
            ?>
            <div class="medium-3 columns">
                <? echo getFirstMedia("xJuryMembers", $member["id"], 1, "", "", "img", "", FALSE); ?>
                <h3><?=$member["name$lang"] ?></h3>
                <p class="credits"><?=$member["country$lang"] ?></p>
                <?=$member["descr$lang"] ?>
            </div>
        <?
            if(!(++$ii % 4)) echo "</div>\n<div class='row listing'>";
        }
        ?>
    </div>
<?
}
?>

