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

?>
<ul class="orbit-content-aktualne" data-orbit data-options="animation:slide;pause_on_hover:false;animation_speed:1000;timer_speed: 11000;navigation_arrows:true;bullets:true;slide_number:false">
<?
$i=0;
foreach($items AS $item){
	$i++;
?>
  <li data-orbit-slide="headline-<?=$i?>">
  	<div>
    	<img src="<?=$item->media_url?>" alt="<?=$item->title?>" />
    	<h5><a target="_blank" href="<?=$item->link?>"><?=$item->title?></a></h5>
       	<p><?=$item->description?></p>
    </div>
   </li>     
<?	
	if($i == 10) break;	
}
?>
</ul>


