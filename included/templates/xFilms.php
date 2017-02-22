<div class="row">
	<div class="medium-12 columns">
		<?php
        $films = new xFilms($db, "xFilms");
		$screenings = new xScreenings($db, "xScreenings");
        $inflictionScreenings = new xScreenings($db, "xInflictionScreenings");
        $lang = $_ENV["lang"];
        //---- detail --------------------------------------------------------------------------
        if(is_numeric($itemId)){
            $activeItem=$films->findById($itemId);
            ?>
            <div class='row'>
                <div class='medium-8 columns'>
                	<?
						$embded=1; 
						$fileMp4="../../download/trailers/mp4/".$activeItem["id_datakal"].".mp4";
						$fileFlv=$_ENV["serverPath"]."download/trailers/flv/".$activeItem["id_datakal"].".flv";
						$filmsWithoutTrailer=array(31370,31096,31753);
						if(!in_array($activeItem["id"],$filmsWithoutTrailer)){
						//if(filesize($fileMp4)){	
									?>
								<script src="../js/modernizr.video.js"></script>
								<script  type="text/javascript"> 
								if(Modernizr.video) {
								   document.writeln("<div class=\"flex-video\">");
									   document.writeln("<video poster=\"<?=$activeItem["imageUrl"]?>\" controls preload>");
											document.writeln("<source src=\"<?=$fileMp4?>\" type=\"video/mp4\">");
										document.writeln("</video> ");
									document.writeln("</div>");
								}else{
									document.writeln("<div id=\"jwPlayerPlace\" style=\"width:640px; height:360px\">Loading the player ...</div>");
									jwplayer("jwPlayerPlace").setup({
									  flashplayer: "../../extApps/jwPlayer/player.swf",
									  file: "<?=$fileFlv?>",
									  image: "<?=$activeItem["imageUrl"]?>",  
									  width: "640",
									  height: "360"
									});
								}
								</script>    
					<?		
						}else{
                    ?>
                        <img src='<?= $activeItem["imageUrl"] ?>' alt='<?= $activeItem["title$lang"] ?>'>
                            <?
                            $embded = 0;
                        }
                        $v = 0;
                        switch($itemId){
                            case 34722: $v = 5; break;
                            case 34001: $v = 4; break;
                            case 32878: $v = 3; break;
                            case 34026: $v = 2; break;
                            case 34561: $v = 1; break;
                        }
                        if($v){
                            ?>
                                <div class="inflictionIconsFilmsAZVideo"><a data-toggle="inflictionVideo"><img src="../imgs/icons/inflictions/ruce.svg"> </a></div>
                                <div id="inflictionVideo" data-toggler data-animate="slide-in-down slide-out-up" class="flex-video">
                                    <video controls preload>
                                        <source src="../../video/films/<?=$v?>.mp4" type="video/mp4">
                                    </video>
                                </div>
                            <?
                        }
					?>
                </div>
                <div class='medium-4 columns'>
					<h1><?=$activeItem["title$lang"]?></h1>
                    <p class="credits">
                       <strong><?=($lang == "CZ")?$activeItem["titleEN"]:$activeItem["TITLE_ORIGINAL"]?></strong><br>
                       <?=$activeItem["DIRECTOR"]?><br>
                       <?=$activeItem["COUNTRY"]?> |&nbsp;<?=$activeItem["YEAR"]?> |&nbsp;<?=$activeItem["TIME"]?>&nbsp;min.
                    </p>
                    <p class="addthis_sharing_toolbox"></p>
                    <?
					$filmTheme = $films->findItemsInRelations($activeItem["id"],"xFilmThemes");
					$theme = new xFilmThemes($db, "xFilmThemes");
					?>
                    <p><?=__("Kategorie")?>: <a href="<?=$theme->getPath($filmTheme[0]["id"])?>"><?=$filmTheme[0]["name$lang"]?></a></p>
                    <?=$activeItem["synopsys$lang"]?><br/>

                    <?
                    echo $activeItem["id"];
                    $filmParams = $films->getParams($activeItem["id"]);
                    if($filmParams["descr$lang"]){
                        echo $filmParams["descr$lang"];
                    }
                    ?>
                </div>
            </div>

            <div class="row">
                <div class="medium-12 columns">
                	<hr>
                    <h3><?=__("Projekce")?></h3>
                    <?
					$filmScreeningIds = $films->findPackages($activeItem["id"]); // projekce musim vytahat jednak přes Id samotného filmu, tak vlastně ještě přes balíčky
						 $filmScreenings=$films->screeningsWithPackages($filmScreeningIds);
						 if(count($filmScreenings)){
							?>
							<table>
							<?	
							 foreach($filmScreenings AS $filmScreening){
							?>
                                    <tr>
                                        <td><span style="white-space:nowrap"><?=invertDatumFromDB($filmScreening["date"],1)?></span> <?=substr($filmScreening["time"],0,-3)?></td>
                                        <td><?=$filmScreening["theatreTitle$lang"]?></td>
                                        <td><? if(count($screenings->packageFilms($filmScreening["id_xFilms"]))>1){?><span class="label">Blok filmů</span><? }?></td>
                                        <td><? if($filmScreening["premiere$lang"]){?><span class="label"><?=$filmScreening["premiere$lang"]?></span><? }?></td>
                                        <td>
                                        	<? if($filmScreening["soldOut"]){?>
												<span class="alert label"><?=__("Vyprodáno")?></span>
                                            <? }?>	
                                        </td>
                                        <td>
											<? if(!$opening && $filmScreening["addition$lang"]){ //pokud to není zahájení - zobrazim ... je to debata ?>
                                                    <? if($filmScreening["link$lang"]){?>
                                                        <a href="<?=$filmScreening["link$lang"]?>"><span class="label"><?=$filmScreening["addition$lang"]?></span></a>
                                                    <? }else{?>
                                                        <span class="label"><?=$filmScreening["addition$lang"]?></span>
                                                    <? }?>    
                                            <? }?>
                                		</td>
                                        <td>
                                            <?
                                                $dayScreeningGuests = $screenings->debateGuests($filmScreening["id"]); // nejdřív vytáhnu hosty debaty po projekci
                                                if(count($dayScreeningGuests)){
                                                    $guestsString = "";
                                                    foreach($dayScreeningGuests AS $dayScreeningGuest){
                                                        $guestsString.="".$dayScreeningGuest["fName"]." ".$dayScreeningGuest["sName"].", ".$dayScreeningGuest["profession$lang"]."";
                                                    }
                                                    ?>
                                                    
                                                    <span data-tooltip aria-haspopup="true" class="label" title="<?=$guestsString?>"><?=__("Debata s hosty");?></span>
                                                <?
                                                }
                                            ?>
                                        </td>
                                        <td>
											<? if($filmScreening["soldOut"]){ ?>
                                                    <span class="alert label"><?=($lang == "CZ")?"Vyprodáno":"Sold Out"?></span>
                                            <? }elseif($filmScreening["ticketCZ"]){?>
                                                    <a target="_blank" href="<?=$filmScreening["ticket$lang"]?>"><span class="success label"><?=($lang == "CZ")?"Vstupenky":"Tickets"?></span></a>
                                            <? }	?>
                                        </td>
                                        <td class="inflictionIconsProgram" nowrap>
                                            <?
                                            $inflictions = $inflictionScreenings->findById($filmScreening["id"]);
                                            inflictionIcons($inflictions["icons"]);
                                            ?>
                                        </td>
                                    </tr>
						  <?
						  	} //foreach
						 } //if count
					?>
                    </table>

                </div>
              </div>
              <div class="row">
              	<div class="medium-12 columns">
                	<?
                    /*
					$regionScreenings = new xRegionScreenings($db, "xRegionScreenings");
					$filmRegionScreenings = $regionScreenings->listingByFilm($itemId);
					if(count($filmRegionScreenings)){
					?>
                	<h3>Projekce v regionech</h3>
                	<table>
                	<?
					}
						$regionScreenings = new xRegionScreenings($db, "xRegionScreenings");
						$filmRegionScreenings = $regionScreenings->listingByFilm($itemId);
						foreach($filmRegionScreenings AS $filmRegionScreening){?>
                            <tr>
								<td><span style="white-space:nowrap"><?=invertDatumFromDB($filmRegionScreening["date"],1)?></span><br /><?=$filmRegionScreening["time"]?></td>
                                <td><a target="_blank" href="<?=$filmRegionScreening["url"]?>"><?=$filmRegionScreening["xRegionPlaces"]?></a>, <?=$filmRegionScreening["address"]?></td>
                            </tr>
                        <?	
						}
					*/
					?>
                    </table>
                </div>
              </div>
              <div class="row">
                <div class="medium-8 columns">

                </div>
                <div class="medium-4 columns">

                      <h3>Sales</h3>

                        <?=$activeItem["CATALOGUE_NAME"];?><br>
                        <?=$activeItem["CATALOGUE_COMPANY"];?><br>
                        <?=$activeItem["CATALOGUE_ADDRESS"];?><br>
                        <?=$activeItem["CATALOGUE_ZIP"];?>
                        <?=$activeItem["CATALOGUE_CITY"];?><br>
                        <?=$activeItem["CATALOGUE_COUNTRY"];?><br>
                        <?=$activeItem["CATALOGUE_PHONE"];?><br>
                        <?=$activeItem["CATALOGUE_EMAIL"];?><br>
                        <?=$activeItem["CATALOGUE_WEBSITE"];?><br>

                </div>
            </div>
            <!--<div class="row">
                <div class="medium-8 columns">
                	<hr>
                </div>
                <div class="medium-4 columns">
                	<hr>
            </div>-->
            
        <?
        //---- seznam --------------------------------------------------------------------------
        
        ?>
            <p class="section">
                <span><?=__("Další filmy z tematické kategorie")?> <a href="<?=$theme->getPath($filmTheme[0]["id"])?>"><?=$filmTheme[0]["name$lang"]?></a></span>
            </p>
			<?
            $results = $films->listingByTheme($filmTheme[0]["id"],$orderBy="title$lang", "ASC", 0, 0);
            echo "<div class='row films listing'>";
            $i=0;
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

		
        //---- není detail filmu - zobrazuji filtry a seznam --------------------------------------------------------------------------
        }else{
			echo "<div id='elementtoScrollToID'></div>";
            echo "<h1>".$rActivePage["name$lang"]."</h1>";	
        	$results = $films->listing("Type LIKE 'Film'","title$lang", "ASC", 0, 0);
			
			?>
            	<div class="row">
                	<div class="medium-12 columns alphaList">
						<?	
							$range=range('A', 'Z');
							//array_unshift($range, "4");
							//if($lang=="EN")array_unshift($range, "3");
							//array_unshift($range, "1");
							foreach ($range as $letter) {
								$lang=$_ENV["lang"];
								$r=$films->listingWhereLike("title$lang", "$letter%");
								if(count($r)){
								  echo "<a class='button filter' data-value='$letter' data-type='alpha' data-lang='$lang' href='#'>$letter</a>";
								  if($letter=="C" && $lang!="EN") echo "<a class='button filter' data-value='Č' data-type='alpha' data-lang='$lang' href='#'>Č</a>";
								  //if($letter=="H" && $lang!="EN") echo "<a class='label filter' data-value='CH' data-type='alpha' data-lang='$lang' href='#'>CH</a>";
								  if($letter=="R" && $lang!="EN") echo "<a class='button filter' data-value='Ř' data-type='alpha' data-lang='$lang' href='#'>Ř</a>";
								  if($letter=="S" && $lang!="EN") echo "<a class='button filter' data-value='Š' data-type='alpha' data-lang='$lang' href='#'>Š</a>";
								  if($letter=="Z" && $lang!="EN") echo "<a class='button filter' data-value='Ž' data-type='alpha' data-lang='$lang' href='#'>Ž</a>";
								}
							}
						?>
                    </div>

                </div>
                <div class="row"><div class="medium-12 columns"><hr /></div></div>
                <div class="row">
                	<div id="filmFilterAjaxContent" style="min-height:600px" class="medium-12 columns">
                    
                    </div>
                </div>

            <?
		}
        ?>
	</div>
    
</div>
