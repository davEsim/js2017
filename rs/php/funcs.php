<?php 
function escapeValue( $value ){
		if( get_magic_quotes_gpc() )
		{
			  $value = stripslashes( $value );
		}
		//check if this function exists
		if( function_exists( "mysql_real_escape_string" ) )
		{
			  $value = mysql_real_escape_string( $value );
		}
		//for PHP version < 4.3.0 use addslashes
		else
		{
			  $value = addslashes( $value );
		}
		return $value;
} 
//------------------------------------------------------------------------------------------------------------------------------------------
function pageNames(){
	foreach($_ENV["langs"] AS $lang){
		if($_REQUEST["action"]=="update") $mysql=" AND id <>'$id'"; else $mysql="";
		
		if(!$_POST["name_full$lang"]) $_POST["name_full$lang"]=$_POST["name$lang"];
		//if(!$_POST["rspages"]) $_POST["rspages"]=$_POST["name_full$lang"];
		if($_POST["seoUrl$lang"]) $validSeoUrl=string2domainName($_POST["seoUrl$lang"]);
			 else  $validSeoUrl=string2domainName($_POST["name_full$lang"]);
		$qSamePage=MySQL_Query("SELECT id FROM rspages WHERE seoUrl$lang like '$validSeoUrl' $mysql");
		if(@MySQL_Num_Rows($qSamePage)) $message="Stránka s tímto SEO $lang  názvem jíž existuje."; else $_POST["seoUrl$lang"]=$validSeoUrl;
	}
}

//------------------------------------------------------------------------------------------------------------------------------------------
function pageNamesNoLang(){
		if($_REQUEST["action"]=="update") $mysql=" AND id <>'$id'"; else $mysql="";
		
		if(!$_POST["name_full"]) $_POST["name_full"]=$_POST["name"];
		if(!$_POST["rspages"]) $_POST["rspages"]=$_POST["name_full"];
		if($_POST["seoUrl"]) $validSeoUrl=string2domainName($_POST["seoUrl"]);
			 else  $validSeoUrl=string2domainName($_POST["name_full"]);
		$qSamePage=MySQL_Query("SELECT id FROM rspages WHERE seoUrl like '$validSeoUrl' $mysql");
		if(@MySQL_Num_Rows($qSamePage)) $message="Stránka s tímto SEO  názvem jíž existuje."; else $_POST["seoUrl"]=$validSeoUrl;
	}
