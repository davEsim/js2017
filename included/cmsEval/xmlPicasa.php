<?

$lang=$_ENV["lang"];

if($idOfGallery=$_ENV["itemInPage"]){

	if ($stream = fopen("https://picasaweb.google.com/data/feed/base/user/".$_ENV["galleryUser"]."/albumid/$idOfGallery?alt=rss&hl=cs", 'r')) {

		$string=stream_get_contents($stream);

		$xml = simplexml_load_string($string);

		//print_r($xml);
		
		list($title["CZ"], $title["EN"])=explode("/", $xml->channel->title);

		echo "<h2>".$title[$lang]."</h2><br/>";

		echo "<p class='back'><a href='".$_ENV['basePath'].$_ENV["page"]."'>".($lang=="CZ"? "všechny galerie" : "all galleries")."</a></p>";

		echo "<ul class='block-grid' data-clearing>";

		$i=0;

		foreach($xml->channel->item AS $item){

			//print_r($item);

			//echo $item->guid;

			//echo $item->title;

			ereg("src=\"(.*)\" alt", $item->description, $pathOfImage);

			$pathOfFullImage=str_replace("s288/","w900/",$pathOfImage[1]);

			ereg("albumid\/(.*)\?", $item->guid, $idOfGallery);

			//echo "<li><a href='".$pathOfFullImage."'><img style='max-height:130px' src='".$pathOfImage[1]."'/></a></li>";

			if(strstr($item->title,"IMG_") || strstr($item->title,".jpg") || strstr($item->title,".jpeg"))$item->title="";

				else list($title["CZ"], $title["EN"])=explode("/", $item->title);

			echo "<li><a  title='".$title[$lang]."' href='".$pathOfFullImage."'><img style='max-height:130px' src='".$pathOfImage[1]."'  data-caption='".$title[$lang]."'/></a></li>";



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

			ereg("albumid\/(.*)\?", $item->guid, $idOfGallery);

			//list($title["CZ"], $title["EN"])=explode("/",$item->title); 
			
			if(strstr($item->title,"/")){
				list($title["CZ"], $title["EN"])=explode("/",$item->title); 
			}else{
				$title["CZ"] = $item->title;
			}

			if(strstr($item->pubDate,"2015") || strstr($item->pubDate,"Thu, 18 Dec"))echo "<div class='galleryImgC'><a href='".$_SERVER['REQUEST_URI']."/".$idOfGallery[1]."'><img src='".$pathOfImage[1]."'/><div class='galleryImgCLabel'>".$title[$lang]."</div></a></div>";

			

		}

		fclose($stream);

	}

}





?>



