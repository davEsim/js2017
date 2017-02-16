<?php
	$juryMembers = new xJuryMembers($db, "xJuryMembers"); 
	//$lang = $_ENV["lang"];
?>
<div class="row">
	<div class="medium-8 columns">
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
	  $juryId=$routing["filtrParam"];
      $results = $juryMembers->listing("id_xJuries='$juryId'","sequence", "ASC", 0, 0);
	  $i=0;
      foreach($results AS $result){
		  ?>
          	  <div class="row">
              	<div class="medium-12 columns">
                	<h4><?=$result["name$lang"]?></a></h4>
                    <p class="credits"><?=$result["country$lang"]?></p> 
              	</div>
              </div>
          	  <div class="row">
                  <div class='medium-8 columns'>
                      <?=$result["descr$lang"]?>
                  </div>
                  <div class="medium-4 columns">
                        <? echo getFirstMedia("xJuryMembers",$result["id"], 1, "", "", "img", "", FALSE);?>
                  </div>
              </div>
              <? if(++$i != count($results)){?>
              <div class="row">
              	<div class="medium-12 columns">
                	<hr />
              	</div>
              </div>
          <?
			  }
      }
      ?>
	</div>
    <div id="rightCol" class="medium-4 columns">
       	<div id="sideMenu">
			<?
            if(in_array($rActivePage["id"], array(31,74,75,76,77))) generateOneLevelMenu($rActivePage["id"], false);
            ?>
        </div>

     	<? include_once("included/partials/cols/rightCol.php");?>
    </div>
</div>    