<?php

$videos = new xVideos($db,"xVideos");

//---- detail --------------------------------------------------------------------------
if($itemId){
    $activeItem=$videos->findById($itemId);
    $ytId = substr(strstr($activeItem["url"],"="),1); // konverze mezi clasic yt odkaz a embded
    echo "<div class='row'>";
        echo "<div class='medium-12 columns'>";
            echo "<div class='bgPaperHand' style='padding-right: 1em;padding-bottom: 1em'>";
                echo "<div class='flex-video'>";
                    echo "<iframe width='420'  src='https://www.youtube.com/embed/".$ytId."' frameborder='0' allowfullscreen></iframe>";
                echo "</div>";
                echo "<h1>".$activeItem["xVideos"]."</h1>";
                echo $activeItem["descr"];
            echo "</div>";
            showItemDocs("xVideos",$activeItem["id"]);
        echo "</div>";
    echo "</div>";
}



//---- seznam ostatnich ----------------------------------------------------------------

if($itemId){?>
    <div class="itemSection">
        <span class="itemSectionOrange">Další Videa</span>
    </div>
<?}
$results = $videos->listing("","datumInsert", "DESC", 0, 0);
echo "<div class='row listing'>";
foreach($results AS $result){
    echo "<div class='medium-4 end columns'>";
        echo "<div class='bgPaperInList'>\n";
            echo getFirstMedia("xVideos", $result["id"], 0, "", "", "img");
            echo "<h2><a href='/".$videos->getPath($result["id"])."'>".$result["xVideos"]."</a></h2>";
            //echo showStringPart($result["text"]," ",200);
        echo "</div>";
    echo "</div>";
    if(!(++$i % 3)) echo "</div><div class='row listing'>";
}
echo "</div>";
//echo "<div class='row paddingTop2'><div class='medium-12 medium-text-center columns'><a class='nextDownOrange'  href='#'>další</a></div> </div>";

?>