//------------------------------------------------------------------------------------------------------------------------------------------
function accessesLogs($action,$flagTableId){
	MySQL_Query("INSERT INTO logs VALUES ('','$_SESSION[userId]','$_GET[id]','$flagTableId',now(),'$action')");
	switch($action){
			// update nerešim - práva se nemení
		case "insert":
				  foreach($_ENV["userGroupsArray"] AS $group){	
						  MySQL_Query("INSERT INTO accesses VALUES ('','$_SESSION[userId]', '$group','$_GET[id]','$flagTableId')");
				  }
			  break;
		case "delete":		
			  MySQL_Query("DELETE FROM accesses WHERE id_item='$_GET[id]' AND id_flagsTables='$flagTableId'");
			  MySQL_Query("DELETE FROM logs WHERE id_item='$_GET[id]' AND id_flagsTables='$flagTableId'");
			  break;
	}
}
//------------------------------------------------------------------------------------------------------------------------------------------
function showMedia($table, $idInTable, $idFlagTable){
	//--- zobrazeni imgs	
	//if($table=="rspages") $limit=5; else $limit=1;
	$limit=400;
  $qImgs=MySQL_Query("SELECT i.*, it.sequence FROM media AS i INNER JOIN mediaTables AS it ON i.id=it.id_media INNER JOIN flagsTables as ft ON it.id_flagsTables=ft.id WHERE ft.tableDbName='".mysql_real_escape_string($table)."' AND idInTable='".mysql_real_escape_string($idInTable)."' AND i.ext IN ('jpg','png', 'gif') ORDER BY it.sequence ASC LIMIT 0,$limit");
  $rExtreme=MySQL_Fetch_Array(@MySQL_Query("SELECT max(mt.sequence) AS maxS, min(mt.sequence) AS minS FROM mediaTables AS mt INNER JOIN media AS m on m.id=mt.id_media WHERE m.ext NOT IN ('pdf', 'doc', 'docx') AND id_flagsTables='$idFlagTable' AND idInTable='".mysql_real_escape_string($idInTable)."'"));
  echo "<h3>Přidané soubory</h3>";
  echo "<div class='overflowBigBigList'> ";
		if (!@MySQL_Num_Rows($qImgs)) echo "<br>Zatím žádné soubory...";
		//$rsPath="./index2.php?page=tableItem&table=".$table."&id=".$_GET["id"]."&action=".$_GET["action"]."&form=1";
		while($rImgs=@MySQL_Fetch_Array($qImgs)):
			$path="../download/imgs/small/".$rImgs["seo"];
			$pathBig="../download/imgs/".$rImgs["seo"];
			echo "<div class='imageWrapper'>";
			echo "<img class='preview' src='$path' />&nbsp;<a href='$pathBig' target='_blank'>".stripcslashes($rImgs["media"])."</a>&nbsp;";
			if($rImgs["sequence"]!=$rExtreme["minS"]) echo "&nbsp;<a class='changeOnImg' href='#' title='Posunout o jednu pozici nahoru' data-imgid='".$rImgs["id"]."' data-imgaction='moveup' data-imgposition='".$rImgs["sequence"]."' data-table='$table' data-id='$idInTable' data-flagtableid='$idFlagTable'><img src='layout/up.png'></a>";
			if($rImgs["sequence"]!=$rExtreme["maxS"]) echo "&nbsp;<a class='changeOnImg' href='#' title='Posunout o jednu pozici dolu' data-imgid='".$rImgs["id"]."' data-imgaction='movedown' data-imgposition='".$rImgs["sequence"]."' data-table='$table' data-id='$idInTable' data-flagtableid='$idFlagTable'><img src='layout/down.png'></a>";
			
			//echo "&nbsp;<img class='submitChangeImgName' src='layout/edit.png'>";
			echo "<div class='newImageNameWrapper'><input type='text' placeholder='nový název' id='newImgName_".$rImgs["id"]."'><img class='changeOnImg' data-imgid='".$rImgs["id"]."' data-imgaction='changename' data-table='$table' data-id='$idInTable' data-flagtableid='$idFlagTable' src='layout/1389910709_icon-arrow-left-b.png'></div>";
			
			echo "&nbsp;<a class='changeOnImg del' data-imgid='".$rImgs["id"]."' data-imgaction='delete' data-table='$table' data-id='$idInTable' data-flagtableid='$idFlagTable' title='Smazat fotografii' href='#'>&times; Smazat</a><br/>";
			echo "</div>";
		endwhile;
  echo "</div> <!-- overflowList -->";
	//--- zobrazeni docs
  $qDocs=MySQL_Query("SELECT i.*, it.sequence FROM media AS i INNER JOIN mediaTables AS it ON i.id=it.id_media INNER JOIN flagsTables as ft ON it.id_flagsTables=ft.id WHERE ft.tableDbName='".mysql_real_escape_string($table)."' AND idInTable='".mysql_real_escape_string($idInTable)."' AND i.ext IN ('pdf','doc','docx') ORDER BY i.id DESC LIMIT 0,$limit");
  $rExtreme=MySQL_Fetch_Array(@MySQL_Query("SELECT max(sequence) AS maxS, min(sequence) AS minS FROM mediaTables WHERE id_flagsTables='$rFlagsTables[id]' AND idInTable='".mysql_real_escape_string($idInTable)."'"));
 if (@MySQL_Num_Rows($qDocs)) 
  echo "<h3>Added PDF file</h3>";
  echo "<div class='overflowBigList'> ";
		//$rsPath="./index2.php?page=tableItem&table=".$table."&id=".$_GET["id"]."&action=".$_GET["action"]."&form=1";
		while($rDocs=@MySQL_Fetch_Array($qDocs)):
			$path="../download/docs/".$rDocs["seo"]; 
			echo "<img src='./layout/icons/".$rDocs["ext"].".png'>&nbsp;<a href='$path' target='_blank'>".stripcslashes($rDocs["media"])."</a>";
			//if($rDocs["sequence"]!=$rExtreme["minS"]) echo "&nbsp;<a title='Posunout o jednu pozici nahoru' href='".$rsPath."&amp;position=".$rDocs["sequence"]."&amp;newPosition=".($rDocs["sequence"]-1)."'><img src='layout/up.png'></a>";
			//if($rDocs["sequence"]!=$rExtreme["maxS"]) echo "&nbsp;<a title='Posunout o jednu pozici dolu' href='".$rsPath."&amp;position=".$rDocs["sequence"]."&amp;newPosition=".($rDocs["sequence"]+1)."'><img src='layout/down.png'></a>";
            echo "&nbsp;&nbsp;&nbsp;<a class='changeOnDoc' data-docid='".$rDocs["id"]."' data-docaction='delete' data-table='$table' data-id='$idInTable' data-flagtableid='$idFlagTable' title='Smazat' href='#'><img src='layout/delFile.png'></a><br/>";
		endwhile;
  echo "</div> <!-- overflowList -->";
}
//------------------------------------------------------------------------------------------------------------------------------------------
function string2domainName($title)  
{
    static $convertTable = array (
        'á' => 'a', 'Á' => 'A', 'ä' => 'a', 'Ä' => 'A', 'č' => 'c',
        'Č' => 'C', 'ď' => 'd', 'Ď' => 'D', 'é' => 'e', 'É' => 'E',
        'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'í' => 'i',
        'Í' => 'I', 'i' => 'i', 'I' => 'I', 'ľ' => 'l', 'Ą' => 'L',
        'ĺ' => 'l', 'Ĺ' => 'L', 'ň' => 'n', 'Ň' => 'N', 'ń' => 'n',
        'Ń' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ö' => 'o', 'Ö' => 'O',
        'ř' => 'r', 'Ř' => 'R', 'ŕ' => 'r', 'Ŕ' => 'R', 'š' => 's',
        'Š' => 'S', 'ś' => 's', 'Ś' => 'S', 'ť' => 't', 'Ť' => 'T',
        'ú' => 'u', 'Ú' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ü' => 'u',
        'Ü' => 'U', 'ý' => 'y', 'Ý' => 'Y', 'y' => 'y', 'Y' => 'Y',
        'ž' => 'z', 'Ž' => 'Z', 'ź' => 'z', 'Ź' => 'Z',
    );
    $title = strtolower(strtr($title, $convertTable));
    $title = preg_replace('/[^a-zA-Z0-9]+/u', '-', $title);
    $title = str_replace('--', '-', $title);
    $title = trim($title, '-');
    return $title;
}
//------------------------------------------------------------------------------------------------------------------------------------------
function string2fileName($title) 
{
    static $convertTable = array (
        'á' => 'a', 'Á' => 'A', 'ä' => 'a', 'Ä' => 'A', 'č' => 'c',
        'Č' => 'C', 'ď' => 'd', 'Ď' => 'D', 'é' => 'e', 'É' => 'E',
        'ě' => 'e', 'Ě' => 'E', 'ë' => 'e', 'Ë' => 'E', 'í' => 'i',
        'Í' => 'I', 'i' => 'i', 'I' => 'I', 'ľ' => 'l', 'Ą' => 'L',
        'ĺ' => 'l', 'Ĺ' => 'L', 'ň' => 'n', 'Ň' => 'N', 'ń' => 'n',
        'Ń' => 'N', 'ó' => 'o', 'Ó' => 'O', 'ö' => 'o', 'Ö' => 'O',
        'ř' => 'r', 'Ř' => 'R', 'ŕ' => 'r', 'Ŕ' => 'R', 'š' => 's',
        'Š' => 'S', 'ś' => 's', 'Ś' => 'S', 'ť' => 't', 'Ť' => 'T',
        'ú' => 'u', 'Ú' => 'U', 'ů' => 'u', 'Ů' => 'U', 'ü' => 'u',
        'Ü' => 'U', 'ý' => 'y', 'Ý' => 'Y', 'y' => 'y', 'Y' => 'Y',
        'ž' => 'z', 'Ž' => 'Z', 'ź' => 'z', 'Ź' => 'Z',
    );
    $title = strtolower(strtr($title, $convertTable));
    $title = preg_replace('/[^a-zA-Z0-9]+/u', '-', $title);
    $title = str_replace('--', '-', $title);
    $title = str_replace('.', '-', $title);
    $title = trim($title, '-');
    return $title;
}
//------------------------------------------------------------------------------------------------------------------------------------------
function file_upload_error_message($error_code) {
    switch ($error_code) {
        case UPLOAD_ERR_INI_SIZE:
            //return 'The uploaded file exceeds the upload_max_filesize directive in php.ini';
			return "Soubor je příliš velký.";
        case UPLOAD_ERR_FORM_SIZE:
            //return 'The uploaded file exceeds the MAX_FILE_SIZE directive that was specified in the HTML form';
			return "Soubor je příliš velký.";
        case UPLOAD_ERR_PARTIAL:
            //return 'The uploaded file was only partially uploaded';
			return "Soubor byl v důsledku výpadku nahrán jen částečně.";
        case UPLOAD_ERR_NO_FILE:
            //return 'No file was uploaded';
			return "Nebyl vybrán žádný soubor.";
        case UPLOAD_ERR_NO_TMP_DIR:
            //return 'Missing a temporary folder';
            return 'Chybí dočasný adresář.';
        case UPLOAD_ERR_CANT_WRITE:
            //return 'Failed to write file to disk';
            return 'Chyba při zápisu na disk.';
        case UPLOAD_ERR_EXTENSION:
            //return 'File upload stopped by extension';
            return 'Upload byl zastaven php rozšířením.';
        default:
            //return 'Unknown upload error';
            return 'Neznámá chyba.';
    }
}
//------------------------------------------------------------------------------------------------------------------------------------------
function  mime2ext($type)
{
    $file_types  = array(   
    'image/pjpeg'     => 'jpg', 
    'image/jpeg'     => 'jpg',
    'image/jpeg'     => 'jpeg',
    'image/gif'     => 'gif',
    'image/X-PNG'    => 'png', 
    'image/PNG'         => 'png', 
    'image/png'     => 'png', 
    'image/x-png'     => 'png', 
    'image/JPG'     => 'jpg',
    'image/GIF'     => 'gif',
    'image/bmp'     => 'bmp',
    'image/bmp'     => 'BMP',
    );
    
   return $file_types[$type]; 
}
//------------------------------------------------------------------------------------------------------------------------------------------
function flags($dbName, $table, $col)
	{
		if (StrStr($dbName, "id_")) $dbName=substr($dbName, 3); 
		$q=MySQL_Query("SELECT $col FROM flags WHERE tableName like '$table' AND colDbName like '$dbName'");
		$r=@MySQL_Fetch_Array($q);
		return $r[$col];
	}
