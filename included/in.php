<?
if(	$_ENV["page"] == "partneri" || $_ENV["page"] == "partners" ||
    $_ENV["page"] == "kontakty" || $_ENV["page"] == "contacts" ||
    $_ENV["page"] == "kontakty-pro-media" || $_ENV["page"] == "press-contacts" ||
	$_ENV["page"] == "muj-program" || $_ENV["page"] == "calendar" ||
    $_ENV["page"] == "jeden-svet-pro-vsechny" ||
    $_ENV["page"] == "jeden-svet-interaktivne" || "one-world-interactive" ||
	$_ENV["page"] == "foto-z-filmu" || $_ENV["page"] == "film-photos" ||
	$_ENV["page"] == "brusel-mista-projekci" || $_ENV["page"] == "brussel-cinemas" ||
	$_ENV["page"] == "brusel-program" || $_ENV["page"] == "brussel-programme" ||
	strstr($_ENV["page"], "fotogal") || strstr($_ENV["page"], "photogal") 
	){
?>
    <div class='row'>
        <div class='medium-12 columns' id="content">

        <?
            echo "<h1>".$metaTitle."</h1>";
            if(!$_POST) echo $rActivePage["content$lang"];
            eval($rActivePage["code"]);
        ?>
        </div><!-- col -->
    </div><!-- row -->
<?
}else{?>
    <div class='row'>
        <div class='medium-8 columns' id="content">

        <?
            echo "<h1>".$metaTitle."</h1>";
            echo getFirstMedia("rspages", $rActivePage["id"], 1, "detailImgBox", "", "img");
            echo $rActivePage["content$lang"];
            eval($rActivePage["code"]);
        ?>
        </div><!-- col -->
        <div id="rightCol" class="medium-4 columns"> 
            <div id="sideMenu">
                <?
                if(in_array($rActivePage["id"], array(31,74,75,76,77))) generateOneLevelMenu($rActivePage["id"], true);
                ?>
            </div>
            <?
            include_once("included/partials/cols/rightCol.php");
            ?>
        </div><!-- col -->
    </div><!-- row -->
<?    
}
?>