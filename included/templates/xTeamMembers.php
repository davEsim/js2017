<?php
	$regionId = $_ENV["regionId"];
	$members = new xTeamMembers($db, "xTeamMembers");
	//$lang = $_ENV["lang"];
?>
<div class="row">
	<div class="medium-12 columns">
        <h1><?=$metaTitle?></h1>
    </div>
</div>
	<?


      $results = $members->listing("","sequence", "ASC", 0, 0);
      echo "<div class='row team listing'>";
      $i=0;
      foreach($results AS $result){
          echo "<div class='medium-4 small-6 columns end'>\n";

                echo "<div class='row'>";
                    echo "<div class='medium-5 columns'>\n";
                  		echo getFirstMedia("xTeamMembers",$result["id"], 0, "", "", "img", "", FALSE);
                    echo "</div>\n";
                    echo "<div class='medium-7 columns'>\n";
                      echo "<h5>".$result["name$lang"]."</a></h5>";
                      echo "<p class='credits'>".$result["position$lang"]."</p>";
                      echo "<p class='credits'><a href='mailto:".$result["mail"]."'>".str_replace("@","<br>@",$result["mail"])."</a></p>";
                    echo "</div>\n";
                echo "</div>\n";

          echo "</div>\n";
          //if(!(++$i % 3)) echo "</div>\n<div class='row listing'>";
      }
      echo "</div><!-- row -->";
      ?>
<div class="row marginTop2">
    <div class="medium-12 columns">
        <?=$rActivePage["content$lang"]?>
    </div>
</div>
