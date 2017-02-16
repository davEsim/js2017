<style>
</style>

<?
$lang = $_ENV["lang"];
$brusselPlaces = new xBrusselPlaces($db, "xBrusselPlaces");

$results = $brusselPlaces->listing("","sequence", "ASC", 0, 0);
echo "<div class='row films listing'>";
$i=0;
foreach($results AS $result){?>
		
		<div class='medium-4 columns end'>
        	<div class="flex-video">
				<?=$result["googleMap"]?>
            </div>
			<h2><a target='_blank' href='<?=$result["url"]?>'><?=$result["xBrusselPlaces"]?></a></h2>
			<p><?=$result["address"]?></p>
                        
		</div>
        <?
		if(!(++$i % 3)) echo "</div>\n<div class='row listing'>";
}
?>
</div>


