<?
ini_set('display_errors',1);
ini_set('display_startup_errors',1);
error_reporting(-1);


define("YEAR_ID",31); // 31 - 2017

include("../php/classes/dbPdo.class.php");
include("../../../data/private/2017/connection.php");
include("../php/funcs.php");

$db->query("TRUNCATE TABLE xFilms");
$db->query("TRUNCATE TABLE xScreenings");
$db->query("TRUNCATE TABLE xDebateGuests");
$db->query("TRUNCATE TABLE xPackages");
$db->query("TRUNCATE TABLE xFilms_xFilmThemes");
$db->query("TRUNCATE TABLE xFilmRegions");
//$db->query("TRUNCATE TABLE xFilmThemes"); // taky jenom při prvním exportu, pak zakomentovat
$db->query("TRUNCATE TABLE xFilmParams");
$db->query("TRUNCATE TABLE xFilms_xFilmRegions");
$db->query("TRUNCATE TABLE xGuests");


if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_films+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_FILMS AS $film){
		$id=$film->FILM_ID;
		$id_datakal=$film->DATAKAL_ID;
		$imageUrl="";
		$csfdUrl="";
		$TITLE_CZECH=$film->TITLE_CZECH;
		$TITLE_ORIGINAL=$film->TITLE_ORIGINAL;
		$TITLE_ENGLISH=$film->TITLE_ENGLISH;
		$COUNTRY=$film->COUNTRY;
		$YEAR=$film->YEAR;
		$TIME=$film->TIME;
		$COLOUR=$film->COLOUR;
		$FORMAT=$film->FORMAT;
		$DIRECTOR=$film->DIRECTOR;
		$SYNOPSIS=$film->SYNOPSIS;
		$SYNOPSIS_CZECH=$film->SYNOPSIS_CZECH;
		$package=$film->PACKAGE;
		$packageen=$film->PACKAGEEN;
		$type=$film->FILM_CATEGORY;
		$shorts=$film->SHORTS;
		$CATALOGUE_TYPE=$film->CATALOGUE_TYPE;
		$CATALOGUE_NAME=$film->CATALOGUE_NAME;
		$CATALOGUE_COMPANY=$film->CATALOGUE_COMPANY;
		$CATALOGUE_ADDRESS=$film->CATALOGUE_ADDRESS;
		$CATALOGUE_ZIP=$film->CATALOGUE_ZIP;
		$CATALOGUE_CITY=$film->CATALOGUE_CITY;
		$CATALOGUE_COUNTRY=$film->CATALOGUE_COUNTRY;
		$CATALOGUE_PHONE=$film->CATALOGUE_PHONE;
		$CATALOGUE_EMAIL=$film->CATALOGUE_EMAIL;
		$CATALOGUE_WEBSITE=$film->CATALOGUE_WEBSITE;
		
		$params=array($id, $id_datakal, $imageUrl, $csfdUrl, $TITLE_CZECH, $TITLE_ORIGINAL, $TITLE_ENGLISH, $TITLE_CZECH, $COUNTRY, $YEAR, $TIME, $COLOUR, $FORMAT, $DIRECTOR, $SYNOPSIS, $SYNOPSIS_CZECH, $package, $packageen, $type, $shorts, $CATALOGUE_TYPE,$CATALOGUE_NAME,$CATALOGUE_COMPANY,$CATALOGUE_ADDRESS,$CATALOGUE_ZIP,$CATALOGUE_CITY,$CATALOGUE_COUNTRY,$CATALOGUE_PHONE,$CATALOGUE_EMAIL,$CATALOGUE_WEBSITE);
		//if(strlen($TITLE_CZECH)){

			$db->query("INSERT INTO xFilms VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $params);
		//}
	}
	fclose($stream);
}

if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_images+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_IMAGES AS $image){
		
		$id_xFilms=$image->FILM_ID;
		$url=$image->IMAGE_URL;
			
		$params=array($url, $id_xFilms);
		$db->query("UPDATE xFilms SET imageUrl=? WHERE id=?", $params);
	}
	fclose($stream);
}


/*
  csfd letos - 2017 - nebude


$csfds = $db->queryAll("SELECT * FROM xFilms_csfd");
foreach($csfds AS $csfd){
		$params=array($csfd["link"], $csfd["id_datakal"]);
		$db->query("UPDATE xFilms SET csfdUrl=? WHERE id_datakal=?", $params);
}
*/

