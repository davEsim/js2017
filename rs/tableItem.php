<?php 
if (!IsSet($_GET["form"])) $_GET["form"]=0;
if (IsSet($_POST["sent"])){ 
 	while(list($variable, $value) = each($_POST)){
		//echo $variable."=".$value."<br>";
	}
}
if($_GET["table"]){
	$rFlagsTables=MySQL_Fetch_Array(MySQL_Query("SELECT * FROM flagsTables WHERE tableDbName='$_GET[table]'"));
	$rFlags=MySQL_Fetch_Array(MySQL_Query("SELECT * FROM flags WHERE tableName='$_GET[table]'"));
	echo "<h1>".$rFlagsTables["tableWebName"]."</h1>";
}
$message="";
if (($_REQUEST["action"]=="insert") OR ($_POST["action"]=="update")):
	$id=$_GET["id"];
	if (IsSet($_POST["sent"])):
		if($_GET["table"]=="rspages"){
			pageNames();
		}
		// solve users - start	--------------------------------------------------------------------------------------------------------------
		if($_GET["table"]=="users" && $_REQUEST["action"]=="insert"):
			$_POST["userPsswd"]=md5($_POST["userPsswd"]);
			$_POST["uid"]=md5(uniqid(rand()));
			$_POST["lastTime"]=date("Y-m-d H:i:s");
			$_POST["regTime"]=date("Y-m-d H:i:s");
		endif;
		if($_GET["table"]=="users" && $_REQUEST["action"]=="update"):
			if(strlen($_POST["userPsswd"]) !== 32) $_POST["userPsswd"]=md5($_POST["userPsswd"]);
		endif;
		// solve users - end	--------------------------------------------------------------------------------------------------------------
		$fields=MySQL_List_Fields($sql->dbName, $_GET["table"]);
		$numFields=@MySQL_Num_Fields($fields);
		$insertFields="NULL"; $updateFields="";
		for($i=1; $i<$numFields; $i++):
			$fieldName=MySQL_Field_Name($fields, $i);
			//if($_POST[$fieldName]=="") $_POST[$fieldName]="NULL";
			$insertFields.=", '".escapeValue($_POST[$fieldName])."'";
			if ($i!=1) $updateFields.=", ";
			$updateFields.="$fieldName='".escapeValue($_POST[$fieldName])."'";
			endfor;
		if ($_REQUEST["action"]=="insert"):
			$query= "INSERT INTO $_GET[table] VALUES ($insertFields)";
			 MySQL_Query($query);                        
			$_GET["id"]=$id=MySQL_Insert_Id();
                        accessesLogs($_REQUEST["action"],$rFlagsTables[id]);
			if($_GET["table"]=="rspages"): // pri vkladani stranek, pridat i do stromove struktury
					$q=MySQL_Query("SELECT * FROM tree WHERE parent='$_GET[parent]'");
					$position=MySQL_Num_Rows($q)+1;
					MySQL_Query("INSERT INTO tree VALUES ('$id','$position','$_GET[parent]')"); 	
			endif;
			unset($query);
			if($message) $_GET["form"]=1; else unset($_GET["form"]);
		endif;	 
		if ($_POST["action"]=="update"):
			$id=$_POST["id"];
			  /*echo*/ $query="UPDATE $_GET[table] SET $updateFields WHERE id='$id'";
			 MySQL_Query($query);
                         accessesLogs($_POST["action"],$rFlagsTables[id]);
			 unset($query);
			if($message) $_GET["form"]=1; else unset($_GET["form"]);
		endif;
		//-------------- relacni tabulky M-N
		$tables=MySQL_List_Tables($sql->dbName);
		for ($i=0; $i<@MySQL_Num_Rows($tables); $i++):
			$tableName=MySQL_TableName($tables, $i);
			
			$prefix=$_GET["table"]."_";
			if ($relTable=strstr($tableName, $prefix)):
				 $relTable=substr($relTable, strlen($prefix));
				 $idLeft="id_".$_GET["table"];
				  $query="DELETE FROM $tableName WHERE $idLeft='$id'";
				 MySQL_Query($query);
				if(count($_POST[$relTable])):
				 foreach ($_POST[$relTable] AS $value)
				 	{
						 $query2="INSERT INTO $tableName  VALUES ('$id', '$value')"; 					 
				 		MySQL_Query($query2);					
				 	}
				endif;	
			endif;	 	
		endfor;
		  if($_POST["extFiles"]) $_GET["form"]=1; else  $_GET["form"]=0;
			else://send
		$_GET["form"]=1; 
	endif;//send
