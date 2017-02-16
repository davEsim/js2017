
<?
if($_POST):
	$query="SELECT max(position) AS max FROM tree WHERE parent='$_POST[newParent]'";
	$rMax=MySQL_Fetch_Array(MySQL_Query($query));
	$newPosition=$rMax["max"]+1;
	$query="UPDATE tree SET parent='$_POST[newParent]', position='$newPosition' WHERE id_page='$_POST[id]'";
	$q=MySQL_Query($query);
	if($q) echo "<p>Změna provedena. <br>&raquo;&nbsp;<a href='".$_SERVER['PHP_SELF']."?page=pages'>Návrat na seznam stránek</a></p>";else echo "<p>Nové zařazení stránky se nezdařilo, zkuste celý proces znovu</p>";
elseif($_GET["newParent"]):
	echo "<p>Opravdu chcete stránku <strong>".urldecode($_GET["pageName"])."</strong> i s podstránkami, zařadit pod stránku <strong>".urldecode($_GET["parentName"])."</strong>?</p>";
	?>
		<form method="post">
			<input type="submit" value="Ano, zařadit">
			<input type="hidden" name="id" value="<? echo $_GET["id"] ?>">
			<input type="hidden" name="newParent" value="<? echo $_GET["newParent"] ?>">
		</form>
		<p><a href="<? $_SERVER['PHP_SELF']?>?page=pages">Ne, vrátit se na seznam stránek</a></p>
	<?
else:
	echo "<p>Klikněte na stránku, pod kterou chcete zobrazovat stránku <strong>".urldecode($_GET["name"])."</strong> (včetně podstránek).</p>";

	filesListMove(0);   
endif;
?>

