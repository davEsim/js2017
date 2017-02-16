<?
session_start();
include_once("../../php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once("../../php/connection.php");

$_ENV["lang"]= $lang = $_GET["lang"];
if($lang == "CZ"){
	$filmPath = "./filmy-a-z/";
}else{
	$filmPath = "./films-a-z/";
}


if($_GET["type"]=="day"){
	
	$date = $_GET["value"];
	$params = array(":date" => $date, ":lang" => $lang);
	$filteredScreenings = $db->queryAll("	SELECT *, t.time AS ttime, t.id AS sid, f.id AS fid, f.xFilms FROM xRegionScreenings AS t
											LEFT JOIN xFilms AS f
											ON t.id_xFilms = f.id
											LEFT JOIN xRegionPlaces AS p
											ON t.id_xRegionPlaces = p.id
											WHERE t.date LIKE :date
											AND t.lang LIKE :lang
											ORDER BY ttime ASC"
											, $params);
											
												
}elseif($_GET["type"]=="city"){
	
	$city = urldecode($_GET["value"]);
	$params = array(":city" => $city."%", ":lang" => $lang);	
	$filteredScreenings = $db->queryAll("	SELECT *, f.id AS fid, t.id AS sid FROM xRegionScreenings AS t
											LEFT JOIN xFilms AS f
											ON t.id_xFilms = f.id
											LEFT JOIN xRegionPlaces AS p
											ON t.id_xRegionPlaces = p.id
											WHERE  p.xRegionPlaces LIKE :city
											AND t.lang LIKE :lang
											ORDER BY t.date ASC, t.time ASC"
											, $params);
	
}else{
	//echo "jedu z load";
}

if(count($filteredScreenings)){?>
    <div class="medium-12 columns">
	<?
	if($_GET["type"]=="city"){?>
    		<h2><?=$city?></a></h2>
	<?
    }
	?>
	<table>
	<?
			$actualDate = "";
			foreach($filteredScreenings AS $filteredScreening){
				if($filteredScreening["date"]!=$actualDate){
					$actualDate = $filteredScreening["date"];
					?>
                	</table>
					<h3><?=czechFullDayNameFromDate($filteredScreening["date"])." ".invertDatumFromDB($filteredScreening["date"],1)?></h3>
                    <table>	
				<?
                }
				?>
						<tr>
                        	<td class="time"><?=$filteredScreening["time"]?></td>
                                <td class="fullFilmTitle">
                                	<?
                                    	if ($filteredScreening["block"])echo "<div class='extraScreeningTitle'>".$filteredScreening["block"]."</div>";
									?>
                                	<a class="filmTitle filmDetailRegion" data-filmId="<?=$filteredScreening["fid"]?>" data-screenId="<?=$filteredScreening["sid"]?>" data-lang="<?=$_ENV["lang"]?>"><?=$filteredScreening["title$lang"]?></a>
                                </td>
                                <td>
                                	<?
                                    	if ($filteredScreening["debate"]){
											echo "<span data-tooltip aria-haspopup='true' class='has-tip' title='".$filteredScreening["debate"]."'>+&nbsp;Debata</span>";
										}
									?>
                                </td>
                            
                            <td><? //if($_GET["type"]=="day"){?>
                            		<span class="credits"><a target="_blank" href="<?=$filteredScreening["url"]?>"><?=$filteredScreening["xRegionPlaces"]?></a>
                                    , <?=$filteredScreening["address"]?><?=($filteredScreening["tel"])?", Tel.: ".$filteredScreening["tel"]:""?></span>
                                <? //}?>    
                           </td>
                        </tr>
                        <tr class="filmDetailContent" id="s<?=$filteredScreening["sid"]?>">
                            <td colspan="6">
                                <div class="ajaxContent">
                                </div>
                                <p>
                                    <a class='tiny radius button' href='<?=$filmPath.$filteredScreening["fid"]."-".string2domainName($filteredScreening["xFilms"])?>'><?=__("více o filmu")?></a>
                                </p>
                            </td>
                        </tr>

                <?	
			}
	?>
    </table>
    </div>
	<?
}
?>
<script>
$(document).ready(function(){
	// film short detail region //////////////////////////////////////////////////////////////////////
	$(".filmDetailRegion").click(function(event){ 
		event.preventDefault();
		$(".filmDetailContent").slideUp();
		$("tr").removeClass("active");
		$(".filmTitle").fadeIn("");
		filmId = $(this).attr("data-filmId");
		screenId = $(this).attr("data-screenId");
		lang = "<?=$lang?>";

		var tr = $(this).parent().parent();
		$("#s"+screenId).css("display","table-row");
		//$(this).replaceWith( "<span class='filmTitle'>" + $(this).text() + "</span>" );
		$(this).fadeOut();
		tr.addClass("active");
		$.ajax({
			url:'../included/ajax/filmDetail.php', 
			data:{filmId:filmId, screenId:screenId, lang:lang},
			type:'GET',  
			dataType: 'html',
			beforeSend: function(){
				$("#s"+screenId+" .ajaxContent").append("<div class='ajaxLoading'><img src='imgs/ajax-loader.gif'> Loading...</div>").show(1000);
			},
			success: function(html, textSuccess){
				$("#s"+screenId+" .ajaxContent").html(html);
				
			},
			complete: function(){
			},
			error: function(xhr, textStatus, errorThrown){	
				alert("Nastala chyba "+errorThrown);
			}
		});
	});
});	
</script>