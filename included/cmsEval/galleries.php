
<style>
	figure{
		float:left;	
		margin:0;
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
		echo "<p class='back'><span class='fi-arrow-left'></span> <a href='".$_ENV['serverPath'].$_ENV["page"]."'>".($lang=="CZ"? "všechny galerie" : "all galleries")."</a></p>";
		echo "<ul class='block-grid gallery' data-clearing>";
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
			echo "<li><a  title='".$caption[$lang]."' href='".$pathOfFullImage."'><img src='".$pathOfImage[1]."'  data-caption='".$caption[$lang]."'/></a></li>";
		}//
		fclose($stream);
		echo "</ul>";
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