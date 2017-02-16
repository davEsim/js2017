<div class="row">
	<div class="medium-12 columns">
		<?php
        $films = new xFilms($db, "xFilms");
        $filmThemes = new xFilmThemes($db, "xFilmThemes");
        $lang = $_ENV["lang"];
        
        //---- detail --------------------------------------------------------------------------
        if($itemId){
            $activeItem=$filmThemes->findById($itemId);
            echo "<div class='row'>";
                echo "<div class='medium-6 columns'>";
                echo getFirstMedia("xFilmThemes",$activeItem["id"], 0, "fancybox", "", "img", "", FALSE);
                echo "</div>";
                echo "<div class='medium-6 columns'>";
					echo "<h1>".$activeItem["name$lang"]."</h1>";
                    echo $activeItem["text$lang"]."<br/>";
                echo "</div>";
            echo "</div>";
			
			// ----- filmy k tématu
			?>
            <p class="section">
                <span><?=__("Filmy z kategorie")?> <?=$activeItem["name$lang"]?></span>
            </p>

            <?
			$results = $films->listingByTheme($activeItem["id"],"title$lang", "ASC", 0, 0);
			echo "<div class='row films listing'>";
			$i=0;
			foreach($results AS $result){
				if($result["title$lang"]){
					echo "<div class='medium-3 columns end'>\n";
								echo "<a href='".$films->getPath($result["id"], "filmy-a-z").string2domainName($result["title$lang"])."'>";
									echo "<img src='".modifyImgPathfromSB($result["imageUrl"],2)."'>";
									echo "<h2>".$result["title$lang"]."</h2>";
								echo "</a>";	
								echo "<p>".showStringPart($result["synopsys$lang"]," ",300)."</p>";
					echo "</div>\n";
					if(!(++$i % 4)) echo "</div>\n<div class='row listing'>";
				}
			}
			echo "</div>";

        
        //---- seznam --------------------------------------------------------------------------
        
        ?>
            <p class="section">
                <span><?=__("Další Tématické kategorie");?></span>
            </p> 
        <?
        }else{
            echo "<h1>".$metaTitle."</h1>";	
        }
        $results = $filmThemes->listing("","sequence", "ASC", 0, 0);
        echo "<div class='row films listing'>";
        $i=0;
        foreach($results AS $result){
				echo "<div class='medium-3 columns end'>\n";
							echo "<a href='".$filmThemes->getPath($result["id"])."'>";
                                echo getFirstMedia("xFilmThemes",$result["id"], 0, "fancybox", "", "img", "", FALSE);
								echo "<h2>".$result["name$lang"]."</h2>";
							echo "</a>";	
							echo "<p>".showStringPart($result["text$lang"]," ",200)."</p>";
				echo "</div>\n";
				if(!(++$i % 4)) echo "</div>\n<div class='row listing'>";
        }
        echo "</div>";
        ?>
	</div>
    
    <!--<div id="rightCol" class="medium-4 columns">
     	<? include_once("included/partials/cols/newsRightCol.php");?>
    </div>-->
</div>    