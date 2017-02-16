<style type="text/css">
	#main{
		width:100%;	
	}
	form{
		padding:15px;	
		float:left;
		margin-right:30px;
	}
	h2{
		margin-bottom:.5em;	
	}
	td{
		vertical-align:top;	
	}
	.inTable td{
		background-color:#E2E7EA;	
	}
		td.special {
		background-color:#94a4af;
		color:white;	
		}
			td.special a {
			color:white;	
			}
</style>
<h1>Projekce v regionech</h1>
<?
$basePath="http://jedensvet.cz/2016/rs/index2.php?page=regionsTaxFee";
if(!$_SESSION["xRegionCities"] || $_POST["xRegionCities"]) $_SESSION["xRegionCities"]=$_POST["xRegionCities"];
?>
<form method="post" style="margin-bottom:2em;">
        Region: <? generateSelectFromDBCol("xRegionCities", "id", "xRegionCities", $_SESSION["xRegionCities"], "", ""); ?>  
         <input type="submit" value="odeslat" />          
</form>
<table style="clear:left">
<tr><td>    
<?
if($_SESSION["xRegionCities"]){
		if($_GET["delId"] && !$_POST){
			$delId=$_GET["delId"];
			MySQL_Query("DELETE FROM xRevenues WHERE id='$delId'");
			//echo ("<p>Projekce byla smazána. <a href='$basePath'>Zpět na seznam</a></p>");
		}
		if($_GET["editId"]  && !$_POST){
			$editId=$_GET["editId"];
			$rFormValuesForEdit=MySQL_Fetch_Array(MySQL_Query("SELECT * FROM xRevenues WHERE id='$editId'"));
			$action="update";
			list($year, $rFormValuesForEdit["month"],$rFormValuesForEdit["day"]) =explode("-", $rFormValuesForEdit["datum"]);
			list($rFormValuesForEdit["hh"],$rFormValuesForEdit["mm"]) =explode( ":", $rFormValuesForEdit["time"]);
		}
		if($_POST["submitScreen"] && $_POST["action"]=="update"){
			$datum="2016-".$_POST["month"]."-". $_POST["day"];
			$time=$_POST["hh"].":".$_POST["mm"];
			$editId=$_GET["editId"];
			MySQL_Query("UPDATE xRevenues SET 
														id_xRegionCities='".intval($_SESSION["xRegionCities"])."',
														datum='".$datum."',
														time='".$time."',
														id_xFilms='".intval($_POST["xFilms"])."',
														id_xRegionPlaces='".intval($_POST["xRegionPlaces"])."',
														screenType='".mysql_real_escape_string ($_POST["screenType"])."',
														teachers='".intval($_POST["teachers"])."',
														freeGuests='".intval($_POST["freeGuests"])."',
														freePress='".intval($_POST["freePress"])."',
														freePartners='".intval($_POST["freePartners"])."', 
														freeAccreditations='".intval($_POST["freeAccreditations"])."',
														gm30='".intval($_POST["gm30"])."',
														gm35='".intval($_POST["gm35"])."',
														gm40='".intval($_POST["gm40"])."',
														gm45='".intval($_POST["gm45"])."',
														gm50='".intval($_POST["gm50"])."',
														gm60='".intval($_POST["gm60"])."',
														gm70='".intval($_POST["gm70"])."',
														gm80='".intval($_POST["gm80"])."',
														gm90='".intval($_POST["gm90"])."',
														gm100='".intval($_POST["gm100"])."',
														gm120='".intval($_POST["gm120"])."',
														gm160='".intval($_POST["gm160"])."'
														WHERE id='$editId'
														");
			foreach($_POST["acc"] AS $accId=>$amount){
				MySQL_Query("UPDATE xRegionCityAccreditations SET amount='$amount' WHERE id='$accId'");
			}
		}elseif($_POST["submitScreen"]){
			$datum="2016-".$_POST["month"]."-". $_POST["day"];
			$time=$_POST["hh"].":".$_POST["mm"];
			MySQL_Query("INSERT INTO xRevenues VALUES('',
														'".intval($_SESSION["xRegionCities"])."',
														'".$datum."',
														'".$time."',
														'".intval($_POST["xFilms"])."',
														'".intval($_POST["xRegionPlaces"])."',
														'".mysql_real_escape_string ($_POST["screenType"])."',
														'".intval($_POST["teachers"])."',
														'".intval($_POST["freeGuests"])."',
														'".intval($_POST["freePress"])."',
														'".intval($_POST["freePartners"])."',
														'".intval($_POST["freeAccreditations"])."',
														'".intval($_POST["gm30"])."',
														'".intval($_POST["gm35"])."',
														'".intval($_POST["gm40"])."',
														'".intval($_POST["gm45"])."',
														'".intval($_POST["gm50"])."',
														'".intval($_POST["gm60"])."',
														'".intval($_POST["gm70"])."',
														'".intval($_POST["gm80"])."',
														'".intval($_POST["gm90"])."',
														'".intval($_POST["gm100"])."',
														'".intval($_POST["gm120"])."',
														'".intval($_POST["gm160"])."'
														)");	
			foreach($_POST["acc"] AS $accId=>$amount){
				MySQL_Query("UPDATE xRegionCityAccreditations SET amount='$amount' WHERE id='$accId'");
			}																								
		}
		$qCity=MySQL_Query("SELECT * FROM xRegionCities WHERE id='".intval($_SESSION["xRegionCities"])."'");
		$rCity=MySQL_Fetch_Array($qCity);
		
		?>
		<form method="post"> 
        	<?
				$qCityAcc=MySQL_Query("SELECT * FROM xRegionCityAccreditations WHERE id_xRegionCities='$rCity[id]'");
				while($rCityAcc=MYSQL_Fetch_Array($qCityAcc)){
					echo "Prodaných akreditací celkem v ceně ".$rCityAcc["price"]."Kč <input type='text' name='acc[".$rCityAcc["id"]."]' value='".$rCityAcc["amount"]."'><br>";	
				}
			?>
        
		<h2 style="clear:left">Projekce v regionu <?=$rCity["xRegionCities"]?></h2>
		<table class="inTable">
			<tr></tr>
			<tr>
				<th>Datum</th>
				<td>
					<select name="day">
						<? generateOptionZero(1, 31, $rFormValuesForEdit["day"], 1)?>
					</select>.   
					<select name="month">
						<? generateOptionZero(1, 12, $rFormValuesForEdit["month"], 1)?>
					</select>
				</td>
			</tr>
			<tr>
				<th>Čas</th>
				<td>
					<select name="hh">
						<? generateOptionZero(8, 22, $rFormValuesForEdit["hh"], 1)?>
					</select>.   
					<select name="mm">
						<? generateOptionZero(0, 55, $rFormValuesForEdit["mm"], 5)?>
					</select>
				</td>
			  </tr>
			  <tr>
				<th>Film</th>
				<td>
					<? 	generateSelectFromDBCol("xFilms", "id", "xFilms", $rFormValuesForEdit["id_xFilms"], "", ""); ?>
				</td>
			  </tr>
			  <tr>
				<th>
					Místo
				</th>
				<td>
					<?	selectOnQuery("xRegionPlaces", "SELECT xRegionPlaces AS item, id AS value FROM xRegionPlaces WHERE xRegionPlaces LIKE '".$rCity["xRegionCities"]."%'", $rFormValuesForEdit["id_xRegionPlaces"], "", "");?>
				</td>
			  </tr>
		</table>
		<br />
		<table class="inTable">
			<tr><td>Typ</td><td>	<input type="radio" name="screenType" value="školní" <? if($rFormValuesForEdit["screenType"]=="školní" || !$rFormValuesForEdit["screenType"]) echo "CHECKED"?> /> školní projekce<br />
											<input type="radio" name="screenType" value="veřejná"  <? if($rFormValuesForEdit["screenType"]=="veřejná") echo "CHECKED"?> /> veřejná  projekce
			</td></tr>
		</table>
		<h3>Neplatící diváci</h3>
		<table class="inTable">
			<tr><td>Počet pedagogů</td><td><input type="text" name="teachers" value="<?=$rFormValuesForEdit["teachers"]?>" /></td></tr>
			<tr><td>Počet hostů</td><td><input type="text" name="freeGuests" value="<?=$rFormValuesForEdit["freeGuests"]?>"  /></td></tr>
			<tr><td>Počet novinářů</td><td><input type="text" name="freePress" value="<?=$rFormValuesForEdit["freePress"]?>"  /></td></tr>
			<tr><td>Počet partnerů</td><td><input type="text" name="freePartners"  value="<?=$rFormValuesForEdit["freePartners"]?>" /></td></tr>
			<tr><td><?=$rCity["xRegionCities"]=="Brno"?"Počet - karta diváka":"Počet - akreditace"?></td><td><input type="text" name="freeAccreditations"  value="<?=$rFormValuesForEdit["freeAccreditations"]?>" /></td></tr>
		</table>
		<h3>Platící diváci</h3>
		<table class="inTable">    
			<? 
			$prices=array(30,35,40,45,50,60,70,80,90,100,120,160);
			foreach($prices AS $price){
					echo "<tr><td>Počet diváků za $price Kč</td><td><input type='text' name='gm$price'  value='".$rFormValuesForEdit["gm$price"]."' /></td></tr>";
			}?>
		</table>
		<br />
        <!--<p><input type="checkbox" name="final" value="1" <? if($rFormValuesForEdit["final"]==1) echo "checked" ?> /> Úpravy této projekce jsou již finální a je možné je odeslat k fakturaci.</p>-->
		<input type="submit" value="uložit projekci" />
		<input type="hidden" name="submitScreen" value="1" />
		<? if ($action=="update") { ?><input type="hidden" name="action" value="update" /> <? }?>
		</form>
</td>
<td>		
		<h2><br /><br /><br />Již dříve vložené projekce pro region <?=$rCity["xRegionCities"]?></h2>
		<table class="inTable">
		<?
		$qRegionScreenings=MySQL_Query("SELECT r.*, f.xFilms AS filmTitle, rp.xRegionPlaces AS placeTitle FROM xRevenues AS r LEFT JOIN xFilms AS f ON r.id_xFilms=f.id LEFT JOIN xRegionPlaces AS rp ON r.id_xRegionPlaces=rp.id WHERE id_xRegionCities='".$rCity["id"]."' ORDER BY id_xRegionPlaces ASC");
		while($rRegionScreening=MySQL_Fetch_Array($qRegionScreenings)){
			echo "<tr>
					<td class='special'><a href='$basePath&amp;delId=".$rRegionScreening["id"]."'>smazat</a></td>
					<td class='special'><a href='$basePath&amp;editId=".$rRegionScreening["id"]."'>editovat</a></td>
					<td>".$rRegionScreening["placeTitle"]."</td><td>".invertDatumFromDB($rRegionScreening["datum"])."</td><td>".$rRegionScreening["time"]."</td><td>".$rRegionScreening["filmTitle"]."				</td></tr>";
		}
		?>
		
		</table>
		<?
}
?>
</td>
</tr>
</table>
