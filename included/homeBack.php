<div class="row">
	<div class="medium-9 columns">
        <ul class="orbit" data-orbit data-options="animation:slide;pause_on_hover:false;animation_speed:500;navigation_arrows:true;bullets:true;slide_number:false">
        	<?
				$news = new xNews($db, "xNews");
				$results = $news->listing(" id_xRegionCities = 0 AND carousel LIKE 'ano'","datum", "DESC", 0, 0);
				foreach($results AS $result){
					if($result["title$lang"]){
						echo "<li>";
							echo getFirstMedia("xNews", $result["id"], 0, "", "", "img", "");
							echo "<div class='orbit-caption'>";
								echo "<h2><a href='".$news->getPath($result["id"]).string2domainName($result["title$lang"])."'>".$result["title$lang"]."</a></h2>";
							echo "</div>";
						echo "</li>";
					} 
				}
			?>
        </ul>
	</div>
    <div class="medium-3 columns buttons">
		<?
            $buttons = new xButtons($db, "xButtons");
            $results = $buttons->listing("active LIKE 'ano' AND lang LIKE '".$_ENV["lang"]."'","sequence", "ASC", 0, 2);
            $i=1;
            foreach($results AS $result){
                echo "<a class='bt".$i."' href='".$result["url"]."' target='_blank'>";
                        echo "<h3>".$result["title"]."</h3>";
	                    if($result["subTitle"]) echo "<p>".$result["subTitle"]."</p>";					
                echo "</a>";
                $i++;
            }
        ?>
			<? if($_ENV["lang"] == "CZ"){?><a class='bt3' href='http://www.zoot.cz/kolekce/7211/dobro-jeden-svet-2016/18354/dobro-51' target='_blank'><img src="../imgs/zoot.png" /></a><? }?>
	</div>        
</div><!--row-->  

<? if($_ENV["lang"] == "CZ"){?>
<div class="row">	
	<div class="medium-12 medium-centered text-center columns">
    	<div class="panel">
    		<h2 class="fi-checkbox"></h2>
    		<h5><a href="./jak-se-vam-libil-jeden-svet">Jak se vám líbil Jeden svět v Praze?</a></h5>
        	<p>Budeme rádi za váš názor.</p>
        </div>    
    </div>
</div>

<!--<div class="row">
	<div class="medium-12 columns">
    	<hr />
    </div>
</div>-->
<div class="row">
  <div class="medium-4 columns">
      <p><strong>Jeden svět na Aktuálně.cz</strong></p>
      <? include_once("included/partials/xmlAktualne.php"); ?>
  </div>    
  <div class="medium-4 columns socialFeeds">
      <p><strong>Tip festivalu</strong></p>
      <? include_once("included/partials/tips.php"); ?>
  </div>
  <div class="medium-4 columns">
      <div class="fb-page" data-href="https://www.facebook.com/jedensvet" data-small-header="true" data-adapt-container-width="true" data-hide-cover="false" data-show-facepile="true" data-show-posts="true">
          <div class="fb-xfbml-parse-ignore">
              <blockquote cite="https://www.facebook.com/jedensvet"><a href="https://www.facebook.com/jedensvet">Jeden svět / One World</a></blockquote>
          </div>
      </div>
  </div>    
</div>
<? }?>
<div class="row">
	<div class="medium-12 columns">
    	<hr />
    </div>
</div>
<div class="row">
	<div class="medium-6 columns">
    	<p><strong><?=__("Fotogalerie")?></strong></p>
    	<? include_once("included/partials/homeGalleries.php"); ?>
    </div>
    <div class="medium-6 columns">
    	<p><strong>Instagram</strong></p>
    	<!-- SnapWidget -->
<script src="http://snapwidget.com/js/snapwidget.js"></script>
<iframe src="http://snapwidget.com/in/?u=amVkZW5zdmV0Y3p8aW58MjMwfDJ8MXx8bm98MXxub25lfG9uU3RhcnR8eWVzfHllcw==&ve=040316" title="Instagram Widget" class="snapwidget-widget" allowTransparency="true" frameborder="0" scrolling="no" style="border:none; overflow:hidden; width:100%;"></iframe>    
	</div>
</div>

<div class="row marginTop1">
	<div class="medium-12 columns">
	<div class="panel">
    <div class="row">
	<div class="medium-6 columns ">
    	<h2><?=__("Chci dostávat newsletter")?></h2>
        <form method="post" id="registrationForm" action="./registrace" data-abide>
                        <div class="row">
                            <div class="medium-12 columns">
                                <label>E-mail <small><?=__("povinné")?></small>
                                    <input type="email" name="userLogin" value="" required pattern="email">
                                </label>
                               
                                <input class="nS" type="email" name="email" value="">
                               
                            </div>
                          </div>
                          <div class="row">
                            <div class="medium-12 columns">
                                <label><?=__("Heslo")?>  <small><?=__("povinné")?></small>
                                    <input type="password" name="userPsswd" value="" required pattern="[a-zA-Z]+">
                                </label>
                            </div>
                         </div>
                         <? if ($_ENV["lang"]=="CZ"){	?>
                         <div class="row">
                            <div class="medium-12 columns">
                            		<hr />
                                    <p><strong>Chcete nám poradit jak zlepšit festival?</strong> Můžeme Vám zavolat?</p>
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
                    <input class="nI" type="text" name="text" value="" />
                    <input class="nS" type="submit" name="nSu" value="Uložit" />
                <div class="small-12 columns end"><input class="radius small button ys" type="submit" name="yS" value="<?=__("Odeslat")?>"></div>
          	  </div><!--row -->	
			</form>
            <script>
				$(document).ready(function(){
						$(".call").click(function(){
								if($(this).attr("value") == "ano"){
									$("#registrationFormExtraFields").slideDown();
								}else{
									$("#registrationFormExtraFields").slideUp();
								}
						});
				});
			</script>
	</div>
	<div class="medium-6 columns">
    	<h2>&nbsp;</h2>
					<?
                    if ($_ENV["lang"]=="CZ"){		
						?>
						<p>Buďte mezi prvními, kdo se dozví všechny <strong>důležité novinky</strong>. Párkrát před festivalem vám pošleme <strong>newsletter</strong> o tom, na co se můžete těšit. A využijte taky možnosti sestavit si pohodlně online váš <strong>osobní rozvrh projekcí s webovou aplikací Můj program</strong>. </p>
						<p>Stačí se jednoduše zaregistrovat a máte to v kapse. Využít můžete i svých přihlašovacích údajů z Facebooku.</p>
						<p>Až vyplníte údaje, mrkněte na svůj e-mail, kam vám dorazí potvrzovací zpráva. A je to.</p>
						<?
                    }else{
						?>
						<p>Subscribe to our festival <strong>newsletter</strong> with interesting tips and be the first to learn <strong>important news</strong> before the festival starts! </p>
						<p>Remember – if you register on our website, you can also create <strong>your own festival programme with My Programme web application</strong>.</p>
						<p>Simply enter your (Facebook login) details, check your mailbox and click on the confirmation link in the email. Registration has never been easier – so register straight away!</p>
						<?
                    }
                    ?>
    </div>
    </div>
    </div>
    </div>
</div><!--row--> 
