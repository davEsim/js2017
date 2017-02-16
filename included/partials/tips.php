<?php
$tips = new xTips($db, "xTips");
$tips = $tips->listing("", "datum", "DESC", 0, 3);
?>
<ul class="orbit-content-jsTips" data-orbit data-options="animation:slide;pause_on_hover:false;animation_speed:900;timer_speed: 40000;navigation_arrows:true;bullets:true;slide_number:false">
<?
$i=0;
foreach($tips AS $tip){
	$i++;
?>
  <li data-orbit-slide="headline-<?=$i?>">
  	<div>
       	<?=$tip["tip"]?>
        <p class="credits">
			<strong><?=$tip["name"]?></strong><br />
			<?=$tip["position"]?>
        </p>
    </div>
   </li>     
<?		
}
?>
</ul>



