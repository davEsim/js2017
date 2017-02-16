<?
include_once($_SERVER["DOCUMENT_ROOT"]."/php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once($_SERVER["DOCUMENT_ROOT"]."/php/connection.php");

$start=$_POST["pointer"];
$news=new xNews($db, "xNews");
$results=$news->listing("", "id", "DESC", $start ,9);
if(count($results)){
    echo "<div class='row' id='news'>";
    foreach($results AS $result){
        echo "<div class='medium-4 columns'>";
        echo getFirstMedia("xNews", $result["id"], 0, "", "", "img");
        echo "<h2><a href='/".$news->getPath($result["id"])."'>".$result["xNews"]."</a></h2>";
        //echo showStringPart($result["text"]," ",200);
        echo "</div>";
        if(!(++$i % 3)) echo "</div><div class='row' id='news'>";
    }
    echo "</div>";
}else{
    echo "<p>Žádné další novinky.</p>";
}
?>


