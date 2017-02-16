<?
$lang=$_ENV["lang"];
$regionId = $_ENV["regionId"];
$regionSeo = pageContentCol($regionId, "seoUrl$lang");

?>
<div class="row">
	<div class="medium-9 columns">
        <div class="orbit" role="region" aria-label="Novinky / News" data-orbit data-options="animInFromLeft:fade-in; animInFromRight:fade-in; animOutToLeft:fade-out; animOutToRight:fade-out;">
            <ul class="orbit-container">
                <button class="orbit-previous"><span class="show-for-sr">Previous Slide</span>&#9664;&#xFE0E;</button>
                <button class="orbit-next"><span class="show-for-sr">Next Slide</span>&#9654;&#xFE0E;</button>        	<?
                $news = new xNews($db, "xNews");
                $results = $news->listing(" id_xRegionCities = '$regionId' OR showInRegion LIKE 'ano'","datum", "DESC", 0, 10);
                $iOrbit = 0;
                $orbitBullets = "";
                foreach($results AS $result){
                    if($result["title$lang"]){
                        echo "<li class='orbit-slide ".((!($iOrbit))?"is-active":"")."'>";
                        echo getFirstMedia("xNews", $result["id"], 0, "", "orbit-image", "img", "");
                        echo "<figcaption class='orbit-caption'><a href='$regionSeo-".$news->pagePath($lang)."/".$result["id"]."-".string2domainName($result["title$lang"])."'>".$result["title$lang"]."</a></figcaption>";
                        echo "</li>";
                        $orbitBullets.= "<button class='".((!($iOrbit))?"is-active":"")."' data-slide='".$iOrbit++."'></button>";
                    }
                }
                ?>
            </ul>
            <nav class="orbit-bullets">
                <?=$orbitBullets ?>
            </nav>
        </div>


    	<h2>Program</h2>
        <div id="elementtoScrollToID"></div>
        <? //include_once("included/cmsEval/regionsScreenings.php"); ?>
        <p>Program bude zveřejněn v průběhu února.</p>
	</div>
    <div class="medium-3 columns">
     	<? include_once("included/partials/cols/regionHomeRightCol.php");?>
	</div>        
</div><!--row-->  
