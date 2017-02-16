<style>
	#fullProgram{
		display:none;	
	}
	.listing table{
		border:0px;	
	}
		.listing table td.time{
			padding-left:0;	
		}
	.filmTitle{
		/*font-size:1.1em;*/
		font-weight:400;
	}
	.has-tip{
		font-weight:400;	
	}
	
	#regionScreeningsFilterAjaxContent table{
		border:0;
		border-collapse:collapse;
		width:100%;
	}
		#regionScreeningsFilterAjaxContent tr{
			background-color:white;
			border-bottom: 1px dotted #ddd;
		}
			#regionScreeningsFilterAjaxContent tr .blockTable tr{
				border:0;
			}
			#regionScreeningsFilterAjaxContent tr.active{
				border:0px;
				background-color:#eee;
			}
				#regionScreeningsFilterAjaxContent tr.active span.filmTitle{
					font-size:1.3em;
					font-weight:bold;	
				}
		#regionScreeningsFilterAjaxContent td{
			vertical-align:top;
			text-align:left;	
			padding-left:0;
			font-size:1em;
			font-weight:300;
		}
		.time{
			width:50px;
		}
		#regionScreeningsFilterAjaxContent td td{
			padding-left:0;	
		}
		#regionScreeningsFilterAjaxContent .extraScreeningTitle{
			text-transform:uppercase;
			/*font-weight:bold;	*/
		}
		#regionScreeningsFilterAjaxContent span.label{
			text-transform: uppercase !important;	
		}
	.tabs-content{
		min-height:500px;	
	}
	
	.filmDetailContent{
		display:none;
	}
		.filmDetailContent p, .filmDetailContent h3{
			margin-left:50px;
		}
		#regionScreeningsFilterAjaxContent tr.filmDetailContent {
			background-color:#eee;
		}
		.filmDetailContent img{
			float:right;
			margin-left:3em;
			max-width:250px;
		}
		.filmDetailContent p{
			font-size:1em;
		}
		.filmDetailContent .button{
			margin:0 !important;
		}

</style>
<?
$lang = $_ENV["lang"];
//$regionPlaces = new xRegionPlaces($db, "xRegionPlaces");
$regionScreenings = new xRegionScreenings($db, "xRegionScreenings");
$regionCities = new xRegionCities($db, "xRegionCities");
$regionCities = $regionCities->listing("", "xRegionCities", "ASC", 0, 0);
$regionScreeningsDays = $regionScreenings->allDays($regionCity);
$today = date("Y-m-d");
if($today < "2016-03-17" || $today > "2016-04-16") $date = "2016-03-17"; else $date = $today;
$regionScreeningsListing = $regionScreenings->allListingByDate($date);
if($lang == "CZ"){
	$filmPath = "./filmy-a-z/";
}else{
	$filmPath = "./films-a-z/";
}

?>
<div class="row">
	<div class="medium-12 columns">
   		<h2>Program v regionech</h2>
    </div>
</div>
<div class="row">
	<div class="medium-6 columns regionsList">
    	<?
		foreach($regionScreeningsDays AS $regionScreeningsDay){
			echo "<a class='label filter' data-type='day' data-value='".$regionScreeningsDay["date"]."'>".czechFullDayNameFromDate($regionScreeningsDay["date"])." ".invertDatumFromDB($regionScreeningsDay["date"],1)."</a>";
		}
		?>
    </div>
    <div class="medium-6 columns regionsList">
    	<?
		foreach($regionCities AS $regionCity){
			echo "<a class='label filter' data-type='city' data-value='".$regionCity["xRegionCities"]."'>".$regionCity["xRegionCities"]."</a>";
		}
		?>
    </div>
</div>
<div class="row paddingTop1" id="fullProgram">
	<div class="medium-12 columns text-center">
    	<p><a href="<?=$_ENV["host"].$_SERVER['REQUEST_URI']?>"><?=__("zobrazit celý program")?></a></p>
    </div>
</div>
<div class="row">
	<div class="medium-12 columns">
    	&nbsp;
    </div>
</div>
<div class='row listing' id="regionScreeningsHomeFilterAjaxContent">
	<div class="medium-12 columns">
        <table>
        <?
                $actualDate = $lastBlock = "";
                foreach($regionScreeningsListing AS $regionScreening){
                    if($regionScreening["date"]!=$actualDate){
                        $actualDate = $regionScreening["date"];
						
                        ?>
                        </table>
                        <h3><?=czechFullDayNameFromDate($regionScreening["date"])." ".invertDatumFromDB($regionScreening["date"],1)?></h3>
                        <table>	
                    <?
					}
					$showTimeAndBlock = TRUE;
					if($regionScreening["block"]){
						if($lastBlock != $regionScreening["block"]){
							$lastBlock = $regionScreening["block"];					
						}else{
							$showTimeAndBlock = FALSE;	
						}
					}
                    ?>
                            <tr>
                                <td class="time"><?=($showTimeAndBlock)? $regionScreening["time"] : ""?></td>
                                <td class="fullFilmTitle">
                                	<?
                                    	if ($regionScreening["block"] && $showTimeAndBlock)echo "<div class='extraScreeningTitle'>".$regionScreening["block"]."</div>";
									?>
                                	<a class="filmTitle filmDetailRegion" data-filmId="<?=$regionScreening["fid"]?>" data-screenId="<?=$regionScreening["sid"]?>" data-lang="<?=$_ENV["lang"]?>"><?=$regionScreening["title$lang"]?></a>
                                </td>
                                <td>
                                	<?
                                    	if ($regionScreening["debate"]){
											echo "<span data-tooltip aria-haspopup='true' class='has-tip' title='".$regionScreening["debate"]."'>+&nbsp;Debata</span>";
										}
									?>
                                </td>
                                <td><span class="credits"><a target="_blank" href="<?=$regionScreening["url"]?>"><?=$regionScreening["xRegionPlaces"]?></a>, <?=$regionScreening["address"]?>
								<!--<?=($regionScreening["tel"])?", Tel.: ".$regionScreening["tel"]:""?>--></span></td>
                            </tr>
                            <tr class="filmDetailContent" id="s<?=$regionScreening["sid"]?>">
                            	<td colspan="6">
                                	<div class="ajaxContent">
                                    </div>
                                	<p>
                                    	<a class='tiny radius button' href='<?=$filmPath.$regionScreening["fid"]."-".string2domainName($regionScreening["xFilms"])?>'><?=__("více o filmu")?></a>
                                    </p>
                                </td>
                            </tr>

                    <?	
                }
        ?>
        </table>
	</div>
</div><!--row-->
<script type="text/javascript">
	$(document).ready(function(){
		$(".filter").on("click",function(event){ 
			event.preventDefault();
			//$("#fullProgram").css("display", "block");
			$('html, body').animate({
				scrollTop: ($("#elementtoScrollToID").offset().top-100)
			 }, 2000);
	
			
			type = $(this).attr("data-type");
			value = $(this).attr("data-value");
			lang = "<?=$lang?>";
	
			$.ajax({
				url:'../included/ajax/regionScreeningHomeFilter.php', 
				data:{type:type, value:value,lang:lang},
				type:'GET',  
				dataType: 'html',
				beforeSend: function(){
					$("#regionScreeningsHomeFilterAjaxContent").append("<div class='ajaxLoading'><img src='imgs/ajax-loader.gif'> Loading...</div>").show(1000);
				},
				success: function(html, textSuccess){
					$("#regionScreeningsHomeFilterAjaxContent").html(html);
					
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