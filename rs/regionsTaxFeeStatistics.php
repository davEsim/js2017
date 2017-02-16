<style type="text/css" media="screen">
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
	}
	td.th{
		background-color:#e2e7ea;	
	}
	#regionPlacesWrapper{
		display:none;	
	}
	#final th{
		background-color:#cadfeb;
		padding:2em;	
	}
</style>
<style type="text/css" media="print">
	#final {
		text-align:left;	
	}
</style>
<h1 class="noPrint">Projekce v regionech</h1>
<?
$basePath="http://jedensvet.cz/2016/rs/index2.php?page=regionsTaxFee";
?>
<script type="text/javascript">
	$(document).ready(function(){
	/*	$("#xRegionCities").change(function(){
			value=$(this).val();
			if(value) $("#regionPlacesWrapper").slideDown();	
		});*/
	});
</script>
<form class="noPrint" method="post" style="margin-bottom:2em;">
        Film: <? generateSelectFromDBCol("xFilms", "id", "xFilms", $_POST["xFilms"], "", ""); ?> <br />
        Region: <? generateSelectFromDBCol("xRegionCities", "id", "xRegionCities", $_POST["xRegionCities"], "", ""); ?> <br /> 
       	Místo: <?	 
	   if($_POST["xRegionCities"]){
		    $rCity=MySQL_Fetch_Array(MySQL_Query("SELECT xRegionCities FROM xRegionCities WHERE id='".$_POST["xRegionCities"]."'")); 
	   		selectOnQuery("xRegionPlaces", "SELECT id AS value, xRegionPlaces AS item FROM xRegionPlaces WHERE SUBSTR(xRegionPlaces,1,LOCATE(':',xRegionPlaces)-1) LIKE '".$rCity["xRegionCities"]."'", $_POST["xRegionPlaces"], "", "");
	   }else{
	   		selectOnQuery("xRegionPlaces", "SELECT id AS value, xRegionPlaces AS item FROM xRegionPlaces ORDER BY xRegionPlaces", $_POST["xRegionPlaces"], "","");
	   }
		?>
         <input type="submit" value="odeslat" />          
