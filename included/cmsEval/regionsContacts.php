<?
$lang = $_ENV["lang"];
$regionsCities = new xRegionCities($db, "xRegionCities");
$regionsPersons = new xRegionPersons($db, "xRegionPersons");

$regionsCities = $regionsCities->listing("", "xRegionCities", "ASC" , 0, 0);

$i = 0;
?>
<div class='row listing'>
<?
foreach($regionsCities AS $regionsCity){
    $regionPerson = $regionsPersons->listOne(" id_xRegionCities = '".$regionsCity["id"]."'");
    if($regionPerson["nameCZ"]){
    ?>
            <div class='medium-4 columns end'>
                <div class="callout primary regionContact">
                    <?
                        //echo getFirstMedia("xRegionPersons",$regionPerson["id"], 1, "", "", "img", "small/", FALSE);
                    ?>
                    <h6><a href="./<?=$regionsCity["seo"]?>"><?=$regionsCity["xRegionCities"]?></a></h6>
                    <p><strong><?=$regionPerson["nameCZ"]?></strong><br>
                        <?=$regionPerson["tel"]?><br>
                        <a href="mailto: <?=$regionPerson["mail"]?>">
                        <?
                            if(strlen($regionPerson["mail"]) >= 100){ // má význam lámat jen pokud zobrazuji ve 4 a více sloupcích
                                echo str_replace("@", "<br><span class='fi-at-sign'></span>", $regionPerson["mail"]);
                            }else{
                                echo str_replace("@", "<span class='fi-at-sign'></span>", $regionPerson["mail"]);
                            }

                        ?>
                        </a>
                    </p>

                </div>
            </div>
            <?
            if(!(++$i % 3)){
                ?>
                </div><div class='row listing'>
                <?
            }
    }
}
?>
</div><!--row-->