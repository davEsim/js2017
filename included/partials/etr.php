
<?php

$etrs = new xETRs($db, "xETRs");

if($_ENV["page"] == "o-poradateli" || $_ENV["page"] == "o-festivalu" || $_ENV["page"] == "jeden-svet-pro-vsechny") {
    $etr = $etrs->listOne("pageSeo = '" . $_ENV["page"] . "'");
    //echo "<h1>" . $etr["title"] . "</h1>";
    echo "<div class='row'><div class='medium-12 columns'>".$etr["text"]."</div></div>";
}

?>



