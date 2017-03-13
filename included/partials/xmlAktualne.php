<?php

$xml = simplexml_load_file('https://zpravy.aktualne.cz/mrss/jeden-svet-2017/l~469b0d34f8f111e68ad70025900fea04/');
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
<div class="orbit" role="region" aria-label="Aktuálně.cz" data-orbit data-timer-delay="11500">
    <ul class="orbit-container">
        <button class="orbit-previous"><span class="show-for-sr">Předchozí</span>&#9664;&#xFE0E;</button>
        <button class="orbit-next"><span class="show-for-sr">Následující</span>&#9654;&#xFE0E;</button>
        <?
        $i=0;
        foreach($items AS $item){
            $i++;
            ?>
            <li class="orbit-slide">
                <img src="<?=$item->media_url?>" alt="<?=$item->title?>" />
                <p class="label secondary">Aktuálně.cz</p>
                <h4><a target="_blank" href="<?=$item->link?>"><?=$item->title?></a></h4>
                <p><?=showStringPart($item->description, " ", 300)?></p>
            </li>
            <?
            if($i == 10) break;
        }
        ?>
    </ul>
</div>

