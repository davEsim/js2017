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
			$params = array(
                $_POST["q1"],
                $_POST["q2"],
                $_POST["q2comm"],
                $_POST["q3comm"],
                $_POST["q4"],
                $_POST["q4comm"],
                $_POST["q5"],
                $_POST["q5comm"],
                $_POST["q6"],
                $_POST["q6comm"],
                $_POST["q7"],
                $_POST["q7comm"],
                $_POST["q8"],
                $_POST["q8comm"],
                $_POST["q9comm"],
                $_POST["q10comm"],
                $_POST["q11comm"],
                $_POST["q12comm"],
                $_POST["q13comm"],
                $_POST["q14comm"],
                $_POST["q15comm"],
                $_POST["q16comm"],
                $_POST["q17comm"])
            ;
			
			$db->query("INSERT INTO visitorVotes VALUES ('',?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)", $params);
			
			echo "<p>Děkujeme za vyplnění dotazníku.</p>";
		}
	}
}

if(!$_POST || $message){
?>	

<p><em>Milé divačky, milí diváci,</em></p>
<p><em>děkujeme, že jste se přišli podívat na festivalové filmy a akce! Chcete, aby byl Jeden svět v příštích letech ještě lepší? Pomozte nám vyplněním jednoduchého dotazníku. Ještě jednou díky a na viděnou za rok.</em></p>
<p><em>Váš festivalový tým</em></p><p>&nbsp;</p>

<? if($message){ ?>
<div data-alert class="alert-box alert radius">
 <?=$message ?>
  <a href="#" class="close">&times;</a>
</div>
<? } ?>
<form method="post" id="vote">

	<fieldset>
    	<legend>Kolik filmů jste na festivalu viděl/a?</legend>
        Počet 	<select name="q1">
        			<? generateOptionZero(1, 20, "", 1);?>
        		</select>
    </fieldset>
	<fieldset>
    	<legend>Navštívil/a jste doprovodný program?</legend>
        <label><input type="radio" name="q2" value="ano" /> Ano. Uveďte na čem jste byl/a</label>
        <label><input type="radio" name="q2" value="ne" /> Ne. Uveďte důvod</label>
        <label><textarea name="q2comm" rows="3" placeholder="Váš komentář..."></textarea></label>
    </fieldset>
	<fieldset>
    	<legend>Odkud jste se dozvěděl/a, že se Jeden svět blíží?</legend>
        <textarea name="q3comm"  rows="3" placeholder="Váš komentář..."></textarea>
    </fieldset>
	<fieldset>
    	<legend>Jak se vám líbily plakáty festivalu?</legend>

                <label>škála známek 1–5 jako ve škole </label><br />
                <? generateRadio("q4", 1, 5, 1)?><br />

                <label><textarea name="q4comm" rows="3" placeholder="Váš komentář..."></textarea></label>

    </fieldset>
	<fieldset>
    	<legend>Jak se vám líbil festivalový spot (znělka)?</legend>

                <label>škála známek 1–5 jako ve škole </label><br />
                <? generateRadio("q5", 1, 5, 1)?><br />

                <label><textarea name="q5comm" rows="3" placeholder="Váš komentář..."></textarea></label>

    </fieldset>
	<fieldset>
    	<legend>Kde jste bral/a informace o programu festivalu?</legend>

                <label><input type="radio" name="q6" value="katalog" /> V tištěném katalogu</label>
                <label><input type="radio" name="q6" value="web" /> Na www.jedensvet.cz</label>
                <label><input type="radio" name="q6" value="Facebook" /> Na Facebooku</label>
                <label><input type="radio" name="q6" value="kina" /> Na webových stránkách kin nebo v jejich tištěném programu</label>

                <label><textarea name="q6comm" rows="3" placeholder="Jinde? ... Kde?"></textarea></label>

    </fieldset>
    <fieldset>
        <legend>Používal/a jste si mobilní aplikaci? </legend>

                <label><input type="radio" name="q7" value="ano" /> Ano</label>
                <label><input type="radio" name="q7" value="ne" /> Ne</label>

                <textarea name="q7comm" rows="3" placeholder="Proč?"></textarea></label>

    </fieldset>
    <fieldset>
    	<legend>Jak se vám líbil letošní katalog?</legend>
        <label><input type="radio" name="q8" value="ano" /> Ano</label>
        <label><input type="radio" name="q8" value="ne" /> Ne</label>
        <label><input type="radio" name="q8" value="nevšiml" /> Nevšiml/a jsem si, že je na něm něco nového</label>
        <label><input type="radio" name="q8" value="nepoužívám" /> Tištěný katalog nepoužívám</label>
        <textarea name="q8comm" rows="3" placeholder="Váš komentář"></textarea>
    </fieldset>
    <fieldset>
        <legend>Který film vás nejvíc zaujal?</legend>
        <textarea name="q9comm" rows="3" placeholder="Pište pozitivní i negativní hodnocení"></textarea>
    </fieldset>
    <fieldset>
            <legend>Která pofilmová debata vás nejvíc zaujala?</legend>
        <textarea name="q10comm" rows="3" placeholder="Pište pozitivní i negativní hodnocení"></textarea>
    </fieldset>
	<fieldset>
    	<legend>Navštívil/a jste nějakou panelovou debatu? Proč?</legend>
        <textarea name="q11comm" rows="3" placeholder="Pište pozitivní i negativní hodnocení"></textarea>
    </fieldset>
	<fieldset>
    	<legend>Setkali jste se během projekce nebo debaty s nějakými technickými problémy nebo nedostatky? </legend>
        <textarea name="q12comm" rows="3"></textarea>
    </fieldset>
	<fieldset>
    	<legend>Co říkáte na Jeden svět pro všechny?</legend>
        <textarea name="q13comm" rows="3"></textarea>
    </fieldset>
	<fieldset>
    	<legend>Máte ve svém okolí někoho, kdo šel na film pro publikum se znevýhodněním?	</legend>
        <textarea name="q14comm" rows="3"></textarea>
    </fieldset>
    <fieldset>
        <legend>Jaký nejsilnější zážitek si z festivalu odnášíte?</legend>
        <textarea name="q15comm" rows="3"></textarea>
    </fieldset>
    <fieldset>
        <legend>Je něco, co vás na festivalu naštvalo?</legend>
        <textarea name="q16comm" rows="3"></textarea>
    </fieldset>
    <fieldset>
        <legend>Chcete nám ještě něco sdělit? Výtku či pochvalu?</legend>
        <textarea name="q17comm" rows="3"></textarea>
    </fieldset>

	<input type="text" name="email" class="nS" />
    <p>Děkujeme vám a těšíme se za rok!</p>
	<input type="submit" class="small radius button" value="Odeslat" />
</form>
<?
}
?>