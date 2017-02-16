<?
if($_POST){
	$message = "";
	if($_POST["email"]){ 
		$message = "Sorry, ale vypadáte jako spam.";
	}else{
		$something = FALSE;	
		foreach($_POST AS $key => $value){
			if($value) $something = TRUE;
		}
		
		if(!$something){
			$message = "Odpovězte prosím alespoň na jednu otázku. Jinak pro nás nemá uložení formuláře smysl.";
		}else{
			//print_r($_POST);
			$params = array($_POST["q1"],$_POST["q2"],$_POST["q3"],$_POST["q3comm"],$_POST["q4"],$_POST["q4comm"],$_POST["q5comm"],$_POST["q6"],$_POST["q6comm"],$_POST["q7"],$_POST["q7comm"],$_POST["q8"],$_POST["q8comm"],$_POST["q9"],$_POST["q9comm"],$_POST["q10comm"],$_POST["q11comm"],$_POST["q12comm"],$_POST["q13comm"]);
			
			$db->query("INSERT INTO visitorVotes VALUES ('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $params);
			
			echo "<p>Děkujeme za vyplnění dotazníku.</p>";
		}
	}
}

if(!$_POST || $message){
?>	

<p>Milé divačky, milí diváci,</p>
<p>děkujeme, že jste se přišli podívat na festivalové filmy a akce! Chcete, aby byl Jeden svět v příštích letech ještě lepší? Pomozte nám vyplněním jednoduchého dotazníku. Ještě jednou díky a na viděnou za rok.</p>
<p>Váš festivalový tým</p>
<style>
 .inlineBlock {
		display:inline-block; 
 }
</style>
<? if($message){ ?>
<div data-alert class="alert-box alert radius">
 <?=$message ?>
  <a href="#" class="close">&times;</a>
</div>
<? } ?>
<form method="post">
	<fieldset>
    	<legend>Navštěvujete pravidelně Jeden svět?</legend>
        <label><input type="radio" name="q1" value="párkrát" /> Ano, festival jsem již párkrát navštívil/a</label>
        <label><input type="radio" name="q1" value="poprvé" /> Letos jsem na festivalu poprvé</label>
    </fieldset>
	<fieldset>
    	<legend>Na kolika filmech jste byl/a?</legend>
        Počet 	<select name="q2">
        			<? generateOptionZero(1, 20, "", 1);?>
        		</select>
    </fieldset>
	<fieldset>
    	<legend>Navštívil/a jste letošní bohatý doprovodný program?</legend>
        <label><input type="radio" name="q3" value="ano" /> Ano. Uveďte na čem jste byl/a</label>
        <label><input type="radio" name="q3" value="ne" /> Ne. Uveďte důvod</label>
        <label>Váš komentář<textarea name="q3comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Líbilo se vám nové Divácké centrum v Galerii Lucerna?</legend>
        <label><input type="radio" name="q4" value="ano" /> Ano, divácké centrum festivalu dosud chybělo</label>
        <label><input type="radio" name="q4" value="ne" /> Ne, nic mě tam nezaujalo</label>
        <label><input type="radio" name="q4" value="nebyl čas" /> Ne, nezbyl mi čas se tam zastavit</label>
        <label>Váš komentář<textarea name="q4comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Odkud jste se dozvěděl/a, že se Jeden svět blíží?</legend>
        <label>Váš komentář<textarea name="q5comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Jak se vám líbily plakáty festivalu?</legend>
        <label>škála známek 1–5 jako ve škole </label><br />
        <? generateRadio("q6", 1, 5, 1)?><br /> 
        <label>Váš komentář<textarea name="q6comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Jak se vám líbil festivalový spot (znělka)?</legend>
        <label>škála známek 1–5 jako ve škole </label><br />
        <? generateRadio("q7", 1, 5, 1)?><br /> 
        <label>Váš komentář<textarea name="q7comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Kde jste bral/a informace o programu festivalu?</legend>
        <label><input type="radio" name="q8" value="katalog" /> V tištěném katalogu</label>
        <label><input type="radio" name="q8" value="web" /> Na www.jedensvet.cz</label>
        <label><input type="radio" name="q8" value="Facebook" /> Na Facebooku</label>
        <label><input type="radio" name="q8" value="kina" /> Na webových stránkách kin nebo v jejich tištěném programu</label>
        <label><input type="radio" name="q8" value="jinde" /> Jinde</label>
        <label>Kde?<textarea name="q8comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Líbil se vám nový katalog?</legend>
        <label><input type="radio" name="q9" value="ano" /> Ano</label>
        <label><input type="radio" name="q9" value="ne" /> Ne</label> 
        <label><input type="radio" name="q9" value="nevšiml" /> Nevšiml/a jsem si, že je na něm něco nového</label>
        <label><input type="radio" name="q9" value="nepoužívám" /> Tištěný katalog nepoužívám</label>
        <label>Proč?<textarea name="q9comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Která pofilmová nebo panelová debata vás nejvíc zaujala?</legend>
        <label>Pište pozitivní i negativní hodnocení<textarea name="q10comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Jaký nejsilnější zážitek si z festivalu odnášíte?</legend>
        <label><textarea name="q11comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Je něco, co vás na festivalu naštvalo?</legend>
        <label><textarea name="q12comm" rows="4"></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Chcete nám ještě něco sdělit? Výtku či pochvalu?</legend>
        <label><textarea name="q13comm" rows="4"></textarea></label>
    </fieldset>
	<input type="text" name="email" class="nS" />
    <p>Děkujeme vám a těšíme se za rok!</p>
	<input type="submit" class="small radius button" value="Odeslat" />
</form>
<?
}
?>