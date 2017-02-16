<?php
$partners = new xPartners($db,"xPartners");
?>
<style>

    .logos h2{
        font-size: 1rem;
        text-transform: uppercase;

    }
    /* Medium and up */
    @media screen and (min-width: 40em) {
        .logos{
            display: flex;
            justify-content: space-around;
            align-items: center;

        }

    }
    .logos .columns{
        padding-top: 1rem;
        padding-bottom: 1rem;
    }
    .logos hr {
        border-bottom: 1px solid #000;

    }
</style>
<div class="row">
    <div class="medium-12 columns">
        <h1><?=$metaTitle?></h1>
    </div>
</div>
<div class="row logos">
    <div class="medium-2 columns text-center"><h2><?=__("Pořadatel")?></h2><?=$partners->showLogos(1)?></div>
    <div class="medium-2 columns text-center"><h2><?=__("Spolupořadatel")?></h2><?=$partners->showLogos(2)?></div>
    <div class="medium-2 columns text-center"><h2><?=__("Generální partner")?></h2><?=$partners->showLogos(3)?></div>
    <div class="medium-2 columns text-center"><h2><?=__("Hlavní partner")?></h2><?=$partners->showLogos(4)?></div>
</div>
<div class="row logos">
    <div class="medium-12 columns">
        <hr>
    </div>
</div>
<div class="row logos paddingTop2">
    <div class="medium-12 columns text-center">
        <h2><?=__("Významní partneři")?></h2>
    </div>
</div>
<div class="row logos">
    <?=$partners->showLogos(5,2)?>
</div>
<div class="row logos">
    <div class="medium-12 columns">
        <hr>
    </div>
</div>

<div class="row logos paddingTop2">
    <div class="medium-6 columns text-center">
        <h2><?=__("Generální mediální partner")?></h2>
        <?=$partners->showLogos(6)?>
    </div>
    <div class="medium-6 columns text-center">
        <h2><?=__("Hlavní mediální partner")?></h2>
        <?=$partners->showLogos(7)?>
    </div>
</div>
<div class="row logos">
    <div class="medium-12 columns">
        <hr>
    </div>
</div>
<div class="row logos paddingTop2">
    <div class="medium-12 columns text-center">
        <h2><?=__("Mediální partneři")?></h2>
    </div>
</div>
<div class="row logos">
    <?=$partners->showLogos(8,2)?>
</div>
<div class="row logos">
    <div class="medium-12 columns">
        <hr>
    </div>
</div>
<div class="row logos paddingTop2">
    <div class="medium-12 columns text-center">
        <h2><?=__("Partneři")?></h2>
    </div>
</div>
<div class="row logos">
    <?=$partners->showLogos(9,2)?>
</div>
<div class="row logos">
    <div class="medium-12 columns">
        <hr>
    </div>
</div>
<div class="row logos paddingTop2">
    <div class="medium-12 columns text-center">
        <h2><?=__("Podpořili")?></h2>
    </div>
</div>
<div class="row logos">
    <?=$partners->showLogos(10,2)?>
</div>