<div class="row large-collapse">
	<div class="medium-9 columns">
        <div class="orbit" role="region" aria-label="Novinky / News" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">
            <ul class="orbit-container">
                <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
                <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>        	<?
				$news = new xNews($db, "xNews");
				$results = $news->listing(" id_xRegionCities = 0 AND carousel LIKE 'ano'","datum", "DESC", 0, 0);
                $iOrbit = 0;
                $orbitBullets = "";
				foreach($results AS $result){
					if($result["title$lang"]){
						echo "<li class='orbit-slide ".((!($iOrbit))?"is-active":"")."'>";
							echo getFirstMedia("xNews", $result["id"], 0, "", "orbit-image", "img", "");
								echo "<figcaption class='orbit-caption'><a href='".$news->getPath($result["id"]).string2domainName($result["title$lang"])."'>".$result["title$lang"]."</a></figcaption>";
						echo "</li>";
                        $orbitBullets.= "<button class='".((!($iOrbit))?"is-active":"")."' data-slide='".$iOrbit++."'></button>";
					} 
				}
			?>
            </ul>
            <nav class="orbit-bullets">
                <?=$orbitBullets ?>
            </nav>
	    </div>
    </div>
    <div class="medium-3 columns cards">
		<?
            $buttons = new xButtons($db, "xButtons");
            $results = $buttons->listing("active LIKE 'ano' AND lang LIKE '".$_ENV["lang"]."'","sequence", "ASC", 0, 3);
            $i=1;
            foreach($results AS $result){
                echo "<a class='card-".$i."' href='".$result["url"]."' target='_blank'>";
                        echo "<h3>".$result["title"]."</h3>";
	                    if($result["subTitle"]) echo "<p class='show-for-large'>".$result["subTitle"]."</p>";
                echo "</a>";
                $i++;
            }
        ?>
	</div>        
</div><!--row-->
<!-- ============================= carousel a cards - end ======================================================================= -->

<div id="elementtoScrollToID"></div>
<?
		//include_once("included/cmsEval/regionsScreeningsHome.php");
?>
<div class="row marginTop2 collapse show-for-medium socialFeeds">

    <div class="medium-3 columns">

        <? include_once("included/partials/socialFeedFB.php"); ?>
    </div>
    <div class="medium-3 columns">

        <? include_once("included/partials/socialFeedTwitter.php"); ?>
    </div>
	<div class="medium-3 columns">
        <? if ($_ENV["lang"]=="CZ"){	?>
            <div class="responsive-embed widescreen">
                <video class="" style="max-width: 290px; margin-left: 1em" controls preload>
                    <source src="<?=$_ENV["serverPath"]?>video/JS_WEB_1_homepage.mp4" />
                </video>
            </div>
            <div style="margin:1em; margin-top: 0">
                <h4>Jeden svět pro všechny</h4>
                <p>
                    Právo na kulturní využití patří mezi základní lidská práva. Proto se letos Jeden svět pokouší zbourat alespoň část bariér a otevřít se lidem s různými druhy znevýhodnění.
                    Zveme na festival nevidomé a slabozraké, neslyšící a nedoslýchavé, lidi s mentálním postižením, s omezením hybnosti a seniory. <a href="jeden-svet-pro-vsechny"><strong>Čtěte více</strong></a>
                </p>
            </div>
        <? } ?>
    </div>
    <div class="medium-3 columns">

        <div class="block mobile text-center">
            <h5><i class="fi-mobile-signal"></i> <?=__("Mobilní aplikace")?></h5>
            <h6 >iOS</h6>
            <img class="qr" src="<?=$_ENV["serverPath"]?>imgs/mobile/jeden-svet-iOS.png"><br>
            <img src="<?=$_ENV["serverPath"]?>imgs/icons/appStore.svg">
            <hr>
            <h6>Android</h6>
            <img class="qr" src="<?=$_ENV["serverPath"]?>imgs/mobile/jeden-svet-android.png"><br>
            <img src="<?=$_ENV["serverPath"]?>imgs/icons/googlePlay-v2.png">
        </div>
    </div>
</div>

<!-- ============================= newsletter ======================================================================= -->

<div class="row collapse marginTop1">
    <div class="medium-9 columns" id="registrationForm">
    <h2><?=__("Chci dostávat newsletter")?></h2>
    <div class="row">
	<div class="medium-6 columns ">
        <form method="post"  action="./registrace">
                        <div class="row">
                            <div class="medium-12 columns">
                                <label>E-mail <small><?=__("povinné")?></small>
                                    <input type="email" name="userLogin" value="" required >
                                </label>
                               
                                <input class="nS" type="email" name="email" value="">
                               
                            </div>
                          </div>

                         <? if ($_ENV["lang"]=="CZ"){	?>
                         <div class="row">
                            <div class="medium-12 columns">
                                    <p>Chcete spolu s námi změnit svět k lepšímu? Můžeme Vám zavolat?</p>
                                    <input  name="call" id="callAno" class="call" value="ano" type="radio" required><label for="callAno">Ano</label><br />
                                    <input  name="call" id="callNe" class="call" value="ne" type="radio" required><label for="callNe">Ne, chci pouze newsletter</label>
                                    <div id="registrationFormExtraFields">
                                    	<label>Vaše jméno<input name="userFullName" type="text" /></label>
                                        <label>Váš telefon<input name="userTel" type="text" /></label>
                                        <p>Stisknutím tlačítka Odeslat souhlasíte<br />s <span data-tooltip aria-haspopup="true" class="has-tip" title="Člověk v tísni, o.p.s. zpracovává výše uvedené údaje za účelem zařazení do databáze dárců, péče o dárce, informování o možnostech dárcovství, informování o činnosti této organizace a statistiky, a to až do vyslovení písemného nesouhlasu s tímto zpracováním.">podmínkami zpracování osobních údajů</span>.</p>
                                    </div>
                            </div>
                         </div><!--row -->
                         <? }?>
              <div class="row"> 
                <div class="small-2 columns">&nbsp;</div>
                    <input class="nS" type="submit" name="nSu" value="Uložit" />
                <div class="small-12 columns end"><input class="radius small button ys" type="submit" name="yS" value="<?=__("Odeslat")?>"></div>
          	  </div><!--row -->	
			</form>

	</div>
	<div class="medium-6 columns">

					<?
                    if ($_ENV["lang"]=="CZ"){		
						?>
						<p>Buďte mezi prvními, kdo se dozví všechny <strong>důležité novinky</strong>. Párkrát před festivalem vám pošleme <strong>newsletter</strong> o tom, na co se můžete těšit.</p>
						<p>Až vyplníte údaje, mrkněte na svůj e-mail, kam vám dorazí potvrzovací zpráva. A je to.</p>
						<?
                    }else{
						?>
						<p>Subscribe to our festival <strong>newsletter</strong> with interesting tips and be the first to learn <strong>important news</strong> before the festival starts! </p>
						<p>After registration, please check our confirmation e-mail in your mail box!</p>
						<?
                    }
                    ?>
    </div>
    </div><!--row-->
    </div>
        <div class="medium-3 columns">
        <div class="block text-center" style="background-color: black; color:white">
            <a href="http://www.<?=$_ENV["lang"] == "CZ" ? "jedensvet" : "oneworld"?>.cz/archive2" target="_blank"><img src="<?=$_ENV["serverPath"]?>imgs/JedenSvet_archiv_<?=$_ENV["lang"]?>_neg.png"></a>
            <p class="marginTop1"><?=__("Uplynulé ročníky")?></p>
        </div>
    </div>
</div><!--row--> 
