<?
//exit("registrace ukoncena");
$lang = $_ENV["lang"];
$itemSeo = intval($_ENV["itemSeo"]);

$brusselScreenings = new xBrusselScreenings($db, "xBrusselScreenings");
$activeBrusselScreening = $brusselScreenings->findById($itemId);
$activeBrusselScreeningCountOfViewers = $brusselScreenings->countOfViewers($itemId);
$activeBrusselScreeningFilm = $brusselScreenings->getRelRow($activeBrusselScreening["id_xBrusselFilms"], "xBrusselFilms");
$activeBrusselScreeningPlace = $brusselScreenings->getRelRow($activeBrusselScreening["id_xBrusselPlaces"], "xBrusselPlaces");


if($_POST){
	if($activeBrusselScreeningCountOfViewers >= $activeBrusselScreening["countOfViewers"]){?>
			<p>Není bohužel možné provést rezervaci. Projekce je již vyprodána.</p>
 <? }else{        
	  $message = "";
	  if(!empty($_POST["email"])){
		  $message = "Detekováno jako spam.";
	  }elseif(filter_var(filter_var($_POST["brusselViewerM"], FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL) === false){
		  $message = "E-mail nemá bohužel správný formát.";
	  }elseif(empty($_POST["brusselViewerFullName"]) || empty($_POST["brusselViewerM"])){
		  $message = "Vyplňte prosím všechna povinná pole.";
	  }elseif($_POST["pid"]==4 &&(empty($_POST["dateOfBirth"]) || empty($_POST["idType"]) || empty($_POST["idN"]) || empty($_POST["residence"]) || empty($_POST["nationality"]))){
		  $message = "Vyplňte prosím všechna povinná pole.";
	  }else{
		  $uid = md5(uniqid(rand(), true));
		  $params = array(
							  ":screenId" 		=> $_POST["sid"],
							  ":name"			=> $_POST["brusselViewerFullName"],
							  ":nameOfSigner"	=> "",
							  ":dateOfBirth"	=> $_POST["dateOfBirth"],
							  ":idType"			=> $_POST["idType"],
							  ":idN"			=> $_POST["idN"],
							  ":residence"		=> $_POST["residence"],
							  ":nationality"	=> $_POST["nationality"],
							  ":mail"			=> $_POST["brusselViewerM"],
							  ":uid"			=> $uid
						  );
		  $db->query("INSERT INTO xBrusselViewers VALUES ('', :screenId, :name, :nameOfSigner, :dateOfBirth, :idType, :idN, :residence, :nationality, :mail, :uid, NOW())", $params);
		  
		  if($_POST["brusselViewer2FullName"]){
			  $params = array(
								  ":screenId" 		=> $_POST["sid"],
								  ":name"			=> $_POST["brusselViewer2FullName"],
								  ":nameOfSigner"	=> $_POST["brusselViewerFullName"],
								  ":dateOfBirth"	=> "",
								  ":idType"			=> "",
								  ":idN"			=> "",
								  ":residence"		=> "",
								  ":nationality"	=> "",
								  ":mail"			=> "",
								  ":uid"			=> $uid
							  );
			  $db->query("INSERT INTO xBrusselViewers VALUES ('', :screenId, :name, :nameOfSigner, :dateOfBirth, :idType, :idN, :residence, :nationality, :mail, :uid, NOW())", $params);
		  }
		  if($lang=="CZ"){
			  echo "	<p>Vaše registrace na projekci proběhla úspěšně.</p>
					  <p>Na vámi zadanou adresu ".$_POST["brusselViewerM"]." byl odeslán potvrzovací e-mail.<br/>E-mail obsahuje i odkaz, přes který je možné se z projekce odhlásit.</p>
					  <p class='warning'><strong>Zkontrolujte prosím i vaší spam složku (na nevyžádanou poštu), jestli tam náhodou mail od nás nezapadl.</strong></p>
					  <p>Děkujeme</p>
					  <a class='radius button' href='../brusel-program'><b class='fi-arrow-left'></b> Zpět na program</a>
				  ";
		  }else{
			  echo "	<p>Your registration has been successful.</p>
					  <p>An email message confirming registration has been sent to your email address ".$_POST["brusselViewerM"].".<br/>The email message also contains a link for cancelling the registration.</p>
					  <p class='warning'><strong>If you can not find our mail, please,  check your spam folder too.</strong></p>
					  <p>Thank you</p>
					  <a class='radius button' href='../brussel-programme'><b class='fi-arrow-left'></b> Back to Programme</a>
				  ";
		  }
		  include_once("./included/partials/mails/brusselRegistration.php");
		  $mail = new PHPMailer();                                			
		  $mail->From="iva.bartosova@oneworld.cz";
		  $mail->FromName="Iva Bartošová";
		  $mail->AddAddress($_POST["brusselViewerM"]); 			
		  $mail->WordWrap = 50;                              // set word wrap
		  $mail->IsHTML(true);                               // send as HTML
		  $mail->CharSet="utf-8"; 
		  $mail->Subject  =(($lang=="CZ")?"Jeden svět v Bruselu – registrace na projekci":"Your registration for One World Brussels");
		  $mail->Body     =  $body;
		  $mail->AltBody  =  formatTextMail($body);			
		  $mail->Send();
  
	  }
	}
}
if(!$_POST || $message){
	  	if($activeBrusselScreeningCountOfViewers >= $activeBrusselScreening["countOfViewers"]){?>
			<p><?=__("Není bohužel možné provést rezervaci. Projekce je již vyprodána nebo vůbec neexistuje.")?></p>
    <?	}elseif($itemId == 1 && $itemSeo != 5168){ ?>  
        	<p><?=__("Na tuto projekci není možná rezervace zdarma. Koupit")?> <a target="_blank" href="http://www.bozar.be/en" class="tiny radius label" ><?=__("vstupenky")?></a>.</p>
	<? 	}else{?>
		<div class="row" data-abide>
			<div class="medium-6 columns">
				<p class="warning"><?=$message?></p>
				<form method="post" class="callout secondary">
					<table id="brusselForm">
						<tr><td><?=__("Jméno")?> <small><?=__("povinné")?></small></td><td><input type="text" name="brusselViewerFullName" size="30" required /></td></tr>
						<tr><td>E-mail <small><?=__("povinné")?></small></td><td><input type="email" name="brusselViewerM" required  /></td></tr>
						<tr class="nD"><td>E-mail</td><td><input type="email" name="email" /></td></tr>
						<?
						if($activeBrusselScreening["id_xBrusselPlaces"] != 4){ // extra resim parlament ?>
							<tr><td><?=__("Jméno druhé osoby")?></td><td><input type="text" name="brusselViewer2FullName" /></td></tr>
						<?
						}else{
						?>
							<tr><td><?=__("Datum narození")?> <small><?=__("povinné")?></small><br />(YYYY-MM-DD)</td><td><input type="text" name="dateOfBirth" required  /></td></tr>
							<tr><td><?=__("Typ ID")?> <small><?=__("povinné")?></small></td><td>	<select name="idType" required  />
														<option value="PASS">PASS</option>
														<option value="ID">ID</option>
													</select>
											</td></tr>
							<tr><td><?=__("ID číslo")?> <small><?=__("povinné")?></small></td><td><input type="text" name="idN" required  /></td></tr>
							<tr><td><?=__("Bydliště")?> <small><?=__("povinné")?></small></td><td><input type="text" name="residence" required  /></td></tr>
							<tr><td><?=__("Národnost")?> <small><?=__("povinné")?></small></td><td><input type="text" name="nationality" required  /></td></tr>
						<?
						}
						?>
					</table>
					<div id="formSend" data-value="<?=__("Odeslat")?>"></div>
					<input type="hidden" name="sid" value="<?=$activeBrusselScreening["id"]?>" />
					<input type="hidden" name="pid" value="<?=$activeBrusselScreening["id_xBrusselPlaces"]?>" />
				</form>
			</div>
			<div class="medium-6 columns">
				<h3><?=__("Vaše rezervace na projekci")?></h3>
				<p><strong><?=$activeBrusselScreeningFilm["title$lang"]?></strong></p>
				<p><?=invertDatumFromDB($activeBrusselScreening["date"],1)." | ".$activeBrusselScreening["time"]?></p>
				<p><?=$activeBrusselScreeningPlace["xBrusselPlaces"]?><br /><?=$activeBrusselScreeningPlace["address"]?></p>
			</div>
		</div>

		<?
	}
}
?>