//------------------------------------------------------------------------------------------------------------------------------------------
function restriction($dbName, $table)
	{
		$restriction=flags($dbName, $table, "restriction");
		switch($restriction){
			case "required": $data="data-validation='required' data-validation-error-msg='Pole je povinné'";break;
			case "length_min2": $data="data-validation='length' data-validation-length='min2'";break;
			case "length_min4": $data="data-validation='length' data-validation-length='min4'";break;
			case "length_min5": $data="data-validation='length' data-validation-length='min5'";break;
			case "length_min10": $data="data-validation='length' data-validation-length='min10'";break;
			case "password": $data="data-validation='strength' data-validation-strength='2'";break;  
			case "checkBox_min1": $data="data-validation='checkbox_group' data-validation-qty='min1'";break;  
			case "url": $data="data-validation='url'";break; 
			case "date": $data="data-validation='date' data-validation-format='yyyy-mm-dd'";break; 
			default: break;
		}
		return $data;
	}
//------------------------------------------------------------------------------------------------------------------------------------------
function showStringPart($fullString, $separator, $minLenght)
{
	$showString="";
	if ($minLenght<strlen($fullString)):
		$token=strtok($fullString, $separator);
		while($token):
			$showString.=$token.$separator;
			if (strlen($showString)>=$minLenght) break;
			$token=strtok($separator);	
		endwhile;
		
	else:
		 $showString =$fullString;
	endif;
	return str_replace("div>", "p>",$showString);
}
//------------------------------------------------------------------------------------------------------------------------------------------
		function filesList($id, $lang="CZ") 
			{
				static $i=0;
				$i++;	
				if($_GET["page"] == "pagesRegions" && $i==1){
					$queryRoot=MySQL_Query("SELECT * FROM rspages WHERE id='$id' ");
					$rRoot=MySQL_Fetch_Array($queryRoot);
					echo "<p><span>".$rRoot["name$lang"]."</span>&nbsp;&nbsp;&nbsp;<a href='index2.php?page=tableItem&amp;table=rspages&amp;parent=".$rRoot["id"]."&amp;action=insert'><img src='./layout/icons/insert.png' alt='Insert subpage'  title='Insert subpage'></a></p>";
				}
				$query1=MySQL_Query("SELECT id_page FROM tree WHERE parent='$id' ORDER BY position"); // 11 -regiony
				$numRows=MySQL_Num_Rows($query1);
				$position=1;
				$parent=$id;
				if ($numRows) echo "<ul class='pagesTree'>"; 
				while($result1=MySQL_Fetch_Array($query1)):  
					$id=$result1["id_page"];
					$result=MySQL_Fetch_Array($query=MySQL_Query("SELECT * FROM rspages WHERE id='$id'"));
					$name=$result["name$lang"];
					$id=$result["id"];
						echo "<li style='color:$cLi'><span>$name</span>&nbsp;&nbsp;&nbsp;<a href='index2.php?page=tableItem&amp;table=rspages&amp;id=$id&amp;action=update&amp;form=1'><img src='./layout/icons/edit.png' alt='Edit page' title='Edit page'></a>&nbsp;&nbsp;";
						echo "<a href='index2.php?page=tableItem&amp;table=rspages&amp;parent=$id&amp;action=insert'><img src='./layout/icons/insert.png' alt='Insert subpage'  title='Insert subpage'></a>&nbsp;&nbsp;";		
						if ($position!=1) echo "<span class='stepUpPage' data-pageid='$id' data-parent='$parent' data-position='$position' data-action='stepmove' data-newposition='".($position-1)."'><img src='./layout/icons/up.png' alt='move up'  title='move up'></span>&nbsp;&nbsp;";
						if ($position<$numRows) echo "<span class='stepUpPage' data-pageid='$id' data-parent='$parent' data-position='$position' data-action='stepmove' data-newposition='".($position+1)."'><img src='./layout/icons/down.png' alt='move down' title='move down'></span>&nbsp;&nbsp;";
						//echo "<a href='index2.php?page=move&amp;id=$id&amp;name=".urlencode($name)."'><img src='./layout/move.png' alt='Přemístit stránku i s podstránkami pod jinou stránku'  title='Přemístit stránku i s podstránkami pod jinou stránku'></a>&nbsp;&nbsp;";
						echo "<span class='deletePage' data-pageid='$id' data-parent='$parent' data-position='$position' data-action='delete'><img src='./layout/icons/delete.png' alt='Delete page' title='Delete page'></span><br>"; 
						MySQL_Query("UPDATE tree SET position='$position' WHERE id_page='$id'");
					$position++;	
					if($id!=11) filesList($result["id"]);
					echo "</li>";
				endwhile;
				if ($numRows) echo "</ul>";	
			}
