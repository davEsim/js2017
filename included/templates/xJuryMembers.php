<?php
$juries = new xJuries($db, "xJuries");
$juryMembers = new xJuryMembers($db, "xJuryMembers");
	//$lang = $_ENV["lang"];
?>
<div class="row">
	<div class="medium-12 columns">
	  <?php      

      echo "<h1>".$metaTitle."</h1>";

	  $juryId=$routing["filtrParam"];
      $results = $juryMembers->listing("id_xJuries='$juryId'","sequence", "ASC", 0, 0);
	  $i=0;
      foreach($results AS $result) {
          ?>
          <div class="row">
              <div class="medium-12 columns">
                  <h4><?= $result["name$lang"] ?></a></h4>

                  <p class="credits"><?= $result["country$lang"] ?></p>
              </div>
          </div>
          <div class="row">
              <div class='medium-8 columns'>
                  <?= $result["descr$lang"] ?>
              </div>
              <div class="medium-4 columns">
                  <? echo getFirstMedia("xJuryMembers", $result["id"], 1, "", "", "img", "", FALSE);?>
              </div>
          </div>
         <?
      }
      ?>
	</div>
</div>    