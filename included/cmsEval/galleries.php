
<style>
    p.back{
        line-height: 2em !important;
        margin: 1rem 0;
    }
	figure{
		float:left;	
		margin:0;
		padding:0;
	}
	figure a, .Collage img{
		position:relative;
		display:block;
		border-right:1px solid transparent;
		border-bottom:1px solid transparent;
	}

		figcaption{
			position:absolute;
			bottom:.5em;
			left:.5em;
			color:#fdcd00; /* #09f */
            text-transform: uppercase;
            font-weight: 700;
            font-size: 1.2rem;
			text-shadow: 1px 1px 3px rgba(0,0,0,1) !important;
		}

</style>
 
<?
$lang = $_ENV["lang"];
if($itemId=$_ENV["itemId"]){
	if ($stream = fopen("https://picasaweb.google.com/data/feed/base/user/".$_ENV["galleryUser"]."/albumid/$itemId?alt=rss&hl=cs", 'r')) {
		$string=stream_get_contents($stream);
		$xml = simplexml_load_string($string);
		//print_r($xml);
		if(strstr($xml->channel->title,"/")){
			list($caption["CZ"], $caption["EN"])=explode("/", $xml->channel->title);
		}else{
				$caption["CZ"] = $xml->channel->title;
		}
		echo "<h2>".$caption[$lang]."</h2><br/>";
		echo "<p class='back'><span class='fi-thumbnails'></span> <a href='".$_ENV['serverPath'].$_ENV["page"]."'>".($lang=="CZ"? "všechny galerie" : "all galleries")."</a></p>";
        echo "<div id='lightgallery' class='Collage'>";
		$i=0;
		foreach($xml->channel->item AS $item){
            //print_r($item);
			//echo $item->guid;
			//echo $item->title;
			ereg("src=\"(.*)\" alt", $item->description, $pathOfImage);
			$pathOfFullImage=str_replace("s288/","w900/",$pathOfImage[1]);
			ereg("albumid\/(.*)\?", $item->guid, $idOfGallery);
			//echo "<li><a href='".$pathOfFullImage."'><img style='max-height:130px' src='".$pathOfImage[1]."'/></a></li>";
			if(strstr($item->title,"IMG_") || strstr($item->title,".jpg") || strstr($item->title,".jpeg")){
				$item->title="";
			}else{
				if(strstr($item->title,"/")){
					list($caption["CZ"], $caption["EN"])=explode("/", $item->title);
				}else{
					$caption["CZ"] = $xml->channel->title;
				}
			}

			    echo "<a class='Image_Wrapper' title='".$caption[$lang]."' href='".$pathOfFullImage."'><img src='".$pathOfImage[1]."'  data-caption='".$caption[$lang]."'/></a>";

		}//
		fclose($stream);
		echo "</div>";

        echo "<p class='back'><span class='fi-thumbnails'></span> <a href='".$_ENV['serverPath'].$_ENV["page"]."'>".($lang=="CZ"? "všechny galerie" : "all galleries")."</a></p>";

    }
}else{
	if ($stream = fopen("https://picasaweb.google.com/data/feed/base/user/".$_ENV["galleryUser"]."?alt=rss&kind=album&hl=cs", 'r')) {
		
		$string=stream_get_contents($stream);
		$xml = simplexml_load_string($string);
		//print_r($xml);
		foreach($xml->channel->item AS $item){
			//print_r($item);
			//echo $item->guid;
			$pathToGallery=ltrim(str_replace("entry","feed",$item->guid),"http://");
			//echo $item->description;
			ereg("src=\"(.*)\" alt", $item->description, $pathOfImage);
			$thumb = str_replace("s160","s230",$pathOfImage[1]);
			ereg("albumid\/(.*)\?", $item->guid, $idOfGallery);
			if(strstr($item->title,"/")){
				list($caption["CZ"], $caption["EN"])=explode("/",$item->title); 
			}else{
				$caption["CZ"] = $item->title;
			}
			if(strstr($item->pubDate,"2016")){
				echo "	<figure>
							<a href='".$_SERVER['REQUEST_URI']."/".$idOfGallery[1]."'>
								<img src='".$thumb."'/>
								<figcaption>".$caption[$lang]."</figcaption>
							</a>
						</figure>";
			}
		}
		fclose($stream);
	}
}
?>

