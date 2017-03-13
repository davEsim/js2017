<?
$films = new xFilms($db, "xFilmsVR");
$films = $films->listing("", "id", "ASC", 0, 0);
?>


        <?
        foreach($films AS $film){
        ?>
            <div class="row filmsVRlisting">
                <div class="medium-8 columns">
                    <h3><?=$film["title$lang"]?></h3>
                    <?=$film["descr$lang"]?>
                </div>
                <div class="medium-4 columns">

                    <? echo getFirstMedia("xFilmsVR",$film["id"], 0, "fancybox", "", "img", "", FALSE); ?>
                </div>
            </div>
            <div class="row">
                <div class="medium-12 columns">
                    <hr>
                </div>
            </div>
        <?
        }
        ?>

