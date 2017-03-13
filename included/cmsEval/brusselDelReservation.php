﻿<style>
</style>

<?
$lang = $_ENV["lang"];

if(strlen($itemId) == 32){

	$brusselViewers = new xBrusselViewers($db, "xBrusselViewers");
	$activeBrusselViewer = $brusselViewers->findByUid($itemId);
	$brusselScreenings = new xBrusselScreenings($db, "xBrusselScreenings");
	$activeBrusselScreening = $brusselScreenings->findById($activeBrusselViewer["id_xBrusselScreenings"]);
	$activeBrusselScreeningFilm = $brusselScreenings->getRelRow($activeBrusselScreening["id_xBrusselFilms"], "xBrusselFilms");
	$activeBrusselScreeningPlace = $brusselScreenings->getRelRow($activeBrusselScreening["id_xBrusselPlaces"], "xBrusselPlaces");
	
	
	if($_POST){
		if(strlen($_POST["uid"]) == 32){
			$deletedReservations = $brusselViewers->delReservation($_POST["uid"]);
			if($deletedReservations == 1 || $deletedReservations == 2) { // 2 - registrator muze rezervovat i druhou osobu...mají pak oba stejné uid
				if($lang == "CZ") echo "<p>Zrušení vaší rezervace proběhlo úspěšně.</p>"; else "<p>Reservation was canceled successfully.</p>";
			}else{
				if($lang == "CZ") echo "<p>Zrušení vaší rezervace neproběhlo.<br> Možná již byla zrušena dříve nebo vůbec neexistovala</p>"; else "<p>Reservation was not canceled successfully.<br>Reservation was canceled sometimes earlier or didn't exists.</p>";
			}
		}
		
	}else{
		?>
		<div class="row">
			<div class="medium-12 columns">
				<h3><?=__("Vaše rezervace")?>:</h3>
				<p><strong><?=$activeBrusselScreeningFilm["title$lang"]?></strong></p>
				<p><?=invertDatumFromDB($activeBrusselScreening["date"],1)." | ".$activeBrusselScreening["time"]?></p>
				<p><?=$activeBrusselScreeningPlace["xBrusselPlaces"]?><br /><?=$activeBrusselScreeningPlace["address"]?></p>
				<form method="post">
					<input type="hidden" name="uid" value="<?=$itemId?>" />
					<div id="formSend"  data-value="<?=__("Zrušit rezervaci")?>"></div>
				</form>
			</div>
		</div>
		<?
	}
}

?>


