
<style>
    #galleryFeeds{
        padding-left: 1em;
        padding-right: 1em;
    }
	figure{
		float:left;	
		margin:0;
        margin-top: 1em;
		padding:0;
	}
	figure a{
		position:relative;
		display:block;
		border-right:1px solid transparent;
		border-bottom:1px solid transparent;
	}
		figcaption{
			position:absolute;
			bottom:.5em;
			left:.5em;
			color:white;
			text-shadow: 1px 1px 1px rgba(0,0,0,.75);
		}
		.gallery li{
			margin:0;
			margin-right:1px;
			margin-bottom:1px;
		}
		.gallery img{
			height:150px;
			
		}
</style>
<div id="galleryFeeds">
    <blockquote class="instagram-media" data-instgrm-captioned data-instgrm-version="7" style="background:#FFF; border:0; border-radius:0px;width:calc(100% - 2px);"><div style="padding:8px;"> <div style=" background:#F8F8F8; line-height:0; margin-top:40px; padding:33.5648148148% 0; text-align:center; width:100%;"> <div style=" background:url(data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAACwAAAAsCAMAAAApWqozAAAABGdBTUEAALGPC/xhBQAAAAFzUkdCAK7OHOkAAAAMUExURczMzPf399fX1+bm5mzY9AMAAADiSURBVDjLvZXbEsMgCES5/P8/t9FuRVCRmU73JWlzosgSIIZURCjo/ad+EQJJB4Hv8BFt+IDpQoCx1wjOSBFhh2XssxEIYn3ulI/6MNReE07UIWJEv8UEOWDS88LY97kqyTliJKKtuYBbruAyVh5wOHiXmpi5we58Ek028czwyuQdLKPG1Bkb4NnM+VeAnfHqn1k4+GPT6uGQcvu2h2OVuIf/gWUFyy8OWEpdyZSa3aVCqpVoVvzZZ2VTnn2wU8qzVjDDetO90GSy9mVLqtgYSy231MxrY6I2gGqjrTY0L8fxCxfCBbhWrsYYAAAAAElFTkSuQmCC); display:block; height:44px; margin:0 auto -44px; position:relative; top:-22px; width:44px;"></div></div> <p style=" margin:8px 0 0 0; padding:0 4px;"> <a href="https://www.instagram.com/p/BPiSdEVjEq3/" style=" color:#000; font-family:Arial,sans-serif; font-size:14px; font-style:normal; font-weight:normal; line-height:17px; text-decoration:none; word-wrap:break-word;" target="_blank">Our Team!!! &lt;3 #jedensvetvregionech</a></p> <p style=" color:#c9c8cd; font-family:Arial,sans-serif; font-size:14px; line-height:17px; margin-bottom:0; margin-top:8px; overflow:hidden; padding:8px 0 7px; text-align:center; text-overflow:ellipsis; white-space:nowrap;">Fotka zveřejněná uživatelem One World Film Festival (@jedensvetcz), <time style=" font-family:Arial,sans-serif; font-size:14px; line-height:17px;" datetime="2017-01-21T18:02:35+00:00">Led 21, 2017 v 10:02 PST</time></p></div></blockquote> <script async defer src="//platform.instagram.com/en_US/embeds.js"></script>

    <?
    //ini_set('display_errors',1);
    //ini_set('display_startup_errors',1);
    //error_reporting(-1); // ukaze opravdu vse

    /*
    $lang = $_ENV["lang"];
    if($lang == "CZ") $galleryPath = "fotogalerie"; else $galleryPath = "photogalleries";
    if ($stream = fopen("https://picasaweb.google.com/data/feed/base/user/104688239901831004226?alt=rss&kind=album&hl=cs", 'r')) {
        $string=stream_get_contents($stream);
        $xml = simplexml_load_string($string);
        //print_r($xml);
        $i = 0;
        foreach($xml->channel->item AS $item){

            $pathToGallery=ltrim(str_replace("entry","feed",$item->guid),"http://");
            //echo $item->description;
            ereg("src=\"(.*)\" alt", $item->description, $pathOfImage);
            $thumb = str_replace("s160","s241",$pathOfImage[1]);
            $thumb = str_replace("https","https",$pathOfImage[1]);
            ereg("albumid\/(.*)\?", $item->guid, $idOfGallery);
            if(strstr($item->title,"/")){
                list($caption["CZ"], $caption["EN"])=explode("/",$item->title);
            }else{
                $caption["CZ"] = $item->title;
            }
            if(strstr($item->pubDate,"2016")){
                echo "	<figure>
                            <a href='".$_SERVER['serverPath']."$galleryPath/".$idOfGallery[1]."'>
                                <img src='".$thumb."' style='width:270px'>
                                <figcaption>".$caption[$lang]."</figcaption>
                            </a>
                        </figure>";
                break;
            }

        }
        fclose($stream);
    }
    */
    ?>
</div>