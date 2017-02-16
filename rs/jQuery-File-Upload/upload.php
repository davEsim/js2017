<?php
error_reporting(0);
include_once("../php/mysql.class.php");
include_once("../php/connection.php");  
include_once("../php/funcs.php");
include_once("../php/config.php");
$output_dir_docs = "../../download/docs/";
$output_dir_imgs = "../../download/imgs/";
$outputSmall_dir_imgs = $output_dir_imgs."small/";
if(isset($_FILES["insertedMediaFile"]))
{
	if($error =$_FILES["insertedMediaFile"]["error"]){
		echo "Error php: " . $_FILES["file"]["error"] . "<br>";
	}
	$rFlagsTables=MySQL_Fetch_Array(MySQL_Query("SELECT id, imgSmallSize, imgSize FROM flagsTables WHERE tableDbName like '".mysql_real_escape_string($_POST["table"])."'"));
	$maxMediaId=MySQL_Fetch_Array(MySQL_Query("SELECT max(id) AS maxId FROM media"));
	$point=strrpos($_FILES['insertedMediaFile']['name'],".");
	$fileName=substr($_FILES['insertedMediaFile']['name'],0,$point);
	$fileExt=substr($_FILES['insertedMediaFile']['name'],$point+1);
	$fileExt=strtolower($fileExt);
	if($fileExt=="jpeg") $fileExt="jpg";
	if(!$mediaTitle=$_POST["fileTitle"]) $mediaTitle=$fileName;
	$mediaTitleForUrl=++$maxMediaId["maxId"]."_".string2fileName($fileName).".".$fileExt;
	MySQL_Query("INSERT INTO media VALUES (NULL,'".mysql_real_escape_string($mediaTitle)."', '".mysql_real_escape_string($mediaTitleForUrl)."', '".mysql_real_escape_string($fileExt)."')");
	$id_media=mysql_insert_id();
	$rSequence=MySQL_Fetch_Array(MySQL_Query("SELECT max(sequence) AS maxSequence FROM mediaTables WHERE id_flagsTables='$rFlagsTables[id]' AND idInTable=".mysql_real_escape_string($_POST["id"]).""));
	$rSequence[maxSequence]+=1;
	MySQL_Query("INSERT INTO mediaTables VALUES (NULL,'$id_media','$rFlagsTables[id]', '".mysql_real_escape_string($_POST["id"])."','$rSequence[maxSequence]')");
	$fileName = $_FILES["insertedMediaFile"]["name"];
	if($fileExt=="jpg" || $fileExt=="png" || $fileExt=="gif"){
		move_uploaded_file($_FILES["insertedMediaFile"]["tmp_name"],$output_dir_imgs.$mediaTitleForUrl);
		copy($output_dir_imgs.$mediaTitleForUrl,$outputSmall_dir_imgs.$mediaTitleForUrl);
        if($fileExt=="jpg"){
		    resize($output_dir_imgs.$mediaTitleForUrl,$rFlagsTables["imgSize"]);
		    resize($outputSmall_dir_imgs.$mediaTitleForUrl,$rFlagsTables["imgSmallSize"]);
        }
	}else{
		move_uploaded_file($_FILES["insertedMediaFile"]["tmp_name"],$output_dir_docs.$mediaTitleForUrl);
	}
	// ---- níže už jen zobrazení přiřazených dokumentů
	 showMedia($_POST["table"], $_POST["id"], $rFlagsTables["id"]);
 }
 ?>
