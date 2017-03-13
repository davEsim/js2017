
<style>


    .picasaGallery a{
        position:relative;
        display: inline-block;
        margin: 0;
        padding: 0;
        margin-bottom: 1em;

    }
    .picasaGallery img{
        border-right: 1px solid transparent;
    }

    .picasaGallery figcaption{
        text-align: left;
        position:absolute;
        bottom:.5em;
        left:1.5em;
        color:#fdcd00; /* #09f */
        text-transform: uppercase;
        font-weight: 700;
        max-width: 200px;
        font-size: 1.2rem;
        text-shadow: 1px 1px 3px rgba(0,0,0,1) !important;
    }

</style>

<?
$lang = $_ENV["lang"];

if ($stream = fopen("https://picasaweb.google.com/data/feed/base/user/104688239901831004226?alt=rss&kind=album&hl=cs", 'r')) {

    $string=stream_get_contents($stream);
    $xml = simplexml_load_string($string);
    //print_r($xml);
    $i=1;
    foreach($xml->channel->item AS $item){
        //print_r($item);
        //echo $item->guid;

        $pathToGallery=ltrim(str_replace("entry","feed",$item->guid),"http://");
        //echo $item->description;
        ereg("src=\"(.*)\" alt", $item->description, $pathOfImage);
        $thumb = str_replace("s160","s300",$pathOfImage[1]);
        ereg("albumid\/(.*)\?", $item->guid, $idOfGallery);
        if(strstr($item->title,"/")){
            list($caption["CZ"], $caption["EN"])=explode("/",$item->title);
        }else{
            $caption["CZ"] = $item->title;
        }
        if(strstr($item->pubDate,"2017") && $idOfGallery[1] != 5936095942556489473 && $idOfGallery[1] != 6373593476976162401){
            echo "<div class='medium-3 columns end text-center picasaGallery'>

							<a href='".$_SERVER['REQUEST_URI'].__("fotogalerie")."/".$idOfGallery[1]."'>
								<img src='".$thumb."'/>
								<figcaption>".$caption[$lang]."</figcaption>
							</a>

                </div>";
        }
        if($i++ == 4)break;
    }
    fclose($stream);
}

?>

