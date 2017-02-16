<style>
	.guest{
		min-height:230px;	
	}
</style>

<?php
	$guests = new xGuests($db, "xGuests");
	//$lang = $_ENV["lang"];
?>
<div class="row">
	<div class="medium-12 columns">
	  <?php      
      //---- detail --------------------------------------------------------------------------
      if($itemId){
          $activeItem=$news->findById($itemId);
          echo "<div class='row'>";
              echo "<div class='medium-12 columns'>";
                  echo "<h1>".$activeItem["title$lang"]."</h1>";
                  echo getFirstMedia("xNews",$activeItem["id"], 1, "detailImgBox", "", "img", "", FALSE);
                  echo $activeItem["text$lang"]."<br/>";
                  showItemDocs("xPublications",$activeItem["id"]);
              echo "</div>";
          echo "</div>";
      
      //---- seznam --------------------------------------------------------------------------
      
      ?>
          <p class="section">
              <span>Další hosté</span>
          </p>
      <?
      }else{
          echo "<h1>".$metaTitle."</h1>";	
      }
      $results = $guests->listing("","sname", "ASC", 0, 0);
      echo "<div class='row listing'>";
      $i=0;
      foreach($results AS $result){
          echo "<div class='medium-4 columns end'>\n";
		  	echo "<div class='panel guest'>";
                echo "<div class='row'>";
                    echo "<div class='medium-5 columns'>\n";
					    if($result["photo"]){                  
							echo "<img src='".$result["photo"]."'>";
						}else{
							echo "<img src='../imgs/noImage.png'>";
						}
                    echo "</div>\n";
                    echo "<div class='medium-7 columns'>\n";
                      echo "<h5>".$result["fname"]." ".$result["sname"]."</a></h5>";
                      echo "<p>".$result["country"]."";
                      echo "<br>".invertDatumFromDB($result["from"],1)." &mdash; ".invertDatumFromDB($result["to"],1);
					  echo "<br>".$result["films"];
					  echo "<br>".$result["profession"]."</p>";
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