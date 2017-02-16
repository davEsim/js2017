
<?
if($_ENV["lang"] == "CZ"){?>
    <div class="row marginTop1">
        <div class="medium-12 columns">
        <h1>Regiony</h1>
        </div>
    </div>
	<div class="row">
		<div class="medium-12 columns">
			
			<div id="map" style="width: 1160px; height: 380px"></div>
			<hr />
		</div>
	</div>
	<div class="row">
		<div class="medium-12 columns">
			<?php
			$regionCities = new xRegionCities($db, "xRegionCities");
			$lang = $_ENV["lang"];
			
			$results = $regionCities->listing("","xRegionCities", "ASC", 0, 0);
			echo "<div class='row listing'>";
			$i=0;
			foreach($results AS $result){
				echo "<div class='medium-3 columns'>\n";
							echo "<h4><a href='./".$result["seo"]."'>".$result["xRegionCities"]."</a></h4>";
							echo "<p>".invertDatumFromDB($result["fromDate"],1)." - ".invertDatumFromDB($result["toDate"],1)."</p>";
							echo "<hr />";
				echo "</div>\n";
				if(!(++$i % 4)) echo "</div>\n<div class='row listing'>";
			}
			echo "</div>";
			?>
		</div>
	</div> 
<?
}else{?>
    <div class="row marginTop1">
        <div class="medium-12 columns">
        <h1>Regions</h1>
        </div>
    </div>
	<div class="row">
		<div class="medium-12 columns">
        <?
        	echo $rActivePage["contentEN"];
		?>
		</div>
	</div> 
<?	
}
?>
