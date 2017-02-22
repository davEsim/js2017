<style>
 #fullProgram{
	display:none; 
 }
</style>
<?
$regionId = $_ENV["regionId"];
$regionSeo = $_ENV["regionSeo"];
$regionCity = $_ENV["regionCity"];
$lang = $_ENV["lang"];
$regionEvents= new xRegionEvents($db, "xRegionEvents");
$regionEventsTypes = $regionEvents->types($regionCity);

?>
<div class="row">
	<div class="medium-12 columns regionsList">
    	<?
		foreach($regionEventsTypes AS $regionEventsType){
			echo "<a class='small button filterEventRegion' data-type='type' data-value='".$regionEventsType["id_xRegionEventTypes"]."' data-city='$regionCity'>".$regionEventsType["xRegionEventTypes"]."</a>";
		}
		?>
    </div>
</div>
<!--<div class="row paddingTop1" id="fullProgram">
	<div class="medium-12 columns">
    	<p><a href="<?=$_ENV["host"].$_SERVER['REQUEST_URI']?>">zobrazit všechny akce</a></p>
    </div>
</div>
-->
<div class="row">
	<div class="medium-12 columns">
    	<hr />
    </div>
</div>
<div class='row listing' id="regionEventsFilterAjaxContent">
	<div class="medium-12 columns">
    	<?
			if($itemId){
				$activeEvent = $regionEvents->findById($itemId);
                $activeEventPlace = $regionEvents->getRelRow($activeEvent["id_xRegionPlaces"], "xRegionPlaces");
				?>
				<h2><?=$activeEvent["title"]?></h2>
				<p class="credits">
					<?=showItemDateFromTo($activeEvent["datumFrom"], $activeEvent["datumTo"])?> |
					<? if($activeEvent["time"]) echo " ".$activeEvent["time"]."h. | ";?>
					<?=substr($activeEventPlace["xRegionPlaces"],strpos($activeEventPlace["xRegionPlaces"],":")+1)?>, <?=$activeEventPlace["address"]?>
                    </p>
				<p><?=$activeEvent["text"]?></p>
				<?
			}else{
				$events = $regionEvents->newest($regionCity);
				if(!count($events)){
					echo "<p>Zatím žádné akce.</p>";
				}else{
					echo "<div class='row listing'>";
					$i=0;
					foreach($events AS $event){
						    $eventPlace = $regionEvents->getRelRow($event["id_xRegionPlaces"], "xRegionPlaces");
							echo "<div class='medium-4 columns end'>\n";
										//echo getFirstMedia("xNews", $event["id"], 0, "", "", "img", "");
										echo "<label class='label'>".$event["xRegionEventTypes$lang"]."</label>";
										echo "<h4><a href='".$_ENV["serverPath"].$_ENV["page"]."/".$event["eid"]."-".string2domainName($event["title"])."'>".$event["title"]."</a></h4>";
										echo "<p>".showItemDateFromTo($event["datumFrom"], $event["datumTo"]);
											if($event["time"]) echo " | ".$event["time"]."h.";
										echo "</p>";
										
										echo "<p>".substr($event["xRegionPlaces"],strpos($event["xRegionPlaces"],":")+1)."<br>".$eventPlace["address"]."</p>";
										//echo "<hr />";
							echo "</div>\n";
							if(!(++$i % 3)) echo "<hr /></div>\n<div class='row listing'>";
					}
					echo "</div>";
				}
			}
			?>
	</div>
</div><!--row-->
