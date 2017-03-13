
<div class="row">
    <div class="medium-12 columns">
        <h1>Jeden svět pro všechny <button type="button" data-toggle="ETR" id="etrButton" title="ETR text - Jeden svět pro všechny"><img alt="ETR text - Jeden svět pro všechny" src="imgs/icons/inflictions/ctenar.svg"></button> <small style="font-size: .5em"><a id="fullNoETRtext" href="<?=$_SERVER["PHP-SELF"]?>">zobrazit plný text</a></small></h1>
    </div>
</div>
<div id="noETRContent">
<div id="inflictionsPage">
    <div class="row">
        <div class="medium-6 columns">
            <p>Věříme, že právo na kulturu a kulturní život patří mezi základní lidská práva. Proto se festival Jeden svět od letošního roku zaměřuje na zpřístupnění vybrané části programu divákům a divačkám s různými druhy znevýhodnění. Chceme Jeden svět otevřít všem, bez ohledu na věk, pohlaví, mateřský jazyk nebo kvalitu zraku.</p>

            <p>Níže klikněte na piktogram, který se vás týká, a zobrazí se vám nabídka filmů a dalších akcí právě pro vás.
            Dále na této stránce najdete detailní popis přístupnosti festivalových kin a dalších prostor, kde festival probíhá.</p>

            <p>Na celém webu mimo tuto speciální stránku vám orientaci usnadní piktogramy.</p>


        </div>
        <div class="medium-6 columns">
            <video class="" style="max-width: 580px; max-height: 320px" controls preload>
                <source src="<?=$_ENV["serverPath"]?>video/ow-for-all.mp4" />
            </video>
        </div>
    </div>
    <?
        $inflictions = new xInflictions($db, "xInflictions");
        $inflictions = $inflictions->listing("", "sequence", "ASC", 0, 0);
    ?>
    <div class="row">
        <div class="medium-12 columns">
            <ul class="accordion marginTop1" data-responsive-accordion-tabs="tabs medium-accordion small-accordion large-tabs" data-active-collapse="true">
                <?
                    $i = 0;
                    foreach($inflictions AS $infliction){
                        ?>
                        <li class="accordion-item <? //=(!$i++)?'is-active':''?> text-center" data-accordion-item>
                            <a href="#" class="accordion-title">
                                <img src="imgs/icons/inflictions/<?=$infliction["icon"]?>.svg">
                                <?=(++$i == 3)?"<img src='imgs/icons/inflictions/ruce.svg'>":"";?>
                                <h5><?=$infliction["title"]?></h5>
                            </a>
                            <div class="accordion-content" data-tab-content>
                                <div class="row">
                                    <div class="medium-12 columns">
                                        <h2><?=$infliction["title"]?></h2>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="medium-7 columns">

                                        <?
                                            if($i == 3){
                                                ?>
                                                <video class="" style="max-width: 580px; max-height: 320px" controls preload>
                                                    <source src="<?=$_ENV["serverPath"]?>video/JS_WEB_5_divacineslysici.mp4" />
                                                </video>
                                                <?
                                            }
                                            echo $infliction["text"];
                                            $screenings = new xScreenings($db, "xScreenings");
                                            if($i == 2) $infl = "oko";
                                            if($i == 3) $infl = "ucho";
                                            if($i == 4) $infl = "masky";
                                            if($i == 5) $infl = "starik";
                                            $inflictionScreenings = $screenings->inflictions($infl);
                                            if($i>1 && $i <= 5){
                                                ?>
                                                <h4>Projekce pro vás</h4>
                                                <table>
                                                    <?
                                                    foreach ($inflictionScreenings AS $inflictionScreening) {
                                                        ?>
                                                        <tr>
                                                            <td nowrap><?= invertDatumFromDB($inflictionScreening["date"], 1) ?>&nbsp;<?= substr($inflictionScreening["time"], 0, 5) ?></td>
                                                            <td><?= $inflictionScreening["title$lang"] ?></td>
                                                            <td><?= $inflictionScreening["theatreTitle$lang"] ?></td>
                                                            <td><?= $inflictionScreening["address"] ?></td>
                                                        </tr>
                                                    <?
                                                    }
                                            }
                                        ?>
                                            </table>

                                    </div>
                                    <div class="medium-5 columns">
                                        <h4 class="marginTop0">Filmy pro vás</h4>
                                        <?
                                         if($i==1){
                                         ?>
                                             <a href="program-po-dnech" class="medium button">Program po dnech</a><br>
                                             <a href="program-kin" class="medium button">Program kin</a>
                                         <?
                                         }else {
                                             $films = new xInflictionFilms($db, "xInflictionFilms");
                                             if($i == 2) $films = $films->listing("id = 1 OR id = 5");
                                             if($i == 3) $films = $films->listing("id <= 5");
                                             if($i == 4) $films = $films->listing("id = 1 OR id = 5");
                                             if($i == 5) $films = $films->listing("id = 1 OR id = 3 OR id > 5" , "id", "DESC", 0, 0);
                                             foreach($films AS $film){ ?>
                                                 <div class="card">

                                                     <a data-open="inflictionFilmModal_<?=$i."-".$film["id"]?>">
                                                         <? echo getFirstMedia("xInflictionFilms",$film["id"], 0, "fancybox", "", "img", "", FALSE);?>
                                                         <h5><?=$film["xInflictionFilms"]?></h5>
                                                     </a>
                                                         <p>&nbsp;</p>

                                                 </div>
                                                 <div class="reveal" id="inflictionFilmModal_<?=$i."-".$film["id"]?>" data-reveal>
                                                     <button class="close-button" data-close aria-label="Zavřít okno" type="button">
                                                         <span aria-hidden="true">&times;</span>
                                                     </button>
                                                     <? if($i == 3){?>
                                                         <video class="" style="max-width: 580px; max-height: 320px" controls preload>
                                                             <source src="<?=$_ENV["serverPath"]?>video/films/<?=$film["id"]?>.mp4" />
                                                         </video>
                                                         <?
                                                        }else{
                                                            echo getFirstMedia("xInflictionFilms",$film["id"], 0, "fancybox", "", "img", "", FALSE);
                                                        }?>
                                                     <h1><?=$film["xInflictionFilms"]?></h1>
                                                     <?=$film["text"]?>
                                                     <div class="text-center"><a class="button"  class="close-button" data-close><span aria-hidden="true">&times;</span> zavřít okno</a></div>
                                                 </div>
                                                 <? }
                                         }
                                        ?>
                                    </div>
                                </div>
                            </div>
                        </li>
                    <?
                    }
                ?>

            </ul>
        </div>
    </div>
    <div class="row inflictionTheatres marginTop2">
        <div class="medium-12 columns">
            <h2>Festivalová kina</h2>
            <p>Zde po rozkliknuti najdete detailní informace o přístupnosti jednotlivých kin.</p>
            <?
            $inflictionTheatres = new xInflictionTheatres($db, "xInflictionTheatres");
            $inflictionTheatres = $inflictionTheatres->listing("", "sequence", "ASC", 0, 0);
            ?>
            <div class="row">
                <div class="medium-12 columns">
                    <ul class="accordion2" data-responsive-accordion-tabs="tabs medium-accordion small-accordion large-tabs"  data-active-collapse="true">
                        <?
                        $i = 0;
                        foreach($inflictionTheatres AS $inflictionTheatre){
                            ?>
                            <li class="accordion-item <? //=(!$i++)?'is-active':''?> text-center" data-accordion-item>
                                <a href="#" class="accordion-title">

                                    <h5><?=$inflictionTheatre["title"]?></h5>
                                </a>
                                <div class="accordion-content" data-tab-content>
                                    <div class="row">
                                        <div class="medium-12 columns">
                                            <h3><?=$inflictionTheatre["title"]?>, <small style="color:#555555"><?=$inflictionTheatre["address"]?></small></h3>
                                            <div class="icons">
                                                <?
                                                 inflictionIcons($inflictionTheatre["icons"]);
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row marginTop2">
                                        <div class="medium-6 columns">

                                            <div class="responsive-embed widescreen map" style="max-height: 150px !important;">
                                                <?=$inflictionTheatre["map"]?>
                                            </div>
                                        </div>
                                        <div class="medium-6 columns">
                                            <div class="responsive-embed widescreen map" style="max-height: 150px !important;">
                                                <?=$inflictionTheatre["mapStreet"]?>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row" data-equalizer data-equalize-on="large">
                                        <div class="medium-4 columns">
                                            <div class="callout primary" data-equalizer-watch>
                                                <h4>Jak se dostat ke kinu?</h4>
                                                <?=$inflictionTheatre["toTheatre"]?>
                                            </div>
                                        </div>
                                        <div class="medium-4 columns">
                                            <div class="callout primary" data-equalizer-watch>
                                                <h4>Jak se dostat do kina?</h4>
                                                <?=$inflictionTheatre["inTheatre"]?>
                                            </div>
                                        </div>

                                        <div class="medium-4 columns">
                                            <div class="callout primary" data-equalizer-watch>
                                                <h4>Jak je kino vybaveno?</h4>
                                                <?=$inflictionTheatre["equipTheatre"]?>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" data-equalizer>
                                        <div class="medium-4 columns">
                                            <div class="callout primary" data-equalizer-watch>
                                                <h4>Jak získat lístky?</h4>
                                                <?=$inflictionTheatre["tickets"]?>
                                            </div>
                                        </div>
                                        <div class="medium-8 end columns">
                                            <div class="" data-equalizer-watch>
                                                <h4>Orientace v kině</h4>
                                                <?=$inflictionTheatre["orientation"]?>
                                                <? if($inflictionTheatre["id"]<8){?>
                                                <img class="accessMap" src="<?=$_ENV["serverPath"]?>imgs/maps/<?=$inflictionTheatre["id"]?>.png">
                                                <?}?>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </li>
                        <?
                        }
                        ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="row marginTop2">
        <div class="medium-8 columns">
            <h2>Napište nám!</h2>
            <p>Letos se poprvé snažíme festival otevřít všem divákům a divačkám bez rozdílu.
                Budeme vděční, pokud nám sdělíte, co se vám líbilo i co bychom měli příště udělat jinak.<br>
                Napište na: <a href="mailto:mariana.chytilova@jedensvet.cz">mariana.chytilova@jedensvet.cz</a>.
                <br>Děkujeme!
            </p>
        </div>

    </div>
</div><!-- accessHandicap -->
</div> <!-- noETRcontent -->
<div id="ETRcontent">

</div>