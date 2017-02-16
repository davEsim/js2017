<div class="row">
	<div class="medium-8 columns">
		<?php
        $news = new xNews($db, "xNews");
        $lang = $_ENV["lang"];
        
        //---- detail --------------------------------------------------------------------------
        if($itemId){
            $activeItem=$news->findById($itemId);
            echo "<div class='row'>";
                echo "<div class='medium-12 columns'>";
                    echo "<h1>".$activeItem["title$lang"]."</h1>";
					echo "<div class='addthis_sharing_toolbox'></div>";
                    echo getFirstMedia("xNews",$activeItem["id"], 1, "fancybox", "", "img", "", FALSE);
                    echo $activeItem["text$lang"]."<br/>";
                    //showItemDocs("xNews",$activeItem["id"]);
                echo "</div>";
            echo "</div>";
        
        //---- seznam --------------------------------------------------------------------------
        
        ?>
            <p class="section">
                <span>Další novinky</span>
            </p>
        <?
        }else{
            echo "<h1>".$metaTitle."</h1>";	
        }
        $results = $news->listing(" id_xRegionCities = 0","id", "DESC", 0, 0);
        echo "<div class='row listing'>";
        $i=0;
        foreach($results AS $result){
			if($result["title$lang"]){
				echo "<div class='medium-6 columns'>\n";
							echo getFirstMedia("xNews", $result["id"], 0, "", "", "img", "");
							echo "<h2><a href='".$news->getPath($result["id"])."'>".$result["title$lang"]."</a></h2>";
							echo "<p>".showStringPart($result["text$lang"]," ",150)."...</p>";
				echo "</div>\n";
				if(!(++$i % 2)) echo "</div>\n<div class='row listing'>";
			}
        }
        echo "</div>";
        ?>
	</div>
    <div id="rightCol" class="medium-4 columns">
     	<? include_once("included/partials/cols/newsRightCol.php");?>
    </div>
</div>    