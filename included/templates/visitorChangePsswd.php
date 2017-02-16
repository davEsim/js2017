<?
echo "<div class='row'><div class='medium-12 columns'><h1>$metaTitle</h1></div></div>";
if($itemId){ // sem příjdu z linku uvedeného v mailu, který byl zaslán jako žádost o nové heslo
	echo "<div class='row'><div class='medium-12 columns'>";
	list($userMail, $userUid) = explode("&", $itemId);
	if($_POST["sent"] && empty($_POST["newPw"])) $message="<p class='warning'>Heslo nebylo zadáno.</p>";
	
	if(!$_POST["sent"] || $message){
		$params = array(":mail" => $userMail,":uid" => $userUid);
		$user = $db -> queryOne("SELECT * FROM visitors WHERE userLogin LIKE :mail AND uid LIKE :uid", $params);
		if(count($user)){
		  ?>
		  <form method='post' class="form" data-abide>
		  <? if($message) echo $message;?>
			<table>
			  <tr><td>Váš registrovaný e-mail :</td><td><?=$user["userLogin"]?></td></tr>
			  <tr><td>Nové heslo:</td><td><input type="password" name="newPw" required pattern="[a-zA-Z0-9]+" /></td></tr>
			  <tr><td colspan="2"><input type="submit" value="Uložit" class="small radius button" /></td></tr>
			</table>
			<input type="hidden" name="sent" value="1">
		  </form>
    	<?
		}else{
		echo "<p>Účet nebyl nalezen. Není možné heslo změnit.</p>";	
		}
	}else{
		$newPw=md5($_POST["newPw"]);
		$params = array(":newPw" => $newPw, ":mail" => $userMail,":uid" => $userUid);
		$db->query("UPDATE visitors SET userPsswd=:newPw WHERE userLogin LIKE :mail AND uid LIKE :uid", $params);	
		echo "<p>Heslo bylo úspěšně nastaveno.</p>";
	}
	echo "</div></div>";
}else{ // přijdu sem a chci teprve vygenerovat heslo... a dostanu link do mailu
		$message="";
		if($_POST["mail"]){
			if(!empty($_POST["email"])){
				$message = "Spam is here.";
			}
			if(!filter_var($_POST["mail"], FILTER_VALIDATE_EMAIL)){
				$message = "E-mail nemá správný formát.";
			}
			$params = array(":mail" => $_POST["mail"]);
			$user = $db->queryOne("SELECT userLogin, uid FROM visitors WHERE userLogin LIKE :mail AND active LIKE 'ano'", $params);
			if(!count($user)){
				$message = "E-mail není vůbec registrován nebo nebyl aktivován.";	
			}
			

			if(!$message){
				echo "<div class='row'><div class='medium-12 columns'><p>Na e-mail adresu ".$_POST["mail"]." byl právě odeslán odkaz, přes který je možné nastavit nové heslo.</p><p>Pro jistotu prosím zkontrolujte i spam složku.</p></div></div>";
				$noForm=1;
				if($_ENV["lang"]=="CZ"){
					$linkForChange=$_ENV["serverPath"]."zmena-hesla/".$user["userLogin"]."&".$user["uid"];
					$body="<p>Vážená uživatelko, vážený uživateli,<br/><br/>na stránkách <a href='http://www.jedensvet.cz'>http://www.jedensvet.cz</a> byla právě zaznamenána žádost o nastavení hesla k účtu s registrační e-mail adresou ".$_POST["mail"].":</p>";
					$body.="<p>Pro změnu hesla prosím využíjte následující odkaz.</p>";
					$body.="<p>------------------------------------------------------------------------------------------</p>";
					$body.="<p>Odkaz pro změnu hesla: <a href='$linkForChange'>".$linkForChange."</a></p>";
					$body.="<p>------------------------------------------------------------------------------------------</p>";
					$body.="<p>Pokud jste o změnu nežádal(a), berte prosím tento mail za bezpředmětný.</p>";
					$body.="<p>Tým Jednoho světa</p>";
					$mail = new PHPMailer();                                			
					$mail->From="info@jedensvet.cz";
					$mail->FromName="info@jedensvet.cz";
					$mail->AddAddress($_POST["mail"]); 			
					$mail->WordWrap = 50;                              // set word wrap
					$mail->IsHTML(true);                               // send as HTML
					$mail->CharSet="utf-8"; 
					$mail->Subject  =  "Změna hesla na www.jedensvet.cz";
					$mail->Body     =  $body;
					$mail->AltBody  =  formatTextMail($body);			
					$mail->Send();
				}else{
					$linkForChange=$_ENV["basePath"]."change-password/".$r["pw"];
					$body="<p>Dear user, <br/><br/>here you can change your password:</p>";
					$body.="<p>------------------------------------------------------------------------------------------</p>";
					$body.="<p>Link for change password: <a href='$linkForChange'>".$linkForChange."</a></p>";
					$body.="<p>------------------------------------------------------------------------------------------</p>";
					$body.="<p>Team One World</p>";
					$mail = new PHPMailer();                                			
					$mail->From="info@oneworld.cz";
					$mail->FromName="info@oneworld.cz";
					$mail->AddAddress($_POST["mail"]); 			
					$mail->WordWrap = 50;                              // set word wrap
					$mail->IsHTML(true);                               // send as HTML
					$mail->CharSet="utf-8"; 
					$mail->Subject  =  "Change password at www.oneworld.cz";
					$mail->Body     =  $body;
					$mail->AltBody  =  formatTextMail($body);			
					$mail->Send();
				} //lang
			 } // message
		}
		if(!$_POST["mail"] || $message){
		?>
        <div class="row">
        	<div class="medium-6 columns">
                <form method="post" class="form" data-abide>
                    <div class="row">
                      <div class="medium-12 columns">
                      	<label ><?=__("E-mail zadaný při registraci")?><input type="email" name="mail" required></label>
                        <input class="nS" type="email" name="email" value="">
                      </div>
                    </div>
                    <div class="row">
                      <div class="medium-12 columns">
                        <input type="submit" class="radius button" value="<?=("Odeslat")?>">
                      </div>
                    </div>
                    <input type="hidden" name="sent" value="1">
                </form>
            </div>
            <div class="medium-6 columns">
            	<?
                if($_ENV["lang"]=="CZ"){
                ?>
                    <p>Zapomněli jste heslo?</p>
                    <p>Nové heslo je možné nastavit kliknutím na odkaz, který obdržíte na e-mailovou adresu zadanou při registraci.</p>
                    <p>Z důvodu bezpečnosti je heslo k Vašemu účtu ukládáno v zakódované podobě, proto je možné pouze nastavení nového hesla, nikoliv zaslání původního hesla. </p>
                    <p>Pokud si nepamatujete e-mail zadaný při registraci, musíte se <a href='<?=$_ENV["basePath"]?>registrace'>registrovat</a> znovu pod jinou e-mailovou adresou.</p>
                
                <?
                }else{
                ?>
                    <p>Have you forgotten your password?</p>
                    <p>To set a new password, please click on the link in the email sent to your registration email address.    </p>
                    <p>Please note that for security reasons your account password is stored encrypted – we are unable to email your original password; only a new password can be set. </p>
                    <p>If you have forgotten your registration email address, <a href='<?=$_ENV["basePath"]?>registration'>re-register</a> using a new registration email address. 
                    </p>
                <?
                }
				?>
            </div>
        </div>    
<?
	}
}
?>