<?php
include_once("./php/mysql.class.php");
include_once("./php/connection.php");  
include_once("./php/funcs.php");
?>
<?
if ($_GET["action"]=="stepmove"):
	MySQL_Query("UPDATE tree SET position=0 WHERE parent='".intval($_GET["parent"])."' AND position='".intval($_GET["position"])."'");
	MySQL_Query("UPDATE tree SET position='".intval($_GET["position"])."' WHERE parent='".intval($_GET["parent"])."' AND position='".intval($_GET["newposition"])."'");
	MySQL_Query("UPDATE tree SET position='".intval($_GET["newposition"])."' WHERE parent='".intval($_GET["parent"])."' AND position=0");
endif;
if($_GET["action"]=="delete"){
  MySQL_Query("DELETE FROM rspages WHERE id='".intval($_GET["id"])."'");
  MySQL_Query("DELETE FROM tree WHERE id_page='".intval($_GET["id"])."'");
  MySQL_Query("UPDATE tree SET position=position-1 WHERE parent=".intval($_GET["parent"])." AND position>".intval($_GET["position"])."");
}
/*
if(count($_ENV["userStartTreeArray"])){
	foreach($_ENV["userStartTreeArray"] AS $parent){
		echo "<p><a href='".$_SERVER['PHP_SELF']."?page=tableItem&amp;table=rspages&amp;parent=".$parent."&amp;action=insert'>Přidat stránku</?></p>";
		filesList($parent);
		echo "<hr>";	 
	}
}else{*/
echo "<div id='tree'>";		
	filesList(0, "CZ"); 
echo "</div>";	
//}
?>
