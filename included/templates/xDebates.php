<?
$debates = new xDebates($db, "xDebates");
$theatres = new xTheatres($db, "xTheatres");
$lang = $_ENV["lang"];
?>
<div class="row">
	<div class="medium-12 columns">
		<?php
        //---- detail --------------------------------------------------------------------------
        if($itemId){
            $activeItem=$debates->findById($itemId);
			$debateTheatre = $theatres->findById($activeItem["id_xTheatres"]);
			?>
            <div class='row'>
                <div class='medium-8 columns'>
                    <? //=getFirstMedia("xDebates",$activeItem["id"], 1, "", "", "img", "", FALSE);?>
                    <h1><?=$activeItem["title$lang"]?></h1>
					<div class='row'>
               			<div class='medium-12 columns'>
							<h4><?=__("Hosté")?></h4><?=$activeItem["guests$lang"];?>
						</div>
					</div>
					<div class='row'>
							<div class='medium-4 columns text-center'>
								<div class='panel'>
									<i class='fi-clock'></i><p><?=invertDatumFromDB($activeItem["datum"])."<br>".$activeItem["time"];?></p>
								</div>	
							</div>
							<div class='medium-4 columns text-center'>
								<div class='panel'>
									<i class='fi-marker'></i><br>
									<p><strong><?=$debateTheatre["name"]?></strong><br/>
									<?=$debateTheatre["address"]?></p>
								</div>	
							</div>
							<div class='medium-4 columns text-center'>
								<div class='panel'>
									<i class='fi-microphone'></i><br><?=$activeItem["moderators$lang"];?>
								</div>	
							</div>
					</div>
                    <?=$activeItem["text$lang"]?><br/>
                </div>
                <div class='medium-4 columns'>
					<p><?=__("Debata proběhne po filmu")?>:</p>
					<? $debateFilm = $debates->getRelRow($activeItem["id_xFilms"],"xFilms");?>
					<img src='<?=$debateFilm["imageUrl"]?>'>
					<h3><?=$debateFilm["title$lang"]?></h3>
                    <?=$debateFilm["synopsys$lang"];?>
                </div>
           </div>
        
        <!-- ---- seznam ---------------------------------------------------------------------------->
        
            <p class="section">
                <span><?=__("Další debaty");?></span>
            </p>
        <?
        }else{
		?>	
            <h1><?=$metaTitle?></h1>
        <?    	
        }
		$debateType=$routing["filtrParam"];
        $results = $debates->listing("type LIKE '$debateType'","datum", "ASC", 0, 0);
        echo "<div class='row listing'>";
        $i=0;
        foreach($results AS $result){
            echo "<div class='medium-4 columns end'>\n";
                        echo getFirstMedia("xDebates", $result["id"], 0, "", "", "img", "");
                        echo "<h2><a href='".$debates->getPath($result["id"],"",$debateType)."'>".$result["title$lang"]."</a></h2>";
						echo "<p class='credits'>".invertDatumFromDB($result["datum"])." | ".$result["time"]."<br/>";
						echo __("Po filmu")." ".$debates->getRelCol($result["id_xFilms"], "xFilms", "title$lang")."</p>";
                        echo "<p>".showStringPart($result["text$lang"]," ",150)."</p>";
            echo "</div>\n";
            if(!(++$i % 3)) echo "</div>\n<div class='row listing'>";
        }
        echo "</div>";
        ?>
	</div>
    <!--<div id="rightCol" class="medium-4 columns">
     	<? include_once("included/partials/cols/newsRightCol.php");?>
    </div>-->
</div>    