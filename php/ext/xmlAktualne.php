<h2 class="rssAktualneh2">Přečtěte si na mrss</h2>
<div class="rssAktualne" id="featuredContent"> 

<?php

$xml = simplexml_load_file('http://zpravy.aktualne.cz/mrss/jeden-svet-2016/l~06cd972ed96411e59c4a002590604f2e/');
$namespaces = $xml->getNamespaces(true); // get namespaces
 
$items = array();
foreach ($xml->channel->item as $item) {
 
  $tmp = new stdClass();
  $tmp->title = trim((string) $item->title);
  $tmp->link  = trim((string) $item->link);
  $tmp->description  = trim((string) $item->description);
  
  // etc...
 
  // now for the data in the media:group
  //
  $media_group = $item->children($namespaces['media'])->group;
 
  $tmp->media_url =    trim((string)
                       $media_group->children($namespaces['media'])->content->attributes()->url);
  $tmp->media_credit = trim((string)
                       $media_group->children($namespaces['media'])->credit);
  // etc
 
  // add parsed data to the array
  $items[] = $tmp;
}

print_r($items);

/*
<?
if ($stream = fopen("http://zpravy.aktualne.cz/mrss/jeden-svet-2016/l~06cd972ed96411e59c4a002590604f2e/", 'r')) {
	$string=stream_get_contents($stream);
	//$search=array("<![CDATA[","]]>");
	//$replace=array("",""); 
	//$string=str_replace($search, $replace, $string);
	$xml = simplexml_load_string($string); 
	print_r($xml);
	
	$i=0;
	echo "<div>";
	foreach($xml->channel->item AS $item){
		if($i++>10) break;
		if(strstr($item->pubDate,"2015")){
			  echo "<p class='credits'>".date("d.m.Y",strtotime($item->pubDate))."</p>\n";
			  echo "<h3><a href='".$item->link."' target='_blank'>".$item->title."</a></h3>\n";
			  echo "<p>".$item->description."</p>\n";
			  if(!($i%3))echo "\n\n</div><div>";
		}
	}
	echo "</div>";
	
	fclose($stream);
	
}*/
?>
</div>

