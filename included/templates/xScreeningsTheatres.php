<style>
    table


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

        $lang = $_ENV["lang"];
		$screeningsTheatres = $screenings->theatres();
		?>
        <ul class="accordionScreeningsTheatres" data-responsive-accordion-tabs="tabs medium-accordion small-accordion large-tabs"  data-active-collapse="true">
        	<?php
			$i=0;
			foreach($screeningsTheatres AS $screeningsTheatre){

			?>
                <li class="accordion-item <?=(!$i++)?'is-active':''?> text-center" data-accordion-item>
                    <a href="#" class="accordion-title"><?=$screeningsTheatre["theatreTitle$lang"]?></a>
                    <div class="accordion-content" data-tab-content>

                        <div class="content <?=($i==1)?"active":""?>" id="panel<?=$i?>">
                            <h2><?=$screeningsTheatre["theatreTitle$lang"]?>
                                <small><? if($lang == "CZ") echo $screeningsTheatre["address"];else echo $screeningsTheatre["addressEN"];?></small>
                            </h2>
                            <table>
                                <?php
                                $theatreScreenings = $screenings->listingByTheatre($screeningsTheatre["id"]);
                                $actualDate="";
                                foreach($theatreScreenings AS $theatreScreening){								// už jednotlivé projekce v rámci kina
                                if($theatreScreening["date"]!=$actualDate){									// grupování podle data
                                ?>
                            </table><h3><?=invertDatumFromDB($theatreScreening["date"])?></h3><table class="stack">
                                <?
                                }
                                $actualDate=$theatreScreening["date"];
                                // název filmu ---------------------------------------------------------------------------------------------------------------
                            if($theatreScreening["type"] == "Film"){									// zobrazuji klasický film
                                if($theatreScreening["addition$lang"]){							// taky pecka ... v addition jsou debaty, ale taky tam může být zahájení :-)
                                    if(stristr($theatreScreening["addition$lang"],"ZAHÁJENÍ") || stristr($theatreScreening["addition$lang"],"OPENING")) $opening=TRUE; else $opening=FALSE; // v addition je/není zahájení
                                }
                                ?>
                            <tr>
                            <td class="time"><?=substr($theatreScreening["time"],0,-3)?></td>
                            <td class="fullFilmTitle">
                                <? if($opening){ //je to zahájení ?>
                                    <div class="extraScreeningTitle"><?=$theatreScreening["addition$lang"]?></div>
                                <? }?>
                                <a class="filmDetail" data-filmId="<?=$theatreScreening["fid"]?>" data-screenId="<?=$theatreScreening["sid"]?>" data-lang="<?=$_ENV["lang"]?>"><?=$theatreScreening["title$lang"]?></a>
                            </td>
                            <?
                            }elseif($theatreScreening["type"] == "Film Package"){						// film vlastně není film, ale jen název balíčku (hand made by Kalenda :-))
                            ?>
                                <tr>
                                    <td class="time"><?=substr($theatreScreening["time"],0,-3)?></td>
                                    <td>
                                        <div class="extraScreeningTitle"><?=$theatreScreening["title$lang"]?></div>
                                        <?php
                                        $packageFilms = $screenings->packageFilms($theatreScreening["id_xFilms"]);	// film je vlastně balíčkem...čili hledám filmy, které do balíčku patří
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
                                        <? if($theatreScreening["premiere$lang"] != ""){ //premiery ?>
                                            <span class="label"><?=$theatreScreening["premiere$lang"]?></span>
                                        <? }?>
                                    </td>
                                    <td class="">
                                        <? if(!$opening && $theatreScreening["addition$lang"]){ //pokud to není zahájení - zobrazim ... je to debata ?>
                                            <? if($theatreScreening["link$lang"]){?>
                                                <a href="<?=$theatreScreening["link$lang"]?>"><span class="label"><?=$theatreScreening["addition$lang"]?></span></a>
                                            <? }else{?>
                                                <span class="label"><?=$theatreScreening["addition$lang"]?></span>
                                            <? }?>

                                        <? }?>
                                    </td>
                                    <td class="">
                                        <?
                                        $theatreScreeningGuests = $screenings->debateGuests($theatreScreening["id"]); // nejdřív vytáhnu hosty debaty po projekci
                                        if(count($theatreScreeningGuests)){

                                            $guestsString = "";
                                            foreach($theatreScreeningGuests AS $theatreScreeningGuest){
                                                $guestsString.="<strong>".$theatreScreeningGuest["fName"]." ".$theatreScreeningGuest["sName"]."</strong>, ".$theatreScreeningGuest["profession$lang"]."<br>";
                                            }
                                            ?>

                                            <span data-tooltip aria-haspopup="true" data-allow-html="true"    class="has-tip label" data-disable-hover="false" title="<?=$guestsString?>"><?=__("Debata s hosty")?></span>
                                        <?
                                        }

                                        ?>
                                    </td>
                                    <td>
                                        <? if($screenings->dateTimeRunOut($theatreScreening["date"], $theatreScreening["time"])){ ?>
                                        <span class="secondary label"><?=($lang == "CZ")?"Vstupenky":"Tickets"?></span>
                                        <? }elseif($theatreScreening["soldOut"]){ ?>
                                            <span class="alert label"><?=__("Vyprodáno")?></span>
                                        <? }elseif($theatreScreening["ticketCZ"]){?>
                                            <a target="_blank" href="<?=$theatreScreening["ticket$lang"]?>"><span class="success label"><?=($lang == "CZ")?"Vstupenky":"Tickets"?></span></a>
                                        <? }	?>
                                    </td>
                                    <td class="inflictionIconsProgram" nowrap>
                                        <?
                                        $inflictions = $inflictionScreenings->findById($theatreScreening["id"]);
                                        inflictionIcons($inflictions["icons"]);
                                        ?>
                                    </td>
                                </tr>
                                <tr class="filmDetailContent" id="s<?=$theatreScreening["sid"]?>">
                                    <td colspan="10">
                                        <div class="ajaxContent">
                                        </div>
                                        <p>
                                            <a class='tiny radius button' href='<?=$screenings->filmDetailLink($theatreScreening["fid"],$theatreScreening["title$lang"], $lang)?>'><?=__("více o filmu")?></a>

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
			} //foreach
			?>
        </ul>
	</div>
</div>    