//------------------------------------------------------------------------------------------------------------------------------------------
		function filesListMove($id)
			{
				$query1=MySQL_Query("SELECT id_page FROM tree WHERE parent='$id' ORDER BY position");
				$numRows=MySQL_Num_Rows($query1);
				$position=1;
				$parent=$id;
				if ($numRows) echo "<ul>"; 
				while($result1=MySQL_Fetch_Array($query1)):  
					$id=$result1["id_page"];
					$result=MySQL_Fetch_Array($query=MySQL_Query("SELECT * FROM rspages WHERE id='$id'"));
					$name=$result["name"];
					$id=$result["id"];
						echo "<li><a style='color:$cLi' href='index2.php?page=move&amp;id=$_GET[id]&amp;pageName=".urlencode($_GET[name])."&amp;newParent=$id&amp;parentName=".urlencode($name)."'>$name</a>"; 
					$position++;	
					filesListMove($result["id"]);
				endwhile;
				if ($numRows) echo "</ul>";	
			}
//--------------------------------------------------------------------------------------------------------------------------------------------
function resize($originalFile,$newWidth) {
    $info = getimagesize($originalFile);
	list($width, $height) = getimagesize($originalFile);
    $mime = $info['mime'];
    switch ($mime) {
            case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
					$image_pointer = 'imagecreatetruecolor';
                    $image_save_func = 'imagejpeg';
                    $new_image_ext = 'jpg';
                    break;
            case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
					$image_pointer = 'imagecreatetruecolor';
                    $image_save_func = 'imagepng';
                    $new_image_ext = 'png';
                    break;
            case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
					$image_pointer = 'imagecreatetruecolor';
                    $image_save_func = 'imagegif';
                    $new_image_ext = 'gif';
                    break;
            default: 
                    //throw Exception('Unknown image type.');
    }
    $img = $image_create_func($originalFile);
    $newHeight = ($height / $width) * $newWidth;
    $tmp = $image_pointer($newWidth, $newHeight);
	if($mime=="image/png" || $mime="image/gif"){
		//imagecolortransparent($tmp, imagecolorallocatealpha($tmp, 255, 255, 255, 0));
	  	//imagealphablending($tmp, false);
	  	//imagesavealpha($tmp, true);
	 	$background = imagecolorallocate($tmp, 255, 255, 255);
		imagefill($tmp, 0, 0, $background);
	}
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    $image_save_func($tmp, $originalFile);
}
	
