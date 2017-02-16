<?php
	$regionId = $_ENV["regionId"];
	$members = new xRegionTeamMembers($db, "xRegionTeamMembers");
	//$lang = $_ENV["lang"];
?>
<div class="row">
	<div class="medium-12 columns">
	  <?php      
      //---- detail --------------------------------------------------------------------------
      if($itemId){
	  /*
          $activeItem=$news->findById($itemId);
          echo "<div class='row'>";
              echo "<div class='medium-12 columns'>";
                  echo "<h1>".$activeItem["title$lang"]."</h1>";
                  echo getFirstMedia("xNews",$activeItem["id"], 1, "detailImgBox", "", "img", "", FALSE);
                  echo $activeItem["text$lang"]."<br/>";
                  showItemDocs("xPublications",$activeItem["id"]);
              echo "</div>";
          echo "</div>";
      */
      //---- seznam --------------------------------------------------------------------------
      
      ?>
          <p class="section">
              <span>Další členové týmu</span>
          </p>
      <?
      }else{
          echo "<h1>".$metaTitle."</h1>";
		  echo $rActivePage["content$lang"];	
      }
      $results = $members->listing(" id_xRegionCities = '$regionId'","sequence", "ASC", 0, 0);
      echo "<div class='row listing'>";
      $i=0;
      foreach($results AS $result){
          echo "<div class='medium-4 columns end'>\n";
		  	echo "<div class='panel'>";
                echo "<div class='row'>";
                    echo "<div class='medium-5 columns'>\n";
                  		echo getFirstMedia("xRegionTeamMembers",$result["id"], 1, "", "", "img", "", FALSE);
                    echo "</div>\n";
                    echo "<div class='medium-7 columns'>\n";
                      echo "<h5>".$result["nameCZ"]."</a></h5>";
                      echo "<p class='credits'>".$result["positionCZ"]."</p>";
                      echo "<p><a href='mailto:".$result["mail"]."'>".str_replace("@","<br>@",$result["mail"])."</a></p>";
                    echo "</div>\n";
                echo "</div>\n";
          	echo "</div>\n";
          echo "</div>\n";
          if(!(++$i % 3)) echo "</div>\n<div class='row listing'>";
      }
      echo "</div>";
      ?>
	</div>
    <!--<div id="rightCol" class="medium-4 columns">
     	<? include_once("included/partials/cols/newsRightCol.php");?>
    </div>-->
</div>    