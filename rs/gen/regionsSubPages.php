<?
include_once("../php/mysql.class.php");
include_once("../php/connection.php");

$qRegionCities=MySQL_Query("SELECT * FROM xRegionCities ORDER BY xRegionCities ASC");
while($rRegionCity=MySQL_Fetch_Array($qRegionCities)){
	$regionSeo=$rRegionCity["seo"];
	$regionMainPage=MySQL_Fetch_Array(MySQL_Query("SELECT id FROM rspages WHERE seoUrlCZ LIKE '$regionSeo'"));
	
	$subPages=array(
					"novinky" => "Novinky",
					"program" => "Program",
					"promitaci-mista-a-vstupne" => "Promítací místa a vstupné",
					"doprovodne-akce" => "Doprovodné akce",
					"skolni-projekce" => "Školní projekce",
					"kontakt-tym" => "Kontakt & tým",
					"fotogalerie" => "Fotogalerie"
					);
	$i=0;
	foreach($subPages AS $subPageSeo => $subPageName){
		$q=MySQL_Query("INSERT INTO rspages VALUES('','$subPageName','$subPageName','$regionSeo-$subPageSeo','','','ano','','','','','ne')");
		$subPageId=mysql_insert_id();
		MySQL_Query("INSERT INTO tree VALUES('$subPageId', '".(++$i)."','$regionMainPage[id]')");
	}
}
?>


