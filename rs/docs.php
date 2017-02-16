<?
include_once("./php/mysql.class.php");
include_once("./php/connection.php"); 
include_once("./php/funcs.php"); 


/*
jen co posílám přes GET z ajax requiestu:

docid=$(this).attr("data-docid");
docaction=$(this).attr("data-docaction");
docnewposition=$(this).attr("data-docnewposition");
table=$(this).attr("data-table");
id=$(this).attr("data-id");
flagtableid=$(this).attr("data-flagtableid");
newdocname
*/

if($_GET["docaction"]=="changename"){
	MySQL_Query("UPDATE media SET media='".mysql_real_escape_string($_GET["newdocname"])."' WHERE id='".intval($_GET["docid"])."'");
}

if($_GET["docaction"]=="delete"){
	MySQL_Query("DELETE FROM media WHERE id='".intval($_GET["docid"])."'");
	MySQL_Query("DELETE FROM mediaTables WHERE id_media='".intval($_GET["docid"])."'");
}

if($_GET["docaction"]=="moveup"){
	$rPrevious=MySQL_Fetch_Array(MYSQL_Query("SELECT id_media, sequence FROM mediaTables WHERE id_flagsTables='".$_GET["flagtableid"]."' AND  idInTable='".intval($_GET["id"])."' AND sequence < '".intval($_GET["docposition"])."' ORDER BY sequence DESC LIMIT 0,1"));
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($_GET["docposition"])."' WHERE id_media='".$rPrevious["id_media"]."'");
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($rPrevious["sequence"])."' WHERE id_media='".intval($_GET["docid"])."'");
}

if($_GET["docaction"]=="movedown"){
	$rPrevious=MySQL_Fetch_Array(MYSQL_Query("SELECT id_media, sequence FROM mediaTables WHERE id_flagsTables='".$_GET["flagtableid"]."' AND  idInTable='".intval($_GET["id"])."' AND sequence > '".intval($_GET["docposition"])."' ORDER BY sequence ASC LIMIT 0,1"));
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($_GET["docposition"])."' WHERE id_media='".$rPrevious["id_media"]."'");
	MySQL_Query("UPDATE mediaTables SET sequence='".intval($rPrevious["sequence"])."' WHERE id_media='".intval($_GET["docid"])."'");
}

showMedia($_GET["table"], $_GET["id"], $_GET["flagtableid"]);

?>














