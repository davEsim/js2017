<?
session_start();
include_once("../../php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once("../../php/connection.php");

$_ENV["lang"] = $lang = $_GET["lang"];
if($_SESSION['userId']){
	$params = array($_SESSION['userId'], $_GET["screeningId"]);
	$r = $db->query("SELECT * FROM visitorsProgram WHERE id_visitors=? AND id_xScreenings=?", $params);
	if($r){
		echo "<p>Tuto projekci již ve svém programu máte.</p>";
	}else{
		$db->query("INSERT INTO visitorsProgram VALUES(?,?)", $params);
	}
	// uzivatel prihlasen a ma minimalne jeden film ve svem programu...tak ho krute zobrazim :-)
	$params = array($_SESSION['userId']);
	$visitorScreenings = $db->queryAll("SELECT * FROM visitorsProgram AS vp
								INNER JOIN xScreenings AS s
								ON vp.id_xScreenings=s.id
								INNER JOIN xFilms AS f
								ON s.id_xFilms=f.id
								WHERE id_visitors=?
								ORDER BY s.date ASC, s.time ASC"
								, $params);
	?>
    <div style="max-height:600px; overflow:auto">
        <table>
        <?                            							
        foreach($visitorScreenings AS $visitorScreening){
            ?>
            <tr>
                <td><?=invertDatumFromDB($visitorScreening["date"],1)."<br/>".substr($visitorScreening["time"], 0, -3)?></td>
                <td><img src="<?=$visitorScreening["imageUrl"]?>" width="150px"/></td>
                <td><?=$visitorScreening["title$lang"]?><br /></td>
            </tr>
            <?		
        }?>
        </table>
    </div>
    <?
}else{
	echo "<p>".__("Nejste bohužel přihlášen(a)")."</p>";
}
?>
