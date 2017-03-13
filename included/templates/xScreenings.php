<style>

    .time{
        width:50px;
    }


    .filmDetailContent{
        display:none;
    }
    .filmDetailContent p, .filmDetailContent h3{
        margin-left:50px;
    }
    #screeningList tr.filmDetailContent {
        background-color:#eee;
    }
    .filmDetailContent img{
        float:right;
        margin-left:3em;
        max-width:400px;
    }
    .filmDetailContent p{
        font-size:1em;
    }
    .filmDetailContent .button{
        margin:0 !important;
    }
</style>

<div class="row">
	<div class="medium-12 columns">
    	<h1><?=$metaTitle?></h1>
    </div>
</div>

<div class="row">
    <div class="medium-12 columns">
		<?php
        $screenings = new xScreenings($db, "xScreenings");
        $inflictionScreenings = new xScreenings($db, "xInflictionScreenings");
        $xTheatreCentrum = new xTheatreCentrum($db, "xTheatreCentrum");

        $lang = $_ENV["lang"];
		$screeningsDates = $screenings->dates();
		

		?>
        <ul class="accordionScreenings" data-responsive-accordion-tabs="tabs medium-accordion small-accordion large-tabs"  data-active-collapse="true">
        	<?php
			$i=0;
			foreach($screeningsDates AS $screeningsDate){

				$tab=czechFullDayNameFromDate($screeningsDate["date"])."<br>";
				$tab.=invertDatumFromDB($screeningsDate["date"],1);
			?>
                <li class="accordion-item <?=($screeningsDate["date"] == date("Y-m-d"))?'is-active':''?> text-center" data-accordion-item>
                    <a href="#" class="accordion-title"><?=$tab?></a>
                    <div class="accordion-content" data-tab-content>
                            <div class="content">
                                <h2><?=invertDatumFromDB($screeningsDate["date"],1)?></h2>
                                <table>
                                    <?php
                                    $dayScreenings = $screenings->listingByDay($screeningsDate["date"]);
                                    $actualTheatre="";
                                    foreach($dayScreenings AS $dayScreening){						//	už jednotlivé projekce v jednom tabu
                                    if($dayScreening["theatreTitle$lang"]!=$actualTheatre){
                                    ?>
                                </table><h3><?=$dayScreening["theatreTitle$lang"]?>
                                    <small><? if($lang == "CZ") echo $dayScreening["address"];else echo $dayScreening["addressEN"];?></small>
                                </h3><table class="stack">
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
                                    <a class="filmDetail" data-filmId="<?=$dayScreening["fid"]?>" data-screenId="<?=$dayScreening["sid"]?>" data-lang="<?=$_ENV["lang"]?>"><?=$dayScreening["title$lang"]?></a>
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
                                        <td class="">
                                            <? if($dayScreening["premiere$lang"] != ""){ //premiery ?>
                                                <span class="label"><?=$dayScreening["premiere$lang"]?></span>
                                            <? }?>
                                        </td>
                                        <td class="">
                                            <? if(!$opening && $dayScreening["addition$lang"]){ //pokud to není zahájení - zobrazim ... je to debata ?>
                                                <? if($dayScreening["link$lang"]){?>
                                                    <a href="<?=$dayScreening["link$lang"]?>"><span class="label"><?=$dayScreening["addition$lang"]?></span></a>
                                                <? }else{?>
                                                    <span class="label"><?=$dayScreening["addition$lang"]?></span>
                                                <? }?>
                                            <? }?>
                                        </td>
                                        <td class="">
                                            <?

                                            $dayScreeningGuests = $screenings->debateGuests($dayScreening["sid"]); // nejdřív vytáhnu hosty debaty po projekci
                                            if(count($dayScreeningGuests)){
                                                $guestsString = "";
                                                foreach($dayScreeningGuests AS $dayScreeningGuest){
                                                    $guestsString.="<strong>".$dayScreeningGuest["fName"]." ".$dayScreeningGuest["sName"]."</strong>, ".$dayScreeningGuest["profession$lang"]."<br>";
                                                }
                                                ?>

                                                <span data-tooltip aria-haspopup="true" data-allow-html="true"  class="has-tip label" data-disable-hover="false" title="<?=$guestsString?>"><?=__("Debata s hosty")?></span>
                                            <?
                                            }

                                            ?>
                                        </td>
                                        <td>

                                            <? if($screenings->dateTimeRunOut($dayScreening["date"], $dayScreening["time"])){ ?>
                                                <span class="secondary label"><?=($lang == "CZ")?"Vstupenky":"Tickets"?></span>

                                            <? }elseif($dayScreening["soldOut"]){ ?>
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
                            <?
                            $xTheatreCentrumEvents = $xTheatreCentrum->listingWhereLike("datum", $screeningsDate["date"], "time", "ASC", 0, 0);
                            if($xTheatreCentrumEvents[0]["descr$lang"]) {
                                echo "<h3>".__("Divácké centrum - Galerie Lucerna")." <small>Vodičkova 36, Praha 1</small></h3>";
                                foreach ($xTheatreCentrumEvents AS $xTheatreCentrumEvent) {
                                    if ($xTheatreCentrumEvent["descr$lang"]) echo "<table class='centrumScreening'><tr><td>".$xTheatreCentrumEvent["descr$lang"]."</td></tr></table>";
                                }
                            }
                            ?>
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