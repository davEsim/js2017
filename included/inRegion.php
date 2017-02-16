<div class='row'>
    <div class='medium-9 columns'>
    <div id="elementtoScrollToID"></div>
	<?
        echo "<h1>".$metaTitle."</h1>";
        echo getFirstMedia("rspages", $rActivePage["id"], 1, "detailImgBox", "", "img");
        echo $rActivePage["content$lang"];
        eval($rActivePage["code"]);
    ?>
    </div><!-- col -->
    <div id="rightCol" class="medium-3 columns">
        <?
		include_once("included/partials/cols/regionRightCol.php");
		?>
    </div><!-- col -->
</div><!-- row -->