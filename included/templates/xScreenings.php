

<div class="row">
	<div class="medium-12 columns">
    	<h1><?=$metaTitle?></h1>
    </div>
</div>
<!--
<div class="row limitedAccessGroup" title="Zobrazit projekce pro osoby s postizenim">
    <div class="medium-12 columns">
        <div class="round tiny button">
            <i class="fi-wheelchair"></i>&nbsp;
            <i class="fi-blind"></i>&nbsp;
            <i class="fi-hearing-aid"></i>&nbsp;
            <i class="fi-universal-access"></i>
        </div>
    </div>
</div>

<div class="row limitedAccessGroupContent">
    <div class="medium-12 columns">
        <h2>Projekce pro divaky s omezenim</h2>
        <table>
            <tr><td><p><i class="fi-calendar smaller"></i> <strong>14.3.</strong> <i class="fi-clock smaller"></i> <strong>15:00 hodin</strong> <i class="fi-marker smaller"></i> <strong>Lucerna - velký sal</strong>: <a href="https://goo.gl/maps/JNHiDRmH1uv" target="_blank">Vodičkova 704/36, 110 00 Praha 1</a></p><h3><a href="#">Ve stínu minulosti</a> / A Haunting History</h3><p>Jižní Súdán vznikl jako samostatný stát v roce 2011, po vleklé občanské válce. Súdánec Anuol se vrací domů po více než dvaceti letech života v Británii, kde vystudoval práva. Své znalosti chce využít k rozvoji právního systému v nové zemi.Zatímco se potýká s úřady i každodenními potížemi při budování své firmy,...</p></td>
                <td><i class="fi-wheelchair tooltips" title="Projekce pro osoby se sníženou hybností, osoby na vozíku, osoby malého vzrůstu"></i><br>
                    <i class="fi-blind" title="Projekce pro osoby nevidomé a slabozraké"></i><br>
                    <i class="fi-hearing-aid tooltips" title="Projekce pro osoby nedoslýchavé"></i>
                <td><img src="http://entries.jedensvet.cz/images/filmimages/image.ashx?I=2&W=640&H=380&ID=0&IMGID=8024"> </td></td>
            </tr>

            <tr><td><p><i class="fi-calendar smaller"></i> <strong>15.3.</strong> <i class="fi-clock smaller"></i> <strong>20:00 hodin</strong> <i class="fi-marker smaller"></i> <strong>Lucerna - velký sal</strong>: <a href="https://goo.gl/maps/JNHiDRmH1uv" target="_blank">Vodičkova 704/36, 110 00 Praha 1</a></p><h3><a href="#">Bábušky z Černobylu</a> / The Babushkas of Chernobyl</h3><p>Po černobylské katastrofě se bezprostřední okolí jaderného reaktoru stalo zemí nikoho. Opuštěné ulice měst i vesnic jsou dnes zarostlé stromy, jejich korunami šumí vítr. Uprostřed této zakázané zóny přesto existuje život. V dřevěných chatrčích tu přebývají bábušky, ženy, které se po nucené evakuaci vrátily ilegálně...</p></td>
                <td><i class="fi-wheelchair tooltips" title="Projekce pro osoby se sníženou hybností, osoby na vozíku, osoby malého vzrůstu"></i><br>
                    <i class="fi-blind" title="Projekce pro osoby nevidomé a slabozraké"></i>
                <td><img src="http://entries.jedensvet.cz/images/filmimages/image.ashx?I=2&W=640&H=380&ID=0&IMGID=8057"> </td></td>
            </tr>
            <tr><td><p><i class="fi-calendar smaller"></i> <strong>16.3.</strong> <i class="fi-clock smaller"></i> <strong>19:00 hodin</strong> <i class="fi-marker smaller"></i> <strong>Lucerna - velký sal</strong>: <a href="https://goo.gl/maps/JNHiDRmH1uv" target="_blank">Vodičkova 704/36, 110 00 Praha 1</a></p><h3><a href="#">Behemoth</a> / Behemoth</h3><p>Behemoth je biblická obluda, nepřemožitelná stvůra země. Po tisících letech se ukazuje, že onou obludou je sám člověk, který se rozhodl znásilnit nitro země, aby získal její bohatství. Netuší, že ničením krajiny to zdaleka nekončí. Obluda totiž nakonec začne zákonitě požírat samu sebe. Mocné filmové podobenství si...</p></td>
                <td>
                    <i class="fi-blind" title="Projekce pro osoby nevidomé a slabozraké"></i><br>
                    <i class="fi-hearing-aid tooltips" title="Projekce pro osoby nedoslýchavé"></i>
                <td><img src="http://entries.jedensvet.cz/images/filmimages/image.ashx?I=2&W=640&H=380&ID=0&IMGID=7977"> </td></td>
            </tr>
        </table>
    </div>
