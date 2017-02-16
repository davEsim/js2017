<?
include_once("./php/mysql.class.php");
include_once("./php/connection.php"); 
include_once("./php/funcs.php"); 

/*
jen co posílám přes GET z ajax requiestu:

imgid=$(this).attr("data-imgid");
imgaction=$(this).attr("data-imgaction");
imgnewposition=$(this).attr("data-imgnewposition");
table=$(this).attr("data-table");
id=$(this).attr("data-id");
flagtableid=$(this).attr("data-flagtableid");
newimgname
*/

if($_GET["imgaction"]=="changename"){
	MySQL_Query("UPDATE media SET media='".mysql_real_escape_string($_GET["newimgname"])."' WHERE id='".intval($_GET["imgid"])."'");
}

if($_GET["imgaction"]=="delete"){
	MySQL_Query("DELETE FROM media WHERE id='".intval($_GET["imgid"])."'");
	MySQL_Query("DELETE FROM mediaTables WHERE id_media='".intval($_GET["imgid"])."'");
}

if($_GET["imgaction"]=="moveup"){
	$rPrevious=MySQL_Fetch_Array(MYSQL_Query("SELECT id_media, sequence FROM mediaTables WHERE id_flagsTables='".$_GET["flagtableid"]."' AND  idInTable='".intval($_GET["id"])."' AND sequence < '".intval($_GET["imgposition"])."' ORDER BY sequence DESC LIMIT 0,1"));
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($_GET["imgposition"])."' WHERE id_media='".$rPrevious["id_media"]."'");
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($rPrevious["sequence"])."' WHERE id_media='".intval($_GET["imgid"])."'");
}

if($_GET["imgaction"]=="movedown"){
	$rPrevious=MySQL_Fetch_Array(MYSQL_Query("SELECT id_media, sequence FROM mediaTables WHERE id_flagsTables='".$_GET["flagtableid"]."' AND  idInTable='".intval($_GET["id"])."' AND sequence > '".intval($_GET["imgposition"])."' ORDER BY sequence ASC LIMIT 0,1"));
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($_GET["imgposition"])."' WHERE id_media='".$rPrevious["id_media"]."'");
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($rPrevious["sequence"])."' WHERE id_media='".intval($_GET["imgid"])."'");
}

showMedia($_GET["table"], $_GET["id"], $_GET["flagtableid"]);

?>