//--------------------------------------------------------------------------------------------------------------------------------------------
function resize_jpg($img,$w,$h)
{
   $imagedata = getimagesize($img);
   if ($w && ($imagedata[0] < $imagedata[1])) {
         $w = ($h / $imagedata[1]) * $imagedata[0];
   } else {
         $h = ($w / $imagedata[0]) * $imagedata[1];
   }
   $im2 = ImageCreateTrueColor($w,$h);
   
	//$image = imagecreatefromgif($img);
   $image = imagecreatefromjpeg($img);
   //$image = imagecreatefrompng($img);
   //$image = imagecreatefromwbmp($img);
   imagecopyResampled ($im2, $image, 0, 0, 0, 0, $w, $h, $imagedata[0], $imagedata[1]);
   ImageJpeg($im2, $img, 100);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
function resize_gif($img,$w,$h)
{
   $imagedata = getimagesize($img);
   if ($w && ($imagedata[0] < $imagedata[1])) {
         $w = ($h / $imagedata[1]) * $imagedata[0];
   } else {
         $h = ($w / $imagedata[0]) * $imagedata[1];
   }
   $im2 = imagecreate($w,$h);
   
	$image = imagecreatefromgif($img);
   //$image = imagecreatefromjpeg($img);
   //$image = imagecreatefrompng($img);
   //$image = imagecreatefromwbmp($img);
   
   imagecopyResampled ($im2, $image, 0, 0, 0, 0, $w, $h, $imagedata[0], $imagedata[1]);
   imagegif($im2, $img, 100);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
	
	function invertDatumToDB($sourceDate)
		{
			if (StrStr($sourceDate, ".")) List($day, $month, $year) = Explode(".", $sourceDate);
			return $sourceDate=$year."-".$month."-".$day;
		}
		
		
//-------------------------------------------------------------------------------------------------------------------------------------------------		
	function invertDatumFromDB($sourceDate)
		{
			List($year, $month, $day) = Explode("-", $sourceDate);
			return $date=$day.".".$month.".".$year;
			
			
		}

//-------------------------------------------------------------------------------------------------------------------------------------------------
    function showItemDateFromTo($from, $to){
        if($from===$to){
            echo invertDatumFromDB($from);
        }else{
            echo invertDatumFromDB($from)." - ".invertDatumFromDB($to);
        }
    }
		
//-------------------------------------------------------------------------------------------------------------------------------------------------		
	function shortTime($time)
		{
			return $time= substr($time, 0, -3);
		}		
				
		
//-------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	function generateOption($start, $end, $value, $step=1) 
		{
			for ($i=$start; $i<=$end; $i+=$step):
				//if ($i<10) $i="0".$i;
				echo "<option value=\"".$i."\" ";
				if ($value == $i) echo "SELECTED"; 
				echo">".$i;
				
				echo "</option>"; 
			endfor;
		}
//-------------------------------------------------------------------------------------------------------------------------------------------------
	
	
	function generateOptionZero($start, $end, $value=0, $step=1)
		{
			echo "<option value=\"0\""; 
			if ($value == 0) echo " SELECTED "; 
			echo ">----";
			for ($i=$start; $i<=$end; $i+=$step):
				if ($i<10) $i="0".$i;
				echo "<option value=\"".$i."\" ";
				if ($value == $i) echo "SELECTED"; 
				echo">".$i;
				
				echo "</option>"; 
			endfor;
		}
		
		
//-------------------------------------------------------------------------------------------------------------------------------------------------
function generateList($query, $orderCol, $direction, $start, $limit, $idFlagsTable)
{
	global $exportQuery;
	
	changeDirection($direction);
	echo "<form>";
	$tdbgCH="#fff";
	$tdbg="#f4f4f4";
	echo "<table class='listTable' cellspacing='1' cellpadding='3'  onMouseover=\"changeto(event, '$tdbgCH')\" onMouseout=\"changeback(event, '$tdbg')\"><thead><tr><th colspan='2'><br><input type='submit' value='filter &raquo;'></th>";
			$q=MySQL_Query("SELECT * FROM flags WHERE tableName='$_GET[table]' ORDER BY sequence ASC LIMIT 0,4");
			//echo "SELECT * FROM flags WHERE tableName='$_GET[table]' ORDER BY sequence ASC<br>";
			while($r=MySQL_Fetch_Array($q)):
				$name=$r["colDbName"];
				$variables.=$name."=".$_GET["$name"]."&amp;";
			endwhile;			
			$q=MySQL_Query("SELECT * FROM flags WHERE tableName='$_GET[table]' ORDER BY sequence ASC LIMIT 0,10");
			while($r=MySQL_Fetch_Array($q)):
				echo "<th><a href=\"".$_SERVER['PHP_SELF']."?".$variables."page=$_GET[page]&amp;table=$_GET[table]&amp;action=$action&amp;orderCol=".$r["colDbName"]."&amp;direction=$direction&amp;limit=$limit\">".$r["colWebName"]."</a>";
				
				$name=$r["colDbName"];				
				$size=$r["inputSize"];
				echo "<br><input name='$name' value='".$_GET["$name"]."' size='$size'>";
				if ($_GET["$name"]):
					if (!IsSet($cons)) $cons="HAVING ";
					if ($cons=="HAVING ") $cons.="($name like '%".$_GET["$name"]."%')";
					else $cons.=" AND ($name like '%".$_GET["$name"]."%')";
				endif;			
				if (($name==$orderCol) AND ($direction=="DESC")) echo "<br><img src='./layout/desc.gif'>";
				if (($name==$orderCol) AND ($direction=="ASC")) echo "<br><img src='./layout/asc.gif'>";
				echo "</th>";
			endwhile;
			echo "</thead></tr>";
			if (empty($query)) $query="SELECT t.* FROM $_GET[table] AS t";
			if(!$_ENV["userIsAdmin"]) $query.=" INNER JOIN accesses AS a ON t.id=a.id_item WHERE a.id_user= '".$_SESSION["userId"]."' AND a.id_flagsTables='$idFlagsTable'";
			$_SESSION['ssql']=$query." $cons ORDER BY $orderCol";
            $query.=" $cons ORDER BY t.$orderCol $direction";
            $exportQuery=$query;
			$query.=" LIMIT $start, $limit";
			
			$showQuery=$query; // jen kvuli kontrole - posledni radek funkce
			$query=MySQL_Query($query);
		$seek=0;
		while($result=MySQL_Fetch_Array($query)):
			
			echo "<tr >";
			echo "<th><a class='labelDelete' href=\"#\" onClick=\"yes=confirm('Really delete the record?'); if(yes) window.location.href='".$_SERVER['PHP_SELF']."?page=".$_GET[page]."&amp;id=".$result["id"]."&amp;table=$_GET[table]&amp;action=delete&amp;start=$start'\">delete</a></th>";
			echo "<th><a class='labelEdit' href=\"".$_SERVER['PHP_SELF']."?page=".$_GET[page]."&amp;id=".$result["id"]."&amp;table=$_GET[table]&amp;action=update&amp;form=1\">edit</a></th>";
		 $seek++;
			$q=MySQL_Query("SELECT colDbName FROM flags WHERE tableName='$_GET[table]' ORDER BY sequence ASC LIMIT 0,10");
			while($r=MySQL_Fetch_Array($q)):
				$name=$r["colDbName"]; 
				echo "<td>".strip_tags(showStringPart($result["$name"], " ", 100))."</td>";		
			endwhile;	 
		echo  "</tr>";
		endwhile;	
	echo "</tbody></table>";
	
	
	changeDirection($direction);  // down navigation
	$position=$start-$limit;
	$url="<a href=\"".$_SERVER['PHP_SELF']."?".$variables."page=$_GET[page]&amp;table=$_GET[table]&amp;action=$action&amp;orderCol=$orderCol&amp;direction=$direction&amp;limit=$limit&amp;";
	echo $url."start=$position\"><div class='button'>předchozí&nbsp;&lt;</div></a>";														//previous	
	$position=$start+$limit;	
	 echo $url."start=$position\"><div class='button'>&gt;&nbsp;další&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</div></a>";																				//next	
	changeDirection($direction);
	
	echo "<p style='clear:left;'>number of records: <strong>".MySQL_Num_Rows(MySQL_Query($_SESSION['ssql']))."</strong>&nbsp;&nbsp;|&nbsp;&nbsp;";
	
	echo	"viewed records:"; 
	echo 	"<input type='hidden' name='table' value='".$_GET[table]."'>";
	echo 	"<input type='hidden' name='page' value='".$_GET[page]."'>";
	echo 	"<input type='text' name='limit' value='".$limit."' size='3'>";
	echo 	"<input style='margin-bottom:-9px' type='submit' value='set up'>";
	echo 	"</p>";
	
	echo "</form>";		
	//echo "<code>SQL:  $showQuery</code><br>";
	
	
}
//------------------------------------------------------------------------------------------------------------------------------------------------
function delLine($tblName, $conName, $conOper, $conVal){
$sqlLine="delete from  $tblName where $conName $conOper $conVal;";
//echo $sqlLine;die;
$res=mysql_query($sqlLine);
//if ($res) echo "Odstraneni probehlo v poøádku";
}//end func
//------------------------------------------------------------------------------------------------------------------------------------------------
function changeDirection(&$direction)
{
	
	if ($direction=="ASC")  $direction="DESC";
		else  $direction="ASC";
		
}
//------------------------------------------------------------------------------------------------------------------------------------------
 
function selectOnQuery($selectId, $query, $defaultValue, $behaviour="", $tabindex, $noSelectedText="-- Vyberte ze seznamu --")
{
                global $i;
               
               
                echo "<select id='$selectId' tabindex='$tabindex' name='$selectId' size='1' $behaviour >";
                $q=MySQL_Query($query);
                echo "<option value=''>$noSelectedText</option>";
                while($r=MySQL_Fetch_Array($q)):
                               $value=$r["value"];
                               $item=$r["item"];
                               if ($defaultValue==$value) $selected=" SELECTED ";else $selected="";
                               echo "<option $selected value='$value'>$item</option>";
                endwhile;         
                echo "</select>";
}

//-------------------------------------------------------------------------------------------------------------------------------------------------
	function generateSelectFromDBCol($col, $valueCol, $table, $defaultValue, $tabindex, $behaviour="")
		{
			
			
			echo "<select name=\"$col\" id=\"$col\"  tabindex='$tabindex'  $behaviour>";
			$q=MySQL_Query("SELECT $col, $valueCol FROM $table ORDER BY $col");
	if ($_ENV["lang"]=="CZ") echo "<option value=''>-- Vyberte ze seznamu --</option>";else echo "<option value=''>-- Select from list --</option>" ;
			while($r=MySQL_Fetch_Row($q)):
				echo "<option ";
				if ($defaultValue==$r[1]) echo "SELECTED ";
				echo "value='".$r[1]."'>".$r[0]."</option>";
			endwhile;	
			echo "</select>";
		}
