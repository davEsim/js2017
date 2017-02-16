<?php 
// ----- globální konfigurace --------------------------------------------------------------------------------------------------------------
$_ENV["userIsAdmin"]=false; // je uživatel admin...
$_ENV["userAllowedTablesArray"]=array(); // všechny moduly uživatele
$_ENV["userAllowedTablesIN"]=""; // všechny moduly uživatele pro IN sql
$_ENV["userCanThisTable"]=false; // muže uživatel do aktuálního modulu...
$_ENV["userGroupsArray"]=array(); // skupiny uživatele
$_ENV["userGroupsIN"]=""; // skupiny uživatele pro IN sql
$_ENV["userStartTreeArray"]=array(); // zacátky stromu stránek uživatele
$_ENV["userRightsError"]=""; // kontrola práv uživatele
$_SESSION["userStartTree"]=0; // kde zacina strom stranek
// je uživatel ADMIN?
$q=MySQL_Query("SELECT * FROM users_groups WHERE id_users='$_SESSION[userId]' AND id_groups='0'"); 
if(MySQL_Num_Rows($q)==1){
	 //echo "jsem admin"; nerešim strom regionu a nasttavim na 11
	 $_ENV["userIsAdmin"]=true;
	 $_ENV["userStartTree"]=11; 
}else{
	//echo "nejsem admin"; rešim strom regionu
	$q=MySQL_Query("SELECT * FROM users_groups WHERE id_users='$_SESSION[userId]'"); 
	$r=MySQL_Fetch_Array($q);
	$qStartTree=MySQL_Query("SELECT id_rspages FROM groups WHERE id='".$r["id_groups"]."'");
	$rStartTree=MySQL_Fetch_Array($qStartTree);
	$_SESSION["userStartTree"]=$rStartTree["id_rspages"];
}
if($_ENV["userIsAdmin"]==false){ 
	// všechny moduly uživatele
	$q=MySQL_Query("SELECT  GROUP_CONCAT(tableDbName) AS userFlagsTables FROM users_groups AS ug INNER JOIN groups_flagsTables AS gf ON ug.id_groups=gf.id_groups LEFT JOIN flagsTables AS ft ON gf.id_flagsTables=ft.id WHERE ug.id_users='$_SESSION[userId]'"); //HAVING modulId='$rFlagsTables[id]'
	$r=MySQL_Fetch_Array($q); 
	$_ENV["userAllowedTablesArray"]=explode(",",$r["userFlagsTables"]);
	$_ENV["userAllowedTablesIN"]=implode("','",$_ENV["userAllowedTablesArray"]);
	// muže uživatel do aktuálního modulu?
	if(in_array($_GET["table"],$_ENV["userAllowedTablesArray"])) $_ENV["userCanThisTable"]=true; else $_ENV["userRightsError"]="You have no rights to entry this section.";
	// muže uživatel editovat tuto položku v aktuálním modulu?
	if($_ENV["userCanThisTable"]==true && isset($_GET["id"]) && $_GET["table"]!= "rspages"){
		$rFlagsTable=MySQL_Fetch_Array(MySQL_Query("SELECT id FROM flagsTables WHERE tableDbName='".mysql_real_escape_string($_GET["table"])."'"));
		$q=MySQL_Query("SELECT id FROM logs WHERE id_user='$_SESSION[userId]' AND id_item='".intval($_GET["id"])."' AND id_flagsTables='$rFlagsTable[id]'");
		if(!MySQL_Num_Rows($q)) $_ENV["userRightsError"]="You have no rights to edit this item."; 	
	}
	// všechny skupiny a trees uživatele
	$q=MySQL_Query("SELECT GROUP_CONCAT(g.id) AS groups,GROUP_CONCAT(g.id_rspages) AS rspages FROM users_groups AS ug LEFT JOIN groups AS g ON ug.id_groups=g.id WHERE id_users='$_SESSION[userId]'"); 
	$r=MySQL_Fetch_Array($q);
	$_ENV["userGroupsArray"]=explode(",",$r["groups"]);
	$_ENV["userGroupsIN"]=implode("','",$_ENV["userGroupsArray"]);
	$_ENV["userStartTreeArray"]=explode(",",$r["rspages"]);
}
// ----- globální konfigurace --------------------------------------------------------------------------------------------------------------
?>
