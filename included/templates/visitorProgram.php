<style>
	.button.tiny{
		padding:.5em;	
	}

	.visitorProgramTable{
		border:0px;	
		width:100%;
	}
		.visitorProgramTable tr{
			background-color:white !important;	
		}
			.visitorProgramTable h2, .visitorProgramTable h3{
				margin-top: 0;
				padding-top: 0;
				line-height:1em;	
			}
			.visitorProgramTable td{
				vertical-align:top !important;	
			}
	.visitorProgramDay{
		background-color:#e2e2e2;
	}
		.visitorProgramDay p{
			/*font-size:1.5em;*/
		}
	.visitorProgramFilms{
		border-bottom:1px solid #e2e2e2;
	}
		.visitorProgramFilms p{
			margin:0;
			clear:both;
		}
		.visitorProgramFilms img{
			max-width:200px;
			margin-right:1em;
			margin-bottom:1em;
			float:left;
		}
	.visitorProgramFilms table{
		border:0px;	
	}
		
.addeventatc, .addeventatc:hover{
	
	font-size:.8em;
	border:0;	
}
</style>

<?
$lang = $_ENV["lang"];
if($_SESSION['userId']){
	
	if($itemId){
		$params = array(
						":userId"	=> $_SESSION['userId'],
						":delId"	=> $itemId
						
						);
		$db->query("DELETE FROM visitorsProgram WHERE id_visitors = :userId AND id_xScreenings = :delId", $params);	
	}
	
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
    	<button class="small button radius noPrint" onclick=" window.print();"><b class="fi-print"></b> Vytisknout program</button>
        <table class="visitorProgramTable">
        <?      
		$lastDate="";                      							
        foreach($visitorScreenings AS $visitorScreening){
			if($visitorScreening["date"]!=$lastDate){
			?>
            <tr><td colspan="5"><hr /></td></tr>
            
          	<?
			}
			?>
            <tr>
                <td nowrap="nowrap">
					<h2><?
                    	if($visitorScreening["date"]!=$lastDate){ 
							echo invertDatumFromDB($visitorScreening["date"],1);
							$lastDate=$visitorScreening["date"];
						}
					?></h2>
                </td>
                <td nowrap="nowrap"><?=substr($visitorScreening["time"],0,-3)?></td>
                <td><img src="<?=modifyImgPathfromSB($visitorScreening["imageUrl"],3)?>"/></td>
                <td>
                	<h3><?=$visitorScreening["title$lang"]?></h3>
                	<p><?=showStringPart($visitorScreening["synopsys$lang"], " ",200)?></p>
                </td>
                <td class="noPrint">
                	<a class="tiny button  alert" href="<?=$_ENV["serverPath"].$_ENV['page']?>/<?=$visitorScreening["id_xScreenings"]?>"><b class="fi-x"></b> <?=("Odebrat")?></a>
                </td>
            </tr>
            <?		
        }?>
        </table>
    <?
}else{
	echo "<p>Nejste bohužel přihlášen(a).</p>";
}


?>
<!--
<table class="visitorProgramTable">
<?
$festivalDays = range(7,16,1);	

foreach($festivalDays AS $festivalDay){
	$day = "03/".str_pad($festivalDay,2,0,STR_PAD_LEFT)."/2016";
	$day = new DateTime($day);	
	$festivalDayName = date_format($day, 'l'); 
	?>
    <tr>
        <td class="visitorProgramDay">
            <p><strong><?=$festivalDay?> . 3.</strong><br/>
            <?=czechFullDayName($festivalDayName)?></p>
        </td>
        <td class="visitorProgramFilms">
        	<table>
            	<tr>
                	<td>
                        <a href=""><img src="http://www.jedensvet.cz/2015/graphics/filmPhotos/w200/1756.jpg">Bob Marley se vrací domů</a><br />
                        17:30 | Ponrepo    
                        
                        <br />
                        <?
							$minutes_to_add = 80;
							$filmStart = new DateTime("2015-10-12");
							$filmStart->setTime(17,30);
							echo date_format($filmStart, 'Y-m-d H:i:s')."<br>"; 
							$filmStart->add(new DateInterval('PT' . $minutes_to_add . 'M'));
							echo date_format($filmStart, 'Y-m-d H:i:s'); 
						?>                                               
                	</td>
                    <td>
                        <div title="Add to Calendar" class="addeventatc">
                            Přidat do kalendáře
                            <span class="start">12/14/2015 09:00 AM</span>
                            <span class="end">12/14/2015 11:00 AM</span>
                            <span class="timezone">Europe/Paris</span>
                            <span class="title">Summary of the event</span>
                            <span class="description">Description of the event<br>Example of a new line</span>
                            <span class="location">Location of the event</span>
                            <span class="organizer">Organizer</span>
                            <span class="organizer_email">Organizer e-mail</span>
                            <span class="facebook_event">https://www.facebook.com/events/703782616363133</span>
                            <span class="all_day_event">false</span>
                            <span class="date_format">MM/DD/YYYY</span>
                        </div> 
                    	<div class="tiny button  alert"><b class="fi-x"></b> Odebrat</div>
                    </td>
                </tr>
                <? if ($festivalDay!=9 && $festivalDay!=12){?>
            	<tr>
                	<td>
               			<a href=""><img src="http://www.jedensvet.cz/2015/graphics/filmPhotos/w200/590.jpg">Bojovníci ze severu </a><br />
                        18:30 | Světozor VS 
               		</td>
                    <td>
                        <div title="Add to Calendar" class="addeventatc">
                            Přidat do kalendáře
                            <span class="start">12/14/2015 09:00 AM</span>
                            <span class="end">12/14/2015 11:00 AM</span>
                            <span class="timezone">Europe/Paris</span>
                            <span class="title">Summary of the event</span>
                            <span class="description">Description of the event<br>Example of a new line</span>
                            <span class="location">Location of the event</span>
                            <span class="organizer">Organizer</span>
                            <span class="organizer_email">Organizer e-mail</span>
                            <span class="facebook_event">https://www.facebook.com/events/703782616363133</span>
                            <span class="all_day_event">false</span>
                            <span class="date_format">MM/DD/YYYY</span>
                        </div> 
                        <div class="tiny button  alert"><b class="fi-x"></b> Odebrat</div>
                	</td>
                </tr>
                <? } ?>
            </table>
        </td>
    </tr>
    <?	
}
?>
</table>-->

