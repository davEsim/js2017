<style>
 .press img, .press figure{
	padding:0 !important;
	margin:0 !important; 
 }
 .press{
	padding-bottom:1em; 
 }

</style>
<?
if($_POST["pw"] == "press2016"){


	$lang = $_ENV["lang"];
	$table = "xPress";
	$idInTable = 1;
	
	$imgs=$db->queryAll("SELECT i.*, it.sequence FROM media AS i
						INNER JOIN mediaTables AS it ON i.id=it.id_media 
						INNER JOIN flagsTables as ft ON it.id_flagsTables=ft.id 
						WHERE ft.tableDbName='".$table."' 
						AND idInTable='".$idInTable."' 
						AND i.ext IN ('jpg','png', 'gif') 
						ORDER BY i.media ASC");
	?>
	<div class='row listing press'>
		<?
		$i=0;
		foreach($imgs AS $img){
			$path="../download/imgs/small/".$img["seo"];
			$pathFull="../download/imgs/".$img["seo"];
			$absPathFull=$_SERVER['DOCUMENT_ROOT']."/2016/download/imgs/".$img["seo"];
			list($width, $height, $type, $attr) = getimagesize($absPathFull);
			//print_r(getimagesize($pathFull));
			$titles = explode("/",$img["media"]);
			?>
			<div class='medium-3 columns end'>
				<figure>
					<a target="_blank" href="<?=$pathFull?>"><img src='<?=$path?>'></a>
					<figcaption>
						<a target="_blank" href="<?=$pathFull?>"><?=($lang == "CZ")? $titles[0]:$titles[1]?></a>
						<br /><?=$width?>px &times; <?=$height?>px
					</figcaption>    
				</figure>
			</div>
			<?
			if(!(++$i % 4)){
				?>
				</div><div class='row listing press'>
				<?
			}
		}
		?>
    </div><!--row-->
   <?
}else{
	?>
	<form method="post">
    	<?=__("Heslo")?>: <input name="pw" type="password" />
        <input class="button" type="submit" value="<?=__("Odeslat")?>" />
    </form>
    	
<?    
}
?>