endif;//action		 
if ($_GET["action"]=="delete"):
 delLine($_GET["table"], "id", "=", $_GET["id"]);
accessesLogs($_GET["action"],$rFlagsTables[id]);
endif; 
if ($_GET["form"]):
	if($message) echo "<p class='warning'>$message</p>";
	?>
	<form name="formTableItem" id="formTableItem" method="post" enctype="multipart/form-data"> 
		<table>
		<?php
			$sql->query('flagsTables', "SELECT * FROM flagsTables WHERE tableDbName like '$_GET[table]'");
			$flagsTables=$sql->fetch_assoc('flagsTables');
			?>
	<?php	
	 $q=MySQL_Query("SHOW FIELDS FROM $_GET[table]");
	if (IsSet($_GET["id"])||!empty($_FILES['fileImg']['tmp_name'])):
		if($_GET["id"]) $id=$_GET["id"];
		$query=MySQL_Query("SELECT * FROM $_GET[table] WHERE id='$id'");
		$result=MySQL_Fetch_Array($query);
	endif;	
	while ($r=MySQL_Fetch_Array($q)): // projizdim vsechna pole dane tabulky a zjistuji nazev a typ pole
		$fieldName=$r["Field"];			// jmeno pole v table
		//$fieldWithLang=FALSE;			// jen kvuli jazykovemu zrcadlu
		//if(IsSet($_ENV["noLang"])) $fieldWithLang=strstr($fieldName, $_ENV["noLang"], true);
		//if($fieldWithLang) continue;
		if (StrStr($fieldName, "id_")):
		 $relTable=substr($fieldName, 3); 
		 echo "<tr><th>".flags($fieldName, $_GET["table"], "colWebName");
		 ?>
         <a href="#" class="help" title="<? echo flags($fieldName, $_GET["table"], "descr") ?>">?</a>
		 <?php
		 echo"</th><td>";
		 @selectOnQuery($fieldName, "SELECT id AS value, $relTable AS item FROM $relTable GROUP BY value ORDER BY $relTable ASC", $result["$fieldName"],restriction($fieldName, $_GET["table"]),"","-- Select from List --" ); // pro funkcnost je treba, aby se pole v tabulce jmenovalo stejne jako cela table
		 
		 echo "</td></tr>"; 
		 continue;
		endif;
		$fieldTypeComplet=$r["Type"];			// cely datovy typ pole: typ+delka
		$tokens="()";
		$fieldType=strtok($fieldTypeComplet, $tokens);	// jen datovy typ pole 
		if($fieldType=="longtext") $fieldType="text";
		$fieldLen=strtok($tokens);				// delka pole, pokud je a pokud neni enum
		switch ($fieldType):
			case "enum":
				$token="'";
				$value=strtok($fieldLen, $token);
					?>
					<tr><th  style='vertical-align:top'><?php  echo  flags($fieldName, $_GET["table"], "colWebName") ?>
					<a href="#" class="help" title="<? echo flags($fieldName, $_GET["table"], "descr") ?>">?</a>
					</th><td colspan="2">
					<?php
				while ($value):
					if ($value!=","):
					?>
						&nbsp;&nbsp;<input <?php  echo restriction($fieldName, $_GET["table"])?> type="radio" name="<?php  echo $fieldName ?>" <?php if ((IsSet($result["$fieldName"])) AND ($result["$fieldName"]=="$value")) echo "CHECKED";  ?> value="<?php  echo $value  ?>"><?php  echo $value  ?><br>
					<?php
					 endif;
					$value=strtok($token);
				endwhile;
				echo "</td></tr>";
				break;	
			case "text":
				?>
					<tr><th><?php  echo flags($fieldName, $_GET["table"], "colWebName") ?>
					<a href="#" class="help" title="<? echo flags($fieldName, $_GET["table"], "descr") ?>">?</a>
					</th><td colspan="2">
					<?php
					if($fieldName=="code"):
							echo "<textarea cols='50' rows='2' name='code' >".$result["$fieldName"]."</textarea>";
							else:
							echo "<textarea cols='62' class='ckeditor' name='$fieldName' ".restriction($fieldName, $_GET["table"]).">".$result["$fieldName"]."</textarea>";
							?>
                            <script>
							  $(document).ready(function(){
								  $(".formSubmit").click(function(){
										  CKEDITOR.instances.<?=$fieldName?>.updateElement();
								  });
							  });
							  var roxyFileman = './ckeditor/fileman/index.html'; 
								$(function(){
								   CKEDITOR.replace( '<?=$fieldName?>',{filebrowserBrowseUrl:roxyFileman,
																filebrowserImageBrowseUrl:roxyFileman+'?type=image',
																removeDialogTabs: 'link:upload;image:upload'}); 
								});
							</script>
                            <?
					endif;
					?>		
					</td></tr>
				<?php
				break;
			case "date":
				?>
                <tr><th><?php  echo flags($fieldName, $_GET["table"], "colWebName") ?>
				<a href="#" class="help" title="<? echo flags($fieldName, $_GET["table"], "descr") ?>">?</a>
                </th><td colspan="2">
                  <input type="text" class="datepicker" id="<?php echo $fieldName?>" name="<?php echo $fieldName?>" value="<?php echo $result["$fieldName"]?>"  <?php echo restriction($fieldName, $_GET["table"])?> />
                  <script>
					$(function() {
					  $( "#<?php echo $fieldName?>" ).datepicker("setDate", "<?php echo $result["$fieldName"]?>" ); /* kvuli debilně navrženému jquery UI, který klidně smázne value */
					});
				  </script>
             	</td></tr>
                <?php	
				break;	
			case "time":
			?>
					<tr><th><?php echo  flags($fieldName, $_GET["table"], "colWebName") ?>
					<a href="#" class="help" title="<? echo flags($fieldName, $_GET["table"], "descr") ?>">?</a>
					</th><td colspan="2">
					<?php
			if (IsSet($result["$fieldName"])) 
				?>
				<!-- <select name="hour"><?php /* generateOption(0, 24, $hour) */ ?></select> hodin&nbsp;&nbsp;&nbsp;<select name="minut"><?php /* generateOption(00, 59, $minut, 5) */ ?></select> minut -->
				<input name="<?php  echo $fieldName ?>" value="<?php if (IsSet($result["$fieldName"])) echo $result["$fieldName"]; ?>" > Zadávat pouze ve formátu HH:MM
				<?php
			break;	
			?>		
					</td></tr>
				<?php
			case "timestamp":
			 	break;	
			default:
				if ($fieldName=="id") $hidden="class='hidden'" ;else $hidden ="";
				?>	
					<tr <?php echo $hidden ?>><th><?php echo  flags($fieldName, $_GET["table"], "colWebName") ?>
					<a href="#" class="help" title="<? echo flags($fieldName, $_GET["table"], "descr") ?>">?</a>					
					</th>
					<td colspan="2">
					<input class="input" type="text"  name="<?php  echo $fieldName ?>" id="<?php  echo $fieldName ?>" value="<?php echo $result["$fieldName"] ?>" <?php echo restriction($fieldName, $_GET["table"])?>>
					</td></tr>
				<?php
				break;
		endswitch;
	endwhile;
