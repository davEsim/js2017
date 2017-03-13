<?
function autoload_class_multiple_directory($class_name)
{
    $array_paths = array(
        '',
        '/',
        '/base/',
        '/ext/'
    );
    foreach($array_paths as $path)
    {
        $file = sprintf("%s/classes%s%s.class.php", dirname(__FILE__), $path, $class_name);

        if(is_file($file))
        {
            include_once $file;
        }
    }
}

//------------------------------------------------------------------------------------------------------------------------------------------

function inflictionIcons($icons){
    if($icons) {
        $icons = explode(",", $icons);
        foreach($icons AS $icon) {
                switch ($icon = trim($icon)) {
                    case "ucho":
                        $title = "titulky pro neslyšící a nedoslýchavé";
                        break;
                    case "oko":
                        $title = "přístupné pro nevidomé a slabozraké";
                        break;
                    case "masky":
                        $title = "přístupné pro publikum s mentálním postižením";
                        break;
                    case "vozik":
                        $title = "přístupné pro publikum s omezením hybnosti";
                        break;
                    case "starik":
                        $title = "seniorské projekce";
                        break;
                    case "uchoT":
                        $title = "indukční smyčka";
                        break;
                    case "ctenar":
                        $title = "informace ve snadno srozumitelném jazyce";
                        break;
                    case "AD":
                        $title = "audio popis";
                        break;
                    case "ruce":
                        $title = "tlumočení do znakového jazyka";
                        break;

                }
                ?>
                <span data-tooltip aria-haspopup="true" class="has-tip" data-disable-hover="false" tabindex="1"
                      title="<?=$title?>"><img src='<?=$_ENV["serverPath"]?>imgs/icons/inflictions/<?=$icon?>.svg'></span>
            <?
        }
    }
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
function __($csString){
    global $db;
    if($_ENV["lang"]=="CZ"){
        $string=$csString;
    }else{
        $params=array(":cs" => trim($csString));
        $r = $db->queryOne("SELECT EN FROM  translations WHERE CZ LIKE :cs", $params);
        if($r){
            $string=$r["EN"];
        }else{
            $string=$csString;
        }
    }
    return $string;
}

//------------------------------------------------------------------------------------------------------------------------------------------
function pageContent($id){
    global $db;
    $params=array(":id"=>$id);
    $page=$db->queryOne("SELECT * FROM rspages WHERE id=:id", $params);
    return $page;
}
//------------------------------------------------------------------------------------------------------------------------------------------
function pageContentCol($id, $col){
    global $db;
    $params=array(":id"=>$id);
    $page=$db->queryOne("SELECT $col FROM rspages WHERE id=:id", $params);
	return $page[$col];
}

//------------------------------------------------------------------------------------------------------------------------------------------
function parentPage($id){
    global $db;
    $params=array(":id"=>$id);
    $tree=$db->queryOne("SELECT parent FROM tree WHERE id_page=:id", $params);
    return $tree["parent"];
}

//------------------------------------------------------------------------------------------------------------------------------------------
function generateOneLevelMenu($id, $same){
    global $db;
    $lang=$_ENV["lang"];
    $parent=parentPage($id);

    if($parent==7 || $same){ // 7-MENU
        $params=array(":parent"=>$id);
    }else{
        $params=array(":parent"=>$parent);
    }
    $pages=$db->queryAll("SELECT * FROM rspages AS r INNER JOIN tree AS t ON r.id=t.id_page WHERE t.parent=:parent AND display$lang LIKE 'ano' ORDER BY t.position ASC", $params);
    if(count($pages)){
        echo "<ul>";
        foreach($pages AS $page){
            echo "<li><a href='".$_ENV["relPath"].$page["seoUrl$lang"]."'>".$page["name$lang"]."</a></li>";
        }
        echo "</ul>";
    }
}

//------------------------------------------------------------------------------------------------------------------------------------------
function generateMenu($parentId, $showSubMenu = false, $lang = ""){
    global $db;
    $params1 = array(":parentId" => $parentId);
    $menuItems=$db->queryAll("SELECT rp.* FROM rspages AS rp INNER JOIN tree AS t ON rp.id=t.id_page WHERE t.parent=:parentId AND display$lang LIKE 'ano' ORDER BY t.position ASC", $params1);
    foreach($menuItems AS $menuItem){

        if(in_array($menuItem["id"], $_ENV["parents"])) $activeClass = "active"; else $activeClass = "";
        $params2 = array(":menuItemId" => $menuItem["id"]);
        $menuSubItems=$db->queryAll("SELECT rp.* FROM rspages AS rp INNER JOIN tree AS t ON rp.id=t.id_page WHERE t.parent=:menuItemId AND rp.display$lang LIKE 'ano' ORDER BY t.position ASC", $params2);
        //if(count($menuSubItems) && $showSubMenu) $dropDownClass = "has-dropdown"; else $dropDownClass="";
        if($menuItem["seoUrl$lang"]) {
            echo "<li class='$dropDownClass $activeClass'><a title='" . $menuItem["name$lang"] . "' href='" . $_ENV["relPath"] . $menuItem["seoUrl$lang"] . "'>" . $menuItem["name$lang"] . "</a>";
        }else{
            echo "<li class='$activeClass'><a>" . $menuItem["name$lang"]."</a>";
        }
            if(count($menuSubItems) && $showSubMenu){
            echo "<ul class='menu vertical ".(($menuItem["id"]==11)?"wideMenuRegions":"")."'>\n";
                if($menuItem["id"]  == 11){
                    echo "<p><a href='".$_ENV[serverPath]."regiony'>O regionech</a></p><li>&nbsp;</li>";
                }
                foreach($menuSubItems AS $menuSubItem){
                    if($menuSubItem["seoUrl$lang"]==$_ENV["page"]) $activeClass = "class='active'";else $activeClass = "";
                    echo "<li $activeClass><a title='".$menuSubItem["name$lang"]."' href='".$_ENV["relPath"].$menuSubItem["seoUrl$lang"]."'>".$menuSubItem["name$lang"]."</a></li>\n";
                }
            echo "</ul>\n";
        }
        echo "</li>\n";
    }
}
//------------------------------------------------------------------------------------------------------------------------------------------
function parents($activePageId){
	static $parents=array();
	static $counter; // jenom radši brzda kvuli rekurenci
	//$parentId=$activePageId;
	//$parents[]=$activePageId;
	if($activePageId!=1 && $counter<10){ // 1 = root
		$parentId=parentPage($activePageId);
		$parents[]=$parentId;
		$counter++;
		parents($parentId);	
	}
	return array_unique(array_reverse($parents));
}
//------------------------------------------------------------------------------------------------------------------------------------------
function tree($parents,$parent){
	global $db;
	$lang=$_ENV["lang"];
	$siblings=$db->queryAll("SELECT * FROM rspages AS r INNER JOIN tree AS t ON r.id=t.id_page WHERE t.parent=:parent", array(":parent"=>$parent));
	if(count($siblings)){
		echo "<ul>";
			foreach($siblings AS $sibling){
				echo "<li><a href='./".$sibling["seoUrl$lang"]."'>".$sibling["name$lang"]."</a></li>";
				if(in_array($sibling["id"], $parents)) tree($parents, $sibling["id"]);	
			}
		echo "</ul>";
	}
} 
//------------------------------------------------------------------------------------------------------------------------------------------
function generateSideMenu($activePageId){
	$parents=array();
	$parents=parents($activePageId);
	//print_r($parents);
	$start=$parents[4];
	tree($parents, $start);
}

//------------------------------------------------------------------------------------------------------------------------------------------
function formatTextMail($body)
	{
		$tags=array("<br>", "</br>", "</td>", "</tr>","</table>", "</fieldset>","</p>","</h2>","</h3>");
		$textTags=array("\n","\n","\t","\n","\n\n","\n\n","\n\n","\n\n","\n\n");
		return strip_tags(str_replace($tags, $textTags, $body));
		
	}
  
//--- konečne funkce na všechny media !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!--------------------------------------------------------------
function getFirstMedia($table, $idInTable, $imgLink=0, $classA="", $classImg="", $ext="img", $subPath="small/", $showTitle=FALSE){
    global $db;
    global $itemId;
	if($ext=="img") $exts="'jpg', 'gif', 'png'"; else $exts="'pdf'";
    $params=array(":table"=>$table, ":idInTable"=>$idInTable);
	$rMedia=$db->queryOne("SELECT i.* FROM media AS i
							INNER JOIN mediaTables AS it ON i.id=it.id_media 
							INNER JOIN flagsTables as ft ON it.id_flagsTables=ft.id
							 WHERE ft.tableDbName=:table
							 AND idInTable=:idInTable
							 AND i.ext IN ($exts)
							 ORDER BY i.id ASC LIMIT 0,1", $params);
	$mediaString="";
	if($rMedia["id"]){
		if($ext=="img"){
			$path=$_ENV["serverPath"]."download/imgs/$subPath".$rMedia["seo"];
			$pathToBigger=$_ENV["downDir"]."imgs/".$rMedia["seo"];
			if($imgLink) $mediaString="<a  class='".(($classA)?"$classA":"")."' href='".$linkToBigger."'>";
			    $mediaString.="<img src='$path' alt='".$rMedia["title"]."' ".(($classImg)?"class='$classImg'":"").">";
            if($rMedia["media"] && $showTitle)$mediaString.="<p>".$rMedia["media"]."</p>"; //popisek fotky zobrazuji jen v detailu
			if($imgLink) $mediaString.="</a>";
		}else{
			$mediaString=$_ENV["downDir"]."docs/".$rMedia["seo"];
		}
	}else{
		if($ext=="img" && !$itemId && $table!="rspages"){ // v detailu nezobrazuju zástupný obrázek
            if($imgLink) $mediaString="<a  class='".(($classA)?"$classA":"")."'>";
            if($imgLink) $mediaString.="</a>";
        }
	}
	return  $mediaString;
}
//--- konečne funkce na všechny media !!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!!--------------------------------------------------------------
function getFirstMediaPath($table, $idInTable, $ext="img", $small="small/"){
	global $db;
	if($ext=="img") $exts="'jpg', 'gif', 'png'"; else $exts="'pdf'";	
	$rMedia=$db->queryOne("SELECT i.* FROM media AS i 
							INNER JOIN mediaTables AS it ON i.id=it.id_media 
							INNER JOIN flagsTables as ft ON it.id_flagsTables=ft.id
							 WHERE ft.tableDbName='$table' 
							 AND idInTable='$idInTable' 
							 AND i.ext IN ($exts)
							 ORDER BY i.id DESC LIMIT 0,1");
	if($rMedia["id"]){
		if($ext=="img"){	
			$path=$_ENV["downDir"]."imgs/$small".$rMedia["seo"];
		}else{
			$path=$_ENV["downDir"]."docs/".$rMedia["seo"];
		}
	}else{
		//if($ext=="img") $mediaString="<img src='$path' alt='No image'>";
	}
	return  $path;
}
//------------------------------------------------------------------------------------------------------------------------------------------
function showItemDocs($table, $idInTable){
    global $db;
    $params=array(":table"=>$table, ":idInTable"=>$idInTable);
    $docs=$db->queryAll("SELECT i.*, it.sequence
                        FROM media AS i
                        INNER JOIN mediaTables AS it
                        ON i.id=it.id_media
                        INNER JOIN flagsTables as ft
                        ON it.id_flagsTables=ft.id
                        WHERE ft.tableDbName=:table
                        AND idInTable=:idInTable
                        AND i.ext IN ('pdf','doc','docs')
                        ORDER BY i.id DESC",$params);
    if(count($docs)){
        echo "<div class='itemSection'><span class='itemSectionBlue'>Ke stažení</span></div>";
        foreach ($docs AS $doc){
            echo "<div class='docsList'> ";
                $path="/download/docs/".$doc["seo"];
                echo "<img src='/rs/layout/icons/".$doc["ext"].".png'>&nbsp;<a href='$path' target='_blank'>".stripcslashes($doc["media"])."</a><br/>";
            echo "</div> <!-- overflowList -->";
        }
    }
}
//------------------------------------------------------------------------------------------------------------------------------------------
function showStringPart($fullString, $separator, $minLenght)
{
	$showString="";
	$fullString=preg_replace('/\s+/', ' ', strip_tags($fullString));
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
	//return str_replace("div>", "p>",$showString);
    $showString=substr($showString, 0, -1);
	if($fullString != $showString){
			$showString.="...";
	}
	return $showString;
}
//------------------------------------------------------------------------------------------------------------------------------------------
function selectOnQuery($selectId, $selectClass, $query, $defaultValue, $behaviour="", $tabindex)
{
    global $db;
	echo "<select id='$selectId' class='$selectClass' tabindex='$tabindex' name='$selectId' size='1' $behaviour >";
	echo "<option value=''>-- Vyberte --</option>";
    $rs=$db->queryAll($query);
	foreach($rs AS $r){
		$value=$r["value"];
		$item=$r["item"];
		if ($defaultValue==$value) $selected=" SELECTED ";else $selected="";
		echo "<option $selected value='$value'>$item</option>";
    }
	echo "</select>";
}
  
//--------------------------------------------------------------------------------------------------------------------------------------------
function resize($originalFile,$newWidth) {
    $info = getimagesize($originalFile);
	list($width, $height) = getimagesize($originalFile);
    $mime = $info['mime'];
    switch ($mime) {
            case 'image/jpeg':
                    $image_create_func = 'imagecreatefromjpeg';
                    $image_save_func = 'imagejpeg';
                    $new_image_ext = 'jpg';
                    break;
            case 'image/png':
                    $image_create_func = 'imagecreatefrompng';
                    $image_save_func = 'imagepng';
                    $new_image_ext = 'png';
                    break;
            case 'image/gif':
                    $image_create_func = 'imagecreatefromgif';
                    $image_save_func = 'imagegif';
                    $new_image_ext = 'gif';
                    break;
            default: 
                    //throw Exception('Unknown image type.');
    }
    $img = $image_create_func($originalFile);
    $newHeight = ($height / $width) * $newWidth;
    $tmp = imagecreatetruecolor($newWidth, $newHeight);
    imagecopyresampled($tmp, $img, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
    $image_save_func($tmp, $originalFile);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
function dateRange($first, $last, $step = '+1 month', $format = 'Y-m-d' ) {
  $dates = array();
  $current = strtotime($first);
  $last = strtotime($last);
  while( $current <= $last ) {	
	$dates[] = date($format, $current);
	$current = strtotime($step, $current);
  }
  return $dates;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function invertDatumToDB($sourceDate)
{
    List($day, $month, $year) = explode(".", $sourceDate);
    return $date=$year."-".$month."-".$day;
}

//-------------------------------------------------------------------------------------------------------------------------------------------------
function invertDatumFromDB($sourceDate, $withoutYear=0)
{
    list($year, $month, $day) = explode("-", $sourceDate);
    if($withoutYear)
		$date=$day.". ".$month.". ";
	else
		$date=$day.". ".$month.". ".$year;
	return $date;	
}
//--------------------------------------------------------------------------------------------------------------------------------------------
function dateFromTo($from,$to=NULL){
  if($from==$to || $to==NULL){
	  
	  $date=date("M d, Y",strtotime($from));
  }else{
	  $date=date("M d, Y",strtotime($from))." - ".date("M d, Y",strtotime($to));
  }
  return $date;		
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function showItemDateFromTo($from, $to){
    if($from===$to){
        $date=invertDatumFromDB($from);
    }else{
        list($yearFrom, $monthFrom, $dayFrom)=explode("-",$from);
        list($yearTo, $monthTo, $dayTo)=explode("-",$to);
        if($yearFrom===$yearTo){
            $date=$dayFrom." .".$monthFrom." . - ".invertDatumFromDB($to);
        }else{
            $date=invertDatumFromDB($from)." - ".invertDatumFromDB($to);
        }
    }
    return $date;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function czechFullMonthName($monthNumber){
    $months=array("Leden", "Únor", "Březen", "Duben", "Květen", "Červen", "Červenec", "Srpen", "Září", "Říjen", "Listopad","Prosinec");
    return $months[$monthNumber];
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function czechFullDayName($day){
	
    $days=array("Monday" => "Pondělí", "Tuesday" => "Úterý", "Wednesday" => "Středa", "Thursday" => "Čtvrtek", "Friday" => "Pátek", "Saturday" => "Sobota", "Sunday" => "Neděle");
	if($_ENV["lang"] == "CZ") $day = $days["$day"];
	return $day;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function czechFullDayNameFromDate($date){
	$day = new DateTime($date);	
	$dayName = date_format($day, 'l'); 
	return czechFullDayName($dayName);
}
//--------------------------------------------------------------------------------------------------------------------------------------------
function dateOfInsert($flagTable, $id){
	$r=MySQL_Fetch_Array(MySQL_Query("SELECT datum FROM logs WHERE id_flagsTables='$flagTable' AND id_item='$id' AND action like 'insert'"));
	return dateFromTo($r["datum"]);
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function generateOptionZero($start, $end, $value=0, $step=1){
    echo "<option value='0'";
    if ($value == 0) echo " ";
    echo ">----</option>\n";
    for ($i=$start; $i<=$end; $i+=$step):
        if ($i<10) $i="0".$i;
        echo "<option value=\"".$i."\" ";
        if ($value == $i) echo "SELECTED";
        echo">".$i;
        echo "</option>\n";
    endfor;
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function generateRadio($name, $start, $end, $step){
	for($i=$start; $i<=$end; $i++){
		echo "<label class='inlineBlock'><input type='radio' name='$name' value='$i'> $i</label> &nbsp;&nbsp;&nbsp;&nbsp;";
	}
		echo "<label class='inlineBlock'><input type='radio' name='$name' value='0'> nemám názor</label>";
}
//-------------------------------------------------------------------------------------------------------------------------------------------------
function modifyImgPathfromSB($path, $x){
	parse_str(parse_url($path, PHP_URL_QUERY), $imgParams);
	$imgW=round($imgParams["W"]/$x);
	$imgH=round($imgParams["H"]/$x);
	$imgId=$imgParams["IMGID"];
	$imgPath="https://images.pinf.cz/images/filmimages/image.ashx?I=2&W=".$imgW."&H=".$imgH."&ID=0&IMGID=".$imgId;
	return $imgPath;	
}
?>