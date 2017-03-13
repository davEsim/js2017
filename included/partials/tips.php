<?php
$tips = new xTips($db, "xTips");
$films = new xFilms($db, "xFilms");
$tips = $tips->listingGroupAndRand(0, 7);

$lang = $_ENV["lang"];
?>
<div class="orbit primary callout" role="region" aria-label="Tipy z festivalu" data-orbit data-timer-delay="14000">
    <ul class="orbit-container">
        <button class="orbit-previous"><span class="show-for-sr">Předchozí</span>&#9664;&#xFE0E;</button>
        <button class="orbit-next"><span class="show-for-sr">Následující</span>&#9654;&#xFE0E;</button><?
        $i=0;
        foreach($tips AS $tip){
            $fId = substr($tip["filmUrl"],40,5);
            $film = $films->findById($fId);
            $i++;
        ?>
            <li class="orbit-slide">
                    <!--<img src="<?=$film["imageUrl"]?>">-->
                    <p class="label alert"><?=__("Tip festivalu")?></p>
                    <a href="<?=$tip["filmUrl"]?>"><h4><?=$film["title$lang"]?></h4></a>
                    <?=$tip["tip$lang"]?>
                    <p class="credits">
                        <strong><?=$tip["name"]?></strong><br />
                        <?=$tip["position$lang"]?>
                    </p>

           </li>
        <?
        }
        ?>
    </ul>
</div>