//-------------- relacni tabulky M-N
		$tables=MySQL_List_Tables($sql->dbName);
		for ($i=0; $i<@MySQL_Num_Rows($tables); $i++):
			$tableName=MySQL_TableName($tables, $i);
			$prefix=$_GET["table"]."_";
			if ($relTable=strstr($tableName, $prefix)):
				 $relTable=substr($relTable, strlen($prefix)); 
				 if($relTable=="flagsTables") $qRel=MySQL_Query("SELECT * FROM $relTable WHERE tableDbName NOT IN ($_ENV[sysTables]) ORDER BY 1 ASC");
				 //elseif($relTable=="xKeys") $qRel=MySQL_Query("SELECT * FROM $relTable ORDER BY 1 DESC");
				 else $qRel=MySQL_Query("SELECT * FROM $relTable ORDER BY 1 ASC");
				 echo "<tr><th style='vertical-align:top'>";
				 echo flags($relTable, $_GET["table"], "colWebName");
				 
				 
				 echo "</th><td>";
				 echo "<div>"; //style='width: 500px; height: 100px; overflow: auto'
				 while($rRel=MySQL_Fetch_Row($qRel)):
				 	$leftCol="id_".$_GET["table"];
					$rightCol="id_".$relTable;
					//echo "<p>SELECT * FROM $tableName WHERE (($leftCol='$id')AND($rightCol='$rRel[0]'))</p>"; 
				 	if ($_GET["id"]): 
						$qFind=MySQL_Query("SELECT * FROM $tableName WHERE (($leftCol='$_GET[id]')AND($rightCol='$rRel[0]'))");
						$checked=@MySQL_Num_Rows($qFind);
					endif;	
				 	?>
						<input type="checkbox" <?php if ($checked) echo "CHECKED" ?> name="<?php echo $relTable."[]" ?>" value="<?php echo $rRel[0]  ?>" <?php echo restriction($relTable, $_GET["table"])?> ><?php echo $rRel[1] ?><br>
					<?php
				 endwhile;
				 echo "</div></td></tr>";
			endif;	 	
		endfor;		
			if ($flagsTables["pdf"] || $flagsTables["img"]){
				echo "<table id='fixDocsTable'>";
				if(!$_GET["id"]){	
						echo "<tr><td class='pdf'><h2>Přidat externí soubory</h2></td></tr>";
						echo "<tr><td class='pdf'><input type='submit' class='formSubmit' value='Přidat soubory' name='extFiles'></td></tr>";	
				}else{
				  ?>
                        <tr><td class="pdf"><h2>Přidat externí soubory</h2></td></tr>
                        <tr><td class="pdf">Název souboru (nepovinné): <input type="text" name="insertedMediaTitle" id="insertedMediaTitle"></td></tr>
                        <tr><td class="pdf">Soubor můžete nahrát kliknutím na tlačítko nebo přetažením souboru sem.<div id="mediaFileUploader" style="width:100px">Nahrát soubor</div><div id="status"></div></td></tr>
                        <tr><td class="pdf" id="media">
                                <?php showMedia($_GET["table"], $_GET["id"], $rFlagsTables["id"]);?>
                        </td></tr> 
			<?php
				}//$_GET["id"]
				echo "<tr><td style='background-color:red;padding:0px'><a href='#'  id='resetWarnings' />Please, fill up the form's fields before uploading files.<br><strong>Click here for hiding
				 warning messages</strong></a></td></tr>";
				echo "</table>";
			} //$flagsTables["pdf"] || $flagsTables["img"]				
			?>
