<?
        $news = new xNews($db, "xNews");
        $lang = $_ENV["lang"];
        $results = $news->listing(" id_xRegionCities = 0 ","id", "DESC", 0, 3); //AND carousel LIKE 'ne'
        echo "<div class='row listing'>";
        $i=0;
        foreach($results AS $result){
			if($result["title$lang"]){
				echo "<div class='medium-4 columns end'>\n";
							echo getFirstMedia("xNews", $result["id"], 0, "", "", "img", "");
							echo "<h2><a href='".$news->getPath($result["id"])."'>".$result["title$lang"]."</a></h2>";
							echo "<p>".showStringPart($result["text$lang"]," ",150)."</p>";
				echo "</div>\n";
				if(!(++$i % 3)) echo "</div>\n<div class='row listing'>";
			}
        }
        echo "</div><!--row -->";
?>