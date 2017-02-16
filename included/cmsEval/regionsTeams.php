<?
$regionId = $_ENV["regionId"];
$lang = $_ENV["lang"];
$regionsTeamMembers = new xRegionTeamMembers($db, "xRegionTeamMembers");
$regionTeamMembers = $regionsTeamMembers->listing(" id_xRegionCities = '$regionId'", "sequence", "ASC");
?>
<div class='row listing'>
	<?
    $i=0;
    foreach($regionTeamMembers AS $regionTeamMember){
		?>
        <div class='medium-3 columns end'>
        <?
			echo getFirstMedia("xRegionTeamMembers",$regionTeamMember["id"], 1, "", "", "img", "", FALSE);
			echo $regionTeamMember["name$lang"];
		?>
        </div>
        <?
		if(!(++$i % 4)){
			?>
			</div><div class='row listing'>
            <?
		}
    }
	?>
</div><!--row-->