<!-- permanent - don't change --> 
			<tr class="noCss"><td class="noCss" colspan="2"><input type="submit" class="formSubmit" value="Uložit"></td></tr> 
             <? if($_GET["table"]=="xJoinedSchools"){?>
				  <script type="text/javascript">
                      $("#address").blur(function(){                  
                         // var address=$("#2015regionPlaces").val()+" "+$("#address").val();
						  var address=$("#address").val();
                          geocoder = new google.maps.Geocoder();
                          geocoder.geocode( { 'address': address}, function(results, status) {
                            if (status == google.maps.GeocoderStatus.OK) {
                               position=results[0].geometry.location;
                               $("#googleMapPosition").val(position);
                             } else {
                              alert('Geocode was not successful for the following reason: ' + status);
                             }	
                          });                  
                      });
                  
                  </script>
			<? }?>

			<input type="hidden" value="<?php echo $id ?>" name="id">
			<input type="hidden" value="<?php echo $_GET["page"] ?>" name="page">
			<input type="hidden" value="1" name="sent">
			<?php if((!$_POST["action"])&&($_GET["action"]!="update")):?>
				<input type="hidden" value="insert" name="action"> 
				<?php else: ?>
				<input type="hidden" value="update" name="action"> 
			<?php endif; ?>
<!-- end of permanent -->	
		</table>