if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_screenings+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_SCREENINGS AS $screening){		
		$ID_SCREENING=$screening->SCREENING_ID;
		$ID_FILM=$screening->FILM_ID;
		$THEATRE_ID=$screening->CINEMA_ID;
		$DATE=invertDatumToDB($screening->DATE);
		$TIME=$screening->TIME;
		$additionCZ=$screening->PACKAGE_TITLE;
		$additionEN=$screening->PACKAGE_TITLE_LOCAL;
		$premiereCZ=trim($screening->PREMIERE_CZECH);
		$premiereEN=trim($screening->PREMIERE);
		$soldOut=$screening->SOLD_OUT;
		$linkCZ=$screening->LINK_CZECH;
		$linkEN=$screening->LINK_ENGLISH;
		if($premiereCZ == "Unknown") $premiereCZ = "";
		if($premiereEN == "Unknown") $premiereEN = "";
		$ticketCZ=$screening->TICKET_URL_LOCAL;
		$ticketEN=$screening->TICKET_URL;
		$params=array($ID_SCREENING,$ID_FILM,$THEATRE_ID,$DATE,$TIME,$additionCZ,$additionEN,$premiereCZ,$premiereEN,$soldOut,$linkCZ,$linkEN,$ticketCZ,$ticketEN);
		$db->query("INSERT INTO xScreenings VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $params);		
	}
	fclose($stream);
}

if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_packages+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_PACKAGE AS $package){
		$package_id=$package->FILM_PACKAGE_ID; 	// ID balíčku
		$film_id=$package->SHORT_ID;			// ID filmu
		$sort=$package->SORT;					// pořadí
		$db->query("INSERT INTO xPackages VALUES (?,?,?)", array($package_id,$film_id,$sort));
	}
	fclose($stream);
}

if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_panelists+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_PANELISTS AS $panel){
		$id_xScreenings=$panel->SCREENING_ID;
		$fName=$panel->FIRST_NAME;
		$sName=$panel->LAST_NAME;
		$professionEN=$panel->PROFESSSION;
		$professionCZ=$panel->PROFESSSION_CZECH;
		$imageUrl=$panel->PERSON_PHOTO_URL;
		$db->query("INSERT INTO xDebateGuests VALUES ('',?,?,?,?,?,?)", array($id_xScreenings,$fName,$sName,$professionCZ,$professionEN,$imageUrl));
	}
	fclose($stream);
}

if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_film_section_link+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_SECTIONS AS $section){
		$film_id=$section->FILM_ID;				//	ID - filmu
		$theme_id=$section->ID_FILM_SECTION;	//	ID - sekce/thema
		$db->query("INSERT INTO xFilms_xFilmThemes VALUES (?,?)", array($film_id,$theme_id));
	}
	fclose($stream);	
}

/*
if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_film_sections+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_SECTIONS AS $section){
		$id=$section->ID_FILM_SECTION;			// ID - téma
		$themeEN=$section->FILM_SECTION;		// anglický název téma
		$themeCZ=$section->FILM_SECTION_LOCAL;	// český název téma
		$db->query("INSERT INTO xFilmThemes VALUES (?,?,?,?,?,?)", array($id,$themeCZ,$themeEN,'','',''));
	}
	fclose($stream);	
}
*/


if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_regions&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_REGION AS $region){
		$id=$region->REGION_ID;			
		$titleCZ=$region->REGION_CZECH;		
		$titleEN=$region->REGION;
		$db->query("INSERT INTO xFilmRegions VALUES (?,?,?)", array($id,$titleCZ,$titleEN));
	}
	fclose($stream);	
}

if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_export_film_regions+@IDE=".YEAR_ID."&root=root", 'r')) {
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_REGIONS AS $region){
		$regionId=$region->REGION_ID;			
		$filmId=$region->FILM_ID;		
		$db->query("INSERT INTO xFilms_xFilmRegions VALUES (?,?)", array($filmId,$regionId));
	}
	fclose($stream);	
}


if ($stream = fopen("http://entries.jedensvet.cz/xml?sql=xml_who_is+@IDE=".YEAR_ID."&root=root", 'r')) { 
	$xml = simplexml_load_string(stream_get_contents($stream));
	foreach($xml->XML_WHO_IS_WHERE AS $who){
		$idPerson=$who->ID_PERSON;
		$firstName=$who->FIRST_NAME;
		$lastName=$who->LAST_NAME;
		$company=$who->COMPANY;
		$country=$who->COUNTRY;
		$position=$who->POSITION;
		$profession=$who->PROFESSION;
		$photoUrl=$who->PHOTO;
		$from=$who->WHO_IS_DATE_FROM;
		$to=$who->WHO_IS_DATE_TO;
		$films=$who->FILMS;
		
		$params=array(NULL, $idPerson, $lastName,$firstName,$company,$country,$position,$photoUrl,$profession,$from,$to,$films);
		$db->query("INSERT INTO xGuests VALUES(?,?,?,?,?,?,?,?,?,?,?,?)", $params);
	}
	fclose($stream);	
}

echo "<p>Export o.k.</p>";	
?>
