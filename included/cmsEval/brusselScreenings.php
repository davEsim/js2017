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
	.noPspace p{
		margin:0;
		padding:0;
		font-weight: 300;	
	}
</style>
<?
$lang = $_ENV["lang"];
//$regionPlaces = new xRegionPlaces($db, "xRegionPlaces");
$brusselScreenings = new xBrusselScreenings($db, "xBrusselScreenings");
//$regionScreeningsPlaces = $regionScreenings->places($regionCity);
//$regionScreeningsDays = $regionScreenings->days($regionCity);
$brusselScreeningsListing = $brusselScreenings->listingByDate();
if($lang == "CZ"){
	$resPath = "./brusel-registrace/";
	$filmPath = "./filmy-a-z/";
}else{
	$resPath = "./brussel-registration/";
	$filmPath = "./films-a-z/";
}
?>
<!--<div class="row">
	<div class="medium-6 columns regionsList">
    	<?
		foreach($regionScreeningsDays AS $regionScreeningsDay){
			echo "<a class='label filter' data-type='day' data-value='".$regionScreeningsDay["date"]."' data-city='$regionCity'>".invertDatumFromDB($regionScreeningsDay["date"],1)."</a>";
		}
		?>
    </div>
    <div class="medium-6 columns regionsList">
    	<?
		foreach($regionScreeningsPlaces AS $regionScreeningsPlace){
			echo "<a class='label filter' data-type='place' data-value='".$regionScreeningsPlace["id"]."' data-city='$regionCity'>".$regionScreeningsPlace["xRegionPlaces"]."</a>";
		}
		?>
    </div>
</div>
<div class="row paddingTop1" id="fullProgram">
	<div class="medium-12 columns text-center">
    	<p><a href="<?=$_ENV["host"].$_SERVER['REQUEST_URI']?>">zobrazit celý program</a></p>
    </div>
</div>
<div class="row">
	<div class="medium-12 columns">
    	<hr />
    </div>
</div>-->
<div class='row listing' id="regionScreeningsFilterAjaxContent">
	<div class="medium-12 columns">
        <table>
        <?
                $actualDate = "";
                foreach($brusselScreeningsListing AS $brusselScreening){
					$countOfViewers = $brusselScreenings->countOfViewers($brusselScreening["sid"]);
                    if($brusselScreening["date"]!=$actualDate){
                        $actualDate = $brusselScreening["date"];
                        ?>
                        </table>
                        <h2><?=invertDatumFromDB($brusselScreening["date"],1)?></h2>
                        <table>	
                    <?
                    }
                    ?>
                            <tr style="border:0 !important" >
                                <td class="time"><?=$brusselScreening["time"]?></td>
                                <td class="fullFilmTitle" width="200px">
                                	<?
                                    	if ($brusselScreening["block"])echo "<div class='extraScreeningTitle'>".$brusselScreening["block"]."</div>";
									?>
                                	<a class="filmTitle filmDetailBrussel" data-filmId="<?=$brusselScreening["fid"]?>" data-screenId="<?=$brusselScreening["sid"]?>" data-lang="<?=$_ENV["lang"]?>"><?=$brusselScreening["title$lang"]?></a>
                                </td>
                                <!--<td>
                                	<?
                                    	if ($brusselScreening["debate$lang"]){
											echo "<span data-tooltip aria-haspopup='true' class='has-tip' title='".$brusselScreening["debate$lang"]."'><em class='fi-plus'></em>&nbsp;".__("Debata")."</span>";
										}
									?>
                                </td>-->
                                <td>

                                	<div class="credits">
                                    	<a target="_blank" href="<?=$brusselScreening["url"]?>"><?=$brusselScreening["xBrusselPlaces"]?></a>
                                    	<br /><?=$brusselScreening["address"]?>
									</div>
									<?
                                        if($brusselScreening["resvExtraInfo$lang"]){?>
                                            <div class="tiny alert label"><?=$brusselScreening["resvExtraInfo$lang"]?></div> 
                                    <? }?> 
                                </td>
                                <td width="100px">
                                <?	
									if($brusselScreening["sid"] == 1){?>
										<a target="_blank" href="http://www.bozar.be/en/activities/112226-opening-one-world-brussels" class="tiny radius label" ><?=__("vstupenky")?></a>
                                <?        
									}elseif($brusselScreening["sid"] == 13){?>
										<a target="_blank" href="http://www.bozar.be/en/activities/112296-vaclav-havel-a-life-in-freedom---andrea-sedlackova" class="tiny radius label" ><?=__("vstupenky")?></a>
								<?	}elseif($countOfViewers >= $brusselScreening["countOfViewers"]){?>
										<span class="tiny radius alert label" ><?=__("obsazeno")?></span>
								<? 	}else{?>
                                		<a class="tiny radius success button" href="<?=$resPath.$brusselScreening["sid"]?>"><?=__("rezervace")?></a>
                                <?	}?>  
                                </td>
                            </tr>
                            <tr style="border:0 !important" class="filmDetailContent" id="s<?=$brusselScreening["sid"]?>">
                            	<td colspan="5">
                                	<div class="ajaxContent">
                                    </div>
                                	<p>
                                    <? if($brusselScreening["fid"] != 99999) {?>
                                    	<a href="#" data-reveal-id="videoModal" class="tiny radius button"><?=__("trailer")?></a>
                                    	<a class='tiny radius button' href='<?=$filmPath.$brusselScreening["fid"]."-".string2domainName($brusselScreening["xBrusselFilms"])?>'><?=__("více o filmu")?></a>
									<? }?>
                                   
                                    </p>
                                </td>
                            </tr>
                            <tr>
                            	<td></td><td></td>
                            	<td colspan="3" class="noPspace">
                                	
                                	<?
                                    	if ($brusselScreening["debate$lang"]){
											echo "<strong>".__("Debata")."</strong><br />";
											echo $brusselScreening["debate$lang"];
										}
									?>
                                </td>
                            </tr>

                    <?	
                }
        ?>
        </table>
	</div>
</div><!--row-->