</form>
<script>
/*$(document).ready(function(){
	$(".formSubmit").click(function(){
			CKEDITOR.instances.longDescr.updateElement();
	});
});*/
$.validate({
  validateOnBlur : false,/*
  errorMessagePosition : 'top',*/
  modules : 'security',
  onError : function() {
	  $("#resetWarnings").css("display", "block");
    },
  onModulesLoaded : function() {
    var optionalConfig = {
      fontSize: '12pt',
      padding: '4px',
      bad : 'Velmi slabé',
      weak : 'Slabé',
      good : 'Dobré',
      strong : 'Silné'
    };
    $('input[name="userPsswd"]').displayPasswordStrength(optionalConfig);
  }
});
$("#resetWarnings").click(function(){
	$('.form-error','#formTableItem').css("display","none");
	$('.error','#formTableItem').css("border","1px dotted gray");
	$("#resetWarnings").css("display", "none");
});
</script>
<?php
else:
	if($_GET["table"]=="rspages"):
		if(count($_ENV["userStartTreeArray"])){
                    foreach($_ENV["userStartTreeArray"] AS $parent){
                        echo "<p><a href='".$_SERVER['PHP_SELF']."?page=tableItem&amp;table=rspages&amp;parent=".$parent."&amp;action=insert'>Přidat stránku</?></p>";
                        echo "<div id='tree'>";		
							filesList($parent, "CZ"); 
						echo "</div>";	

                        echo "<hr>";	
                    }
                }else{
                	echo "<div id='tree'>";		
						filesList(0, "CZ"); 
					echo "</div>";	

                }
	else:	
		echo "<div><a id='buttonAdd' href='".$_SERVER['PHP_SELF']."?action=insert&amp;page=tableItem&amp;table=".$_GET["table"]."'> + vložit nový záznam</a></div>";
		if (!$_GET["orderCol"]) $orderCol="id"; else $orderCol=$_GET["orderCol"];
		if (!$_GET["start"]) $start=0; else $start=$_GET["start"];
		if (!$_GET["direction"]) $direction="ASC"; else $direction=$_GET["direction"];
		if ($_GET['limit']) $_SESSION['limit']=$_GET['limit']; else $_SESSION['limit']=20;
		if ($_GET["table"]=="xRegionPersons") $list_query="SELECT t.*, c.xRegionCities FROM xRegionPersons AS t INNER JOIN xRegionCities AS c ON t.id_xRegionCities = c.id ";
		if ($_GET["table"]=="xRegionTeamMembers") $list_query="SELECT t.*, c.xRegionCities  FROM xRegionTeamMembers  AS t INNER JOIN xRegionCities AS c ON t.id_xRegionCities = c.id ";
		if ($_GET["table"]=="xRegionScreenings") $list_query="SELECT t.*, f.xFilms, p.xRegionPlaces FROM xRegionScreenings AS t LEFT JOIN xFilms AS f ON t.id_xFilms=f.id LEFT JOIN xRegionPlaces AS p ON t.id_xRegionPlaces=p.id";
		if ($_GET["table"]=="xRegionEvents") $list_query="SELECT t.*, et.xRegionEventTypes, p.xRegionPlaces FROM xRegionEvents AS t  LEFT JOIN xRegionPlaces AS p ON t.id_xRegionPlaces=p.id LEFT JOIN xRegionEventTypes AS et ON t.id_xRegionEventTypes = et.id";
		if ($_GET["table"]=="xBrusselScreenings") $list_query="SELECT t.*, f.xBrusselFilms, p.xBrusselPlaces FROM xBrusselScreenings AS t LEFT JOIN xBrusselFilms AS f ON t.id_xBrusselFilms=f.id LEFT JOIN xBrusselPlaces AS p ON t.id_xBrusselPlaces=p.id";
		if ($_GET["table"]=="xBrusselViewers") $list_query="SELECT t.*, f.xBrusselFilms, p.xBrusselPlaces FROM xBrusselViewers AS t LEFT JOIN xBrusselScreenings AS s ON t.id_xBrusselScreenings = s.id LEFT JOIN xBrusselFilms AS f ON s.id_xBrusselFilms=f.id LEFT JOIN xBrusselPlaces AS p ON s.id_xBrusselPlaces=p.id";
        if ($_GET["table"]=="xFilmParams") $list_query="SELECT t.id, f.xFilms, t.descrCZ, t.descrEN FROM xFilmParams AS t INNER JOIN xFilms AS f ON t.id_xFilms = f.id";

        if (!IsSet($list_query)) $list_query="";
		generateList($list_query, $orderCol, $direction, $start, $_SESSION['limit'],$rFlagsTables["id"]);

        include_once("export.php");
		//echo "<p>&raquo;&nbsp;<a href='../php/filtered_data.php?table=$_GET[table]' target='_blank'>Export do souboru</a></p>";
	endif;	
endif;
?>
