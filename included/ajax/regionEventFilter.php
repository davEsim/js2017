<?
session_start();
include_once("../../php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once("../../php/connection.php");


$_ENV["lang"]= $lang = $_GET["lang"];


if($_GET["type"]=="type"){
	
	$type = $_GET["value"];
	$regionCity = urldecode($_GET["city"])."%";
	$params = array(":regionCity" => $regionCity, ":type" => $type);
	$filteredEvents = $db->queryAll("	SELECT *, t.id AS eid FROM xRegionEvents AS t
									INNER JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									LEFT JOIN xRegionEventTypes AS et
									ON t.id_xRegionEventTypes = et.id
									WHERE p.xRegionPlaces LIKE :regionCity
									AND t.id_xRegionEventTypes = :type
									ORDER BY datumFrom ASC"
											, $params);
											
													
}else{
	//echo "jedu z load";
}

if(count($filteredEvents)){
	if($_GET["type"]=="place"){?>
    	<h2><a target="_blank" href="<?=$place["url"]?>"><?=$place["xRegionPlaces"]?></a></h2>
        <p><?=$place["address"]?>, Tel: <?=$place["tel"]?></p>
	<?
    }
	?>
    <div class="medium-12 columns">
    	<div class="row">
			<?
                $i=0;
                
                foreach($filteredEvents AS $filteredEvent){
                        echo "<div class='medium-4 columns end'>\n";
                                    //echo getFirstMedia("xNews", $event["id"], 0, "", "", "img", "");
                                    echo "<label class='secondary label'>".$filteredEvent["xRegionEventTypes$lang"]."</label>";									
                                    echo "<h4><a href='http://www.jedensvet.cz/2016/".string2domainName(urldecode($_GET["city"]))."-doprovodne-akce/".$filteredEvent["eid"]."-".string2domainName($filteredEvent["title"])."'>".$filteredEvent["title"]."</a></h4>";
                                    echo "<p>".showItemDateFromTo($filteredEvent["datumFrom"], $filteredEvent["datumTo"]);
										if($filteredEvent["time"]) echo " | ".$filteredEvent["time"]."h.";
									echo "</p>";
									echo "<p>".substr($filteredEvent["xRegionPlaces"],strpos($filteredEvent["xRegionPlaces"],":")+1)."<br>".$filteredEvent["address"]."</p>";
                                    //echo "<hr />";
                        echo "</div>\n";
                        if(!(++$i % 3)) echo "<hr /></div>\n<div class='row listing'>";
                }
            ?>
    	</div><!--row-->
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