</div>
-->
<div class="row">
    <div class="medium-12 columns">
		<?php
        $screenings = new xScreenings($db, "xScreenings");
        $inflictionScreenings = new xScreenings($db, "xInflictionScreenings");

        $lang = $_ENV["lang"];
		$screeningsDates = $screenings->dates();
		
		$actualDate =  date("Y-m-d");
		$showDate = "2017-03-06";
		foreach($screeningsDates AS $screeningsDate){
			if($screeningsDate["date"] == $actualDate){
				$showDate = $screeningsDate["date"];
			}
		}
		?>
        <ul class="accordionScreenings" data-responsive-accordion-tabs="tabs medium-accordion small-accordion large-tabs"  data-active-collapse="true">
        	<?php
			$i=0;
			foreach($screeningsDates AS $screeningsDate){

				$tab=czechFullDayNameFromDate($screeningsDate["date"])."<br>";
				$tab.=invertDatumFromDB($screeningsDate["date"],1);
			?>
                <li class="accordion-item <?=(!$i++)?'is-active':''?> text-center" data-accordion-item>
                    <a href="#" class="accordion-title"><?=$tab?></a>
                    <div class="accordion-content" data-tab-content>
                            <div class="content <?=($screeningsDate["date"]==$showDate)?"active":"";?>" id="panel<?=$i?>">
                                <h3><?=invertDatumFromDB($screeningsDate["date"],1)?></h3>
                                <table>
                                    <?php
                                    $dayScreenings = $screenings->listingByDay($screeningsDate["date"]);
                                    $actualTheatre="";
                                    foreach($dayScreenings AS $dayScreening){						//	už jednotlivé projekce v jednom tabu
                                    if($dayScreening["theatreTitle$lang"]!=$actualTheatre){
                                    ?>
                                </table><h3><?=$dayScreening["theatreTitle$lang"]?></h3><table>
                                    <?php
                                    }
                                    $actualTheatre=$dayScreening["theatreTitle$lang"];

                                    if($dayScreening["type"] == "Film"){									// zobrazuji klasický film
                                    if($dayScreening["addition$lang"]){							// taky pecka ... v addition jsou debaty, ale taky tam může být zahájení :-)
                                        if(strstr($dayScreening["addition$lang"],"ZAHÁJENÍ") || strstr($dayScreening["addition$lang"],"OPENING")) $opening=TRUE; else $opening=FALSE; // v addition je/není zahájení
                                    }
                                    ?>
                                <tr>
                                <td class="time"><?=substr($dayScreening["time"],0,-3)?></td>
                                <td class="fullFilmTitle">
                                    <? if($opening){ //je to zahájení ?>
                                        <div class="extraScreeningTitle"><?=$dayScreening["addition$lang"]?></div>
                                    <? }?>
                                    <a class="filmDetail" data-filmId="<?=$dayScreening["fid"]?>" data-screenId="<?=$dayScreening["sid"]?>" data-lang="<?=$_ENV["lang"]?>"><?=$dayScreening["title$lang"]?></a> / <?=$dayScreening["TITLE_ORIGINAL"]?>
                                </td>
                                <?
                                }elseif($dayScreening["type"] == "Film Package"){						// film vlastně není film, ale jen název balíčku (hand made by Kalenda :-))
                                ?>
                                    <tr>
                                        <td><?=substr($dayScreening["time"],0,-3)?></td>
                                        <td>
                                            <div class="extraScreeningTitle"><?=$dayScreening["title$lang"]?></div>
                                            <?php
                                            $packageFilms = $screenings->packageFilms($dayScreening["id_xFilms"]);	// film je vlastně balíčkem...čili hledám filmy, které do balíčku patří
                                            if(count($packageFilms)){
                                                ?>
                                                <table class="blockTable">
                                                    <?
                                                    foreach($packageFilms AS $packageFilm){
                                                    ?>
                                                    <tr><td><a href="<?=$screenings->filmDetailLink($packageFilm["id"],$packageFilm["title$lang"], $lang)?>"><?=$packageFilm["title$lang"]?></a></td><tr>
                                                        <?php
                                                        }
                                                        ?>
                                                </table>
                                            <?
                                            }
                                            ?>
                                        </td>
                                        <?
                                        }
                                        // ostatní labels k filmu --------------------------------------------------------------------------------------------------------------------
                                        ?>
                                        <td>
                                            <? if($dayScreening["premiere$lang"] != ""){ //premiery ?>
                                                <span class="label"><?=$dayScreening["premiere$lang"]?></span>
                                            <? }?>
                                        </td>
                                        <td>
                                            <? if(!$opening && $dayScreening["addition$lang"]){ //pokud to není zahájení - zobrazim ... je to debata ?>
                                                <? if($dayScreening["link$lang"]){?>
                                                    <a href="<?=$dayScreening["link$lang"]?>"><span class="label"><?=$dayScreening["addition$lang"]?></span></a>
                                                <? }else{?>
                                                    <span class="label"><?=$dayScreening["addition$lang"]?></span>
                                                <? }?>
                                            <? }?>
                                        </td>
                                        <td>
                                            <?

                                            $dayScreeningGuests = $screenings->debateGuests($dayScreening["sid"]); // nejdřív vytáhnu hosty debaty po projekci
                                            if(count($dayScreeningGuests)){
                                                $guestsString = "";
                                                foreach($dayScreeningGuests AS $dayScreeningGuest){
                                                    $guestsString.="<strong>".$dayScreeningGuest["fName"]." ".$dayScreeningGuest["sName"]."</strong>, ".$dayScreeningGuest["profession$lang"]."<br>";
                                                }
                                                ?>

                                                <span  class="label tooltips" title="<?=$guestsString?>"><?=__("Debata s hosty")?></span>
                                            <?
                                            }

                                            ?>
                                        </td>
                                        <td>
                                            <? if($dayScreening["soldOut"]){ ?>
                                                <span class="alert label"><?=($lang == "CZ")?"Vyprodáno":"Sold Out"?></span>
                                            <? }elseif($dayScreening["ticketCZ"]){?>
                                                <a target="_blank" href="<?=$dayScreening["ticket$lang"]?>"><span class="success label"><?=($lang == "CZ")?"Vstupenky":"Tickets"?></span></a>
                                            <? }

                                            ?>
                                        </td>
                                        <td class="inflictionIconsProgram" nowrap>
                                            <?
                                                $inflictions = $inflictionScreenings->findById($dayScreening["sid"]);
                                                inflictionIcons($inflictions["icons"]);
                                            ?>
                                        </td>
                                    </tr>
                                    <tr class="filmDetailContent" id="s<?=$dayScreening["sid"]?>">
                                        <td colspan="10">
                                            <div class="ajaxContent">
                                            </div>
                                            <p>
                                                <a class='tiny radius button' href='<?=$screenings->filmDetailLink($dayScreening["fid"],$dayScreening["title$lang"], $lang)?>'><?=__("více o filmu")?></a>
                                            </p>
                                        </td>
                                    </tr>
                                    <?
                                    }
                                    ?>
                                </table>
                            </div>
                    </div>
                </li>
            <?php
			}

			?>
        </ul>

		<?
		
		//print_r($dayScreenings);
		
		
		
		/*
        foreach($results AS $result){
			if($result["title$lang"]){
				echo "<div class='medium-3 columns end'>\n";
							echo "<a href='".$films->getPath($result["id"])."' title='".$result["title$lang"]."'>";
								echo "<img src='".$result["imageUrl"]."' alt='".$result["title$lang"]."'>";
								echo "<h2>".$result["title$lang"]."</h2>";
							echo "</a>";	
							echo "<p>".showStringPart($result["synopsys$lang"]," ",300)."</p>";
				echo "</div>\n";
				if(!(++$i % 4)) echo "</div>\n<div class='row listing'>";
			}
        }
        echo "</div>";
		*/
        ?>
	</div>

    <!--<div id="rightCol" class="medium-4 columns">
     	<? include_once("included/partials/cols/newsRightCol.php");?>
    </div>-->
</div>    