</form>
<br style="clear:left" /><br />
<?
if($_POST){
	if($_POST["xFilms"]) $where1=" id_xFilms='".$_POST["xFilms"]."'";else $where1="";
	if($_POST["xRegionCities"]) $where2=" id_xRegionCities='".$_POST["xRegionCities"]."'";else $where2="";
	if($where1 && $where2) $where=$where1." AND ".$where2;
	elseif($where1) $where=$where1;
	elseif($where2) $where=$where2;
	else $where="";
	if($where) $where=" WHERE ".$where;
	
	if($_POST["xRegionPlaces"]){
		$rPlace=MySQL_Fetch_Array(MySQL_Query("SELECT * FROM xRegionPlaces WHERE id='".$_POST["xRegionPlaces"]."'"));
		$qPlaceScreens=MySQL_Query("SELECT * FROM xRevenues AS r LEFT JOIN xFilms AS f ON r.id_xFilms=f.id WHERE id_xRegionPlaces='".$_POST["xRegionPlaces"]."'");
		if(MySQL_Num_Rows($qPlaceScreens)){
			$publicPlaceScreens=$schoolPlaceScreens="";
			$schoolPlaceCount=$publicPlaceCount=0;
			$schoolPlaceRevenue=$publicPlaceRevenue=0;
			$publicPlaceNoFeeAllCount=$publicPlaceFeeAllCount=$schoolPlaceNoFeeAllCount=$schoolPlaceFeeAllCount=0;
			while($rPlaceScreens=MySQL_Fetch_Array($qPlaceScreens)){
				if($rPlaceScreens["screenType"]=="veřejná"){
					$publicPlaceCount++;
					$publicPlaceNoFeeCount+=($rPlaceScreens["teachers"]+$rPlaceScreens["freeGuests"]+$rPlaceScreens["freePress"]+$rPlaceScreens["freePartners"]+$rPlaceScreens["freeAccreditations"]);
					$publicPlaceFeeCount+=($rPlaceScreens["gm30"]+$rPlaceScreens["gm35"]+$rPlaceScreens["gm40"]+$rPlaceScreens["gm45"]+$rPlaceScreens["gm50"]+$rPlaceScreens["gm60"]+$rPlaceScreens["gm70"]+$rPlaceScreens["gm80"]+$rPlaceScreens["gm90"]+$rPlaceScreens["gm100"]+$rPlaceScreens["gm120"]+$rPlaceScreens["gm160"]);
					$publicPlaceRevenue+=($rPlaceScreens["gm30"]*30+$rPlaceScreens["gm35"]*35+$rPlaceScreens["gm40"]*40+$rPlaceScreens["gm45"]*45+$rPlaceScreens["gm50"]*50+$rPlaceScreens["gm60"]*60+$rPlaceScreens["gm70"]*70+$rPlaceScreens["gm80"]*80+$rPlaceScreens["gm90"]*90+$rPlaceScreens["gm100"]*100+$rPlaceScreens["gm120"]*120+$rPlaceScreens["gm160"]*160);
					$publicPlaceScreens.="<tr>
											<td>".invertDatumFromDB($rPlaceScreens["datum"])." - ".$rPlaceScreens["xFilms"]."</td>
											<td>$publicPlaceRevenue Kč</td><td>$publicPlaceFeeCount</td><td>$publicPlaceNoFeeCount</td>
											<td>".$rPlaceScreens["teachers"]."</td>
											<td>".$rPlaceScreens["freeGuests"]."</td>
											<td>".$rPlaceScreens["freePress"]."</td>
											<td>".$rPlaceScreens["freePartners"]."</td>
											<td>".$rPlaceScreens["freeAccreditations"]."</td>
											<td>".$rPlaceScreens["gm30"]."</td>
											<td>".$rPlaceScreens["gm35"]."</td>
											<td>".$rPlaceScreens["gm40"]."</td>
											<td>".$rPlaceScreens["gm45"]."</td>
											<td>".$rPlaceScreens["gm50"]."</td>
											<td>".$rPlaceScreens["gm60"]."</td>
											<td>".$rPlaceScreens["gm70"]."</td>
											<td>".$rPlaceScreens["gm80"]."</td>
											<td>".$rPlaceScreens["gm90"]."</td>
											<td>".$rPlaceScreens["gm100"]."</td>
											<td>".$rPlaceScreens["gm120"]."</td>
											<td>".$rPlaceScreens["gm160"]."</td>
										</tr>";
										
				}else{
					$schoolPlaceCount++;
					$schoolPlaceNoFeeCount+=($rPlaceScreens["teachers"]+$rPlaceScreens["freeGuests"]+$rPlaceScreens["freePress"]+$rPlaceScreens["freePartners"]+$rPlaceScreens["freeAccreditations"]);
					$schoolPlaceFeeCount+=($rPlaceScreens["gm30"]+$rPlaceScreens["gm35"]+$rPlaceScreens["gm40"]+$rPlaceScreens["gm45"]+$rPlaceScreens["gm50"]+$rPlaceScreens["gm60"]+$rPlaceScreens["gm70"]+$rPlaceScreens["gm80"]+$rPlaceScreens["gm90"]+$rPlaceScreens["gm100"]+$rPlaceScreens["gm120"]+$rPlaceScreens["gm160"]);
					$schoolPlaceRevenue+=($rPlaceScreens["gm30"]*30+$rPlaceScreens["gm35"]*35+$rPlaceScreens["gm40"]*40+$rPlaceScreens["gm45"]*45+$rPlaceScreens["gm50"]*50+$rPlaceScreens["gm60"]*60+$rPlaceScreens["gm70"]*70+$rPlaceScreens["gm80"]*80+$rPlaceScreens["gm90"]*90+$rPlaceScreens["gm100"]*100+$rPlaceScreens["gm120"]*120+$rPlaceScreens["gm160"]*160);
					$schoolPlaceScreens.="<tr>
											<td>".invertDatumFromDB($rPlaceScreens["datum"])." - ".$rPlaceScreens["xFilms"]."</td>
											<td>$schoolPlaceRevenue Kč</td><td>$schoolPlaceFeeCount</td><td>$schoolPlaceNoFeeCount</td>
											<td>".$rPlaceScreens["teachers"]."</td>
											<td>".$rPlaceScreens["freeGuests"]."</td>
											<td>".$rPlaceScreens["freePress"]."</td>
											<td>".$rPlaceScreens["freePartners"]."</td>
											<td>".$rPlaceScreens["freeAccreditations"]."</td>
											<td>".$rPlaceScreens["gm30"]."</td>
											<td>".$rPlaceScreens["gm35"]."</td>
											<td>".$rPlaceScreens["gm40"]."</td>
											<td>".$rPlaceScreens["gm45"]."</td>
											<td>".$rPlaceScreens["gm50"]."</td>
											<td>".$rPlaceScreens["gm60"]."</td>
											<td>".$rPlaceScreens["gm70"]."</td>
											<td>".$rPlaceScreens["gm80"]."</td>
											<td>".$rPlaceScreens["gm90"]."</td>
											<td>".$rPlaceScreens["gm100"]."</td>
											<td>".$rPlaceScreens["gm120"]."</td>
											<td>".$rPlaceScreens["gm160"]."</td>
										</tr>";
				}
				$publicPlaceFeeAllCount+=$publicPlaceFeeCount;$publicPlaceFeeCount=0;
				$publicPlaceNoFeeAllCount+=$publicPlaceNoFeeCount;$publicPlaceNoFeeCount=0;
				$schoolPlaceFeeAllCount+=$schoolPlaceFeeCount;$schoolPlaceFeeCount=0;
				$schoolPlaceNoFeeAllCount+=$schoolPlaceNoFeeCount;$schoolPlaceNoFeeCount=0;
				
				$publicPlaceAllRevenue+=$publicPlaceRevenue;$publicPlaceRevenue=0;
				$schoolPlaceAllRevenue+=$schoolPlaceRevenue;$schoolPlaceRevenue=0;
			}
			if($publicPlaceCount || $schoolPlaceCount) echo "<h2>Projekce v místě ".$rPlace["xRegionPlaces"]."</h2>";
			if($publicPlaceCount){
				echo "<h3 class='noPrint'>Veřejné projekce - $publicPlaceCount&times;</h3>";
				echo "<table class='noPrint'>";
					echo "<tr><th>Projekce</th><th>Tržba</th><th>Platící</th><th>Neplatící</th><th>Učitelé</th><th>Hosté</th><th>Novináři</th><th>Partneři</th><th>Akreditace</th><th>30Kč</th><th>35Kč</th><th>40Kč</th><th>45Kč</th><th>50Kč</th><th>60Kč</th><th>70Kč</th><th>80Kč</th><th>90Kč</th><th>100Kč</th><th>120Kč</th><th>160Kč</th></tr>";
					echo $publicPlaceScreens;
					echo "<tr><th>Celkem</th><th>$publicPlaceAllRevenue Kč</th><th>$publicPlaceFeeAllCount</th><th>$publicPlaceNoFeeAllCount</th></tr>";
				echo "</table>";	
			}
			if($schoolPlaceCount){
				echo "<h3 class='noPrint'>Školní projekce - $schoolPlaceCount&times;</h3>";
				echo "<table class='noPrint'>";
				echo "<tr><th>Projekce</th><th>Tržba</th><th>Platící</th><th>Neplatící</th><th>Učitelé</th><th>Hosté</th><th>Novináři</th><th>Partneři</th><th>Akreditace</th><th>30Kč</th><th>35Kč</th><th>40Kč</th><th>45Kč</th><th>50Kč</th><th>60Kč</th><th>70Kč</th><th>80Kč</th><th>90Kč</th><th>100Kč</th><th>120Kč</th><th>160Kč</th></tr>";
					echo $schoolPlaceScreens;
					echo "<tr><th>Celkem</th><th>$schoolPlaceAllRevenue Kč</th><th>$schoolPlaceFeeAllCount</th><th>$schoolPlaceNoFeeAllCount</th></tr>";
				echo "</table>";	
			}
			echo "<h2 class='noPrint'>Výtěžek z akreditací</h2>";
			$accs=0;
			$qCityAcc=MySQL_Query("SELECT * FROM xRegionCityAccreditations WHERE id_xRegionCities='".$_POST["xRegionCities"]."'");
			if(MySQL_Num_Rows($qCityAcc)){
				echo "<p class='noPrint'>";
					while($rCityAcc=MYSQL_Fetch_Array($qCityAcc)){
						echo "Akreditace v ceně ".$rCityAcc["price"]."Kč  - ".$rCityAcc["amount"]."&times;<br>";	
						$accs+=$rCityAcc["price"]*$rCityAcc["amount"];
					}
				echo "</p>";
				echo "<p class='noPrint'>Celkem za akreditace: ".$accs." Kč</p>"; 
			}else{
				echo "<p class='noPrint'>Nebyly prodány žádné akreditace</p>";	
			}
			
			echo "<h2 class='noPrint'>Celková tržba místa</h2>";  
			echo "<table class='noPrint'>";
				$placeAllRevenue=$publicPlaceAllRevenue+$schoolPlaceAllRevenue+$accs;
				echo "<tr><th>Hrubá tržba celkem</th><th>".$placeAllRevenue." Kč</th></tr>";
					if($rPlace["revenuePayerDPH"]=="ano"){ // místo je plátcem DPH
						$placeAllRevenueDPH=round($placeAllRevenue*0.1304,2); 
						$placeAllRevenue-=$placeAllRevenueDPH; // částka bez DPH pokud se vůbec počitá
						$dph=" DPH a ";	
					echo "<tr><th>DPH</th><th>".$placeAllRevenueDPH." Kč</th></tr>";
					echo "<tr><th>Hrubá tržba celkem bez DPH</th><th>".$placeAllRevenue." Kč</th></tr>";
				}else{
					echo "<tr><th>Místo není plátcem DPH</th><th>N/A</th>";	
					$dph="";
				}
				
				$revenueFK=round($placeAllRevenue*.9901/100);
				echo "<tr><th>Odečet pro FK</th><th>".$revenueFK." Kč</th></tr>";
				$placeAllRevenueCleared=$placeAllRevenue-$revenueFK; // nejdřiv odečtu FK pak teprve počítám OSA
				echo "<tr><th>Hrubá tržba celkem bez $dph FK</th><th>".$placeAllRevenueCleared."</th></tr>";
				
				echo "<tr><th>Koeficient pro OSA</th><th>".$rPlace["revenueKoefOSA"]."</th></tr>";
				$revenueOSA=round($placeAllRevenueCleared*$rPlace["revenueKoefOSA"]);
				echo "<tr><th>Odečet pro OSA</th><th>".$revenueOSA." Kč</th></tr>";
				$placeAllRevenueCleared-=$revenueOSA;
				echo "<tr><th>Čistá tržba po odečtu $dph FK a OSA</th><th>".$placeAllRevenueCleared." Kč</th></tr>";
				
				$feeOrganizer=$rPlace["revenuePinPart"];
				$feePin=100-$feeOrganizer;
				$finalRevenuesForOrganizer=round($placeAllRevenueCleared*$feeOrganizer/100,2);
				$finalRenevuesForPin=round($placeAllRevenueCleared*$feePin/100,2);
				echo "<tr><th>Pořadatel ($feeOrganizer %)</th><th>".$finalRevenuesForOrganizer." Kč</th></tr>";
				echo "<tr><th>Čvt ($feePin %)</th><th>".$finalRenevuesForPin." Kč</th></tr>";
			echo "</table>"; 
			echo "<table id='final'>";			
			?>
            <tr><th colspan="2">
			<form class="noPrint">
				<input type="button" value="Tisk fakturace" onClick="window.print()" style="display:block;" class="noPrint">
			</form>
            </th></tr>
            <?
			echo "<tr><th colspan='2'>Na základě smlouvy vám fakturujeme dodání kulturní akce Jeden svět</th></tr>";
			echo "<tr><th>Částka ze vstupného</th><th>".$finalRenevuesForPin." Kč</th></tr>";
			
			if($rPlace["revenueWhoFK"]=="čvt"){
				echo "<tr><th>Poplatek FK platí Čvt, proto fakturujeme částku</th><th>".$revenueFK." Kč</th></tr>";
				$finalRenevuesForPin+=$revenueFK;
			}
			if($rPlace["revenueWhoOSA"]=="čvt"){
				echo "<tr><th>Poplatek OSA platí Čvt, proto fakturujeme částku</th><th>".$revenueOSA." Kč</th></tr>";
				$finalRenevuesForPin+=$revenueOSA;
			}
			
			echo "<tr><th>Fakturujeme</th><th>".$finalRenevuesForPin." Kč</th></tr>";
			
			echo "<tr><th>Řádek</th><th style='border:1px solid black;width:200px;'><input size='30' type='text'></th></tr>";
			echo "<tr><th>Projekt</th><th style='border:1px solid black;width:200px;'><input size='30' type='text'></th></tr>";
			echo "<tr><th>Číslo smlouvy</th><th style='border:1px solid black;width:200px;'><input size='30' type='text'></th></tr>";
			echo "</table>";
			
		}
	}
	
	echo "<br><hr>";
	$publicScreens=$schoolScreens=$teachers=$freeGuests=$freePress=$freePartners=$freeAccreditations=$gm30=$gm35=$gm40=$gm45=$gm50=$gm60=$gm70=$gm80=$gm90=$gm100=$gm120=$gm160=0;
	$q=MySQL_Query("SELECT * FROM xRevenues $where");
	$placeScreenings="";
	$q2=MySQL_Query("SELECT count(r.id) AS countC, rp.xRegionPlaces AS place  FROM xRevenues AS r LEFT JOIN xRegionPlaces AS rp ON r.id_xRegionPlaces=rp.id $where GROUP BY xRegionPlaces");
	while($r2=MySQL_Fetch_Array($q2)){
		$placeScreenings.= $r2["countC"]."&times; - ".$r2["place"]."<br>"; 
	}
	while($r=MySQL_Fetch_Array($q)){	
		if($r["screenType"]=="veřejná") $publicScreens++; else $schoolScreens++;
		$teachers+=$r["teachers"];
		$freeGuests+=$r["freeGuests"];
		$freePress+=$r["freePress"];
		$freePartners+=$r["freePartners"];
		$gm30+=$r["gm30"];
		$gm35+=$r["gm35"];
		$gm40+=$r["gm40"];
		$gm45+=$r["gm45"];
		$gm50+=$r["gm50"];
		$gm60+=$r["gm60"];
		$gm70+=$r["gm70"];
		$gm80+=$r["gm80"];
		$gm90+=$r["gm90"];
		$gm100+=$r["gm100"];
		$gm120+=$r["gm120"];
		$gm120+=$r["gm160"];
	}
	echo "<table class='noPrint' style='clear:left; margin-bottom:.8em;'>";
	echo "<tr><th>Celkem projekcí</th><td class='th'>".MySQL_Num_Rows($q)."</td></tr>";
	echo "<tr><th></th><td class='th'>".$placeScreenings."</td></tr>";
	echo "<tr><th>Celkem veřejných projekcí</th><td class='th'>".$publicScreens."</td></tr>";
	echo "<tr><th>Celkem školních projekcí</th><td class='th'>".$schoolScreens."</td></tr>";
	echo "<tr><th>Celkem vstupů zdarma</th><td class='th'>".($teachers+$freeGuests+$freePress+$freePartners+$freeAccreditations)."</td></tr>";
	echo "<tr><th>Celkem vstupů placených</th><td class='th'>".($gm30+$gm35+$gm40+$gm45+$gm50+$gm60+$gm70+$gm80+$gm90+$gm100+$gm120+$gm160)."</td></tr>";
	echo "</table>";
	echo "<table class='noPrint' margin-bottom:.8em;'>";
	echo "<tr><th>Celkem pedagogů (vstup zdarma)</th><td class='th'>".$teachers."</td></tr>";
	echo "<tr><th>Celkem hostů (vstup zdarma)</th><td class='th'>".$freeGuests."</td></tr>";
	echo "<tr><th>Celkem novinářů (vstup zdarma)</th><td class='th'>".$freePress."</td></tr>";
	echo "<tr><th>Celkem partnerů (vstup zdarma)</th><td class='th'>".$freePartners."</td></tr>";
	echo "<tr><th>Celkem diváků na akreditaci (vstup zdarma)</th><td class='th'>".$freeAccreditations."</td></tr>";
	echo "<tr><th>Celkem za cenu 30Kč</th><td class='th'>".$gm30."</td></tr>";
	echo "<tr><th>Celkem za cenu 35Kč</th><td class='th'>".$gm35."</td></tr>";
	echo "<tr><th>Celkem za cenu 40Kč</th><td class='th'>".$gm40."</td></tr>";
	echo "<tr><th>Celkem za cenu 45Kč</th><td class='th'>".$gm45."</td></tr>";
	echo "<tr><th>Celkem za cenu 50Kč</th><td class='th'>".$gm50."</td></tr>";
	echo "<tr><th>Celkem za cenu 60Kč</th><td class='th'>".$gm60."</td></tr>";
	echo "<tr><th>Celkem za cenu 70Kč</th><td class='th'>".$gm70."</td></tr>";
	echo "<tr><th>Celkem za cenu 80Kč</th><td class='th'>".$gm80."</td></tr>";
	echo "<tr><th>Celkem za cenu 90Kč</th><td class='th'>".$gm90."</td></tr>";
	echo "<tr><th>Celkem za cenu 100Kč</th><td class='th'>".$gm100."</td></tr>";
	echo "<tr><th>Celkem za cenu 120Kč</th><td class='th'>".$gm120."</td></tr>";
	echo "<tr><th>Celkem za cenu 160Kč</th><td class='th'>".$gm160."</td></tr>";
	echo "</table><br>"	;

	
}
?>



