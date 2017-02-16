<?
ini_set('display_errors',0);
ini_set('display_startup_errors',1);
error_reporting(-1); // ukaze opravdu vse
include_once("../classes/dbPdo.class.php");
include_once("../../../../data/private/dev/connection.php");

$dom = new DOMDocument("1.0");
$node = $dom->createElement("markers");
$parnode = $dom->appendChild($node);

$markers = $db->queryAll("SELECT * FROM xRegionPlaces");

header("Content-type: text/xml");

foreach($markers AS $marker){
	
	list($lat, $lng)=explode(",",trim($marker["googleMapPosition"], "()"));	
	// ADD TO XML DOCUMENT NODE
	$node = $dom->createElement("marker");
	$newnode = $parnode->appendChild($node);
	$newnode->setAttribute("name",$marker['xRegionPlaces']);
	$newnode->setAttribute("address", $marker['address']);
	$newnode->setAttribute("lat", $lat);
	$newnode->setAttribute("lng", $lng);
	$newnode->setAttribute("type", "cinema");
}

echo $dom->saveXML();

?>