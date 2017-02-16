<?
if($_ENV["idOfItem"]){ //potvrzeni registrace
	list($userLogin, $userUid)=explode("&",$_ENV["idOfItem"]);
	$params = array (":active" => "ano", ":userLogin" => $userLogin, ":userUid" => $userUid);
	$visitor = $db->query("UPDATE visitors SET active=:active WHERE uid=:userUid AND userLogin=:userLogin", $params);
	if($visitor == 1){
		if($_ENV["lang"] == "CZ"){
			  echo $body="<p>Děkujeme za potvrzení registrace, nyní můžete začít využívat všech funkcí, které Vám registrace umožňuje.</p>
					<p><strong>Sestavte si svůj plán projekcí s webovou aplikací \"Můj program\"!</strong> Jste-li přihlášeni, můžete v programu festivalu jednoduše kliknout na termín projekce, kterou chcete navštívit a potvrdit pak její zařazení do Vašeho programu. Takto si můžete sestavit svůj vlastní festivalový program a ten si pak vytisknout.</p>
					<p><strong>Sledujte novinky z festivalu!</strong> Před festivalem a v jeho průběhu rozesíláme e-mailový newsletter s novinkami o Jednom světě. Za celou dobu obdržíte maximálně 6 newsletterů. Newsletter můžete kdykoliv odhlásit.</p>";
					$link="http://www.jedensvet.cz/2016/zmena-hesla";
					$body.="<p>A mimochodem, pokud zapomenete své heslo, zadejte na následujícím odkazu svoji e-mailovou adresu, kterou jste zvolili při registraci, a obratem Vám přijde e-mail s návodem, jak si zvolit heslo nové: <a href='$link'>$link</a></p>
		  <p>Užijte si festival!</p>
		  <p>Tým Jednoho světa</p>
		  <p>---</p>
		  <p>MFF Jeden svět<br/>
		  Člověk v tísni, o. p. s.<br/>
		  Šafaříkova 24, 120 00 Praha 2<br/>
		  <a href='http://www.facebook.com/jedensvet'>Facebook</a> | <a href='http://twitter.com/jedensvet'>Twitter</a> | <a href='https://plus.google.com/112227882350210766342'>Google+</a> | <a href='http://www.youtube.com/user/festivaljedensvet'>YouTube</a></p>
		  ";
		}else{
			$link="http://www.oneworld.cz/2016/change-password";
			echo $body="<p>Dear Sir or Madam,</p>
			<p>Thank you for confirming your registration. Now, you can use all the functions that are available only to registered users. </p>
			<p><strong>Use the \"My Programme\" web application and compile your own programme! </strong>
			Now you can compile (and print out) your own programme – simply log in, browse through the festival programme, select the film you want to see, click on the desired screening date and add it your programme. </p> 
			
			<p><strong>Get the festival news!</strong> Before and during the festival, you can receive our e-mail newsletter with news about the One World festival. You will receive no more than six newsletters and may unsubscribe from receiving the newsletter at any time. 
			</p>
			<p>By the way, if you forget your password, click on the link below and enter your registration email address. Shortly, you will be emailed instructions on how to create a new password: $link</p>";
			echo "<p>Enjoy the festival!</p>
				  <p>Yours One World festival team</p>
				  <p>---</p>
				  <p>One World IFF<br/>
				  Člověk v tísni, o. p. s.<br/>
				  Šafaříkova 24, 120 00 Praha 2<br/>
				  <a href='http://www.facebook.com/jedensvet'>Facebook</a> | <a href='http://twitter.com/jedensvet'>Twitter</a> | <a href='https://plus.google.com/112227882350210766342'>Google+</a> | <a href='http://www.youtube.com/user/festivaljedensvet'>YouTube</a></p>";
		}
		$mail = new PHPMailer();                                			
		$mail->From="info@jedensvet.cz";
		$mail->FromName="info@jedensvet.cz";
		$mail->AddAddress($userLogin); 			
		$mail->WordWrap = 50;                              // set word wrap
		$mail->IsHTML(true);                               // send as HTML
		$mail->CharSet="utf-8"; 
		$mail->Subject  =  "Potvrzení registrace na www.jedensvet.cz";
		$mail->Body     =  $body;
		$mail->AltBody  =  formatTextMail($body);			
		$mail->Send();
	}else{ // $visitor ==1
		if($_ENV["lang"] == "CZ"){
			echo "<p>Potvrzení registrace se nezdařilo.</p>";
		}else{
			echo "<p>Registration was NOT confirmed successfully.</p>";
		}
	}
}else{
		$form=1;	
		if($_POST){
			if(empty($_POST["userLogin"]) || empty($_POST["userPsswd"])){
				$message=($_ENV["lang"]=="CZ") ? "Všechna pole jsou povinná.": "All fields have to be filled up.";
			}elseif(!eregi("^[a-z0-9_-]+[a-z0-9_.-]*@[a-z0-9_-]+[a-z0-9_.-]*\.[a-z]{2,5}$", $_POST["userLogin"])){ 
				$message=($_ENV["lang"]=="CZ") ? "E-mail nemá korektní formát.": "Bad E-mail format.";
			}elseif($db->query("SELECT id FROM visitors WHERE userLogin LIKE '$_POST[userLogin]'") == 1){
				$message=($_ENV["lang"]=="CZ") ? "E-mail adresa ".htmlspecialchars($_POST[mail])." je již registrována.":"E-mail ".htmlspecialchars($_POST[mail])." is already registered.";	
			}elseif(!empty($_POST["nSu"])){ $message="Nejde odeslat";
			}else{
				if($_POST["newsletterOW"]!="ano") $_POST["newsletterOW"]="ne";
				if($_POST["newsletterPIN"]!="ano") $_POST["newsletterPIN"]="ne";
				$uid =	md5(uniqid(rand(), true));
				$params = array(
					":userLogin" 	=> $_POST["userLogin"],
					":userPsswd" 	=> md5($_POST["userPsswd"]),
					":session"		=> md5(uniqid(rand(), true)),
					":ip"			=> $_SERVER["REMOTE_ADDR"],
					":active"		=> "ne",
					":uid"			=>	$uid,
					":lang"			=> $_ENV["lang"],
					":newsletterOW"	=> $_POST["newsletterOW"],
					":newsletterPIN"=> $_POST["newsletterPIN"]
				);
				$db->query("INSERT INTO visitors VALUES ('',:userLogin,:userPsswd,:session,:ip,NOW(),NOW(),:active,:uid,:lang,:newsletterOW,:newsletterPIN)", $params);	
					
				echo ($_ENV["lang"]=="CZ") ? "<p>Registrace proběhla úspěšně, ale není ještě aktivní.</p><p>Na vámi zadanou e-mailovou adresu byl právě odeslán e-mail s odkazem, který je nutno kliknutím potvrdit. Tím bude registrace úspěšně dokončena.</p>": "<p>Your registration was successful but is not yet active.<br> You have been emailed a link to your email address – please click on the link to complete the registration.</p>";
				$form=0;
				if($_ENV["lang"]=="CZ"){
				  $body="<p>Vážená uživatelko, vážený uživateli,<br/><br/>na stránkách <a href='http://www.jedensvet.cz'>http://www.jedensvet.cz</a> byly právě úspěšně uloženy vaše registrační údaje:</p>";
				  $body.="<p>------------------------------------------------------------------</p>";
				  $body.="<p>Login: ".$_POST["userLogin"]."<br/>";
				  $body.="Heslo: ".$_POST["userPsswd"]."</p>";
				  $body.="<p>------------------------------------------------------------------</p>";
				  $link="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."/".$_POST["userLogin"]."&".$uid;
				  $body.="<p>Pro potvrzení registrace prosím klikněte na následující odkaz:</p>";
				  $body.="<p><a href='$link'>$link</a></p>";
				  $body.="<p>------------------------------------------------------------------</p><br><br>";
				  $body.="<p>Děkujeme a užijte si festival!</p>";
				  $body.="<p>Tým Jednoho světa<p>";
				  $mail = new PHPMailer();                                			
				  $mail->From="info@jedensvet.cz";
				  $mail->FromName="info@jedensvet.cz";
				  $mail->AddAddress($_POST["userLogin"]); 			
				  $mail->WordWrap = 50;                              // set word wrap
				  $mail->IsHTML(true);                               // send as HTML
				  $mail->CharSet="utf-8"; 
				  $mail->Subject  =  "Registrace na www.jedensvet.cz";
				  $mail->Body     =  $body;
				  $mail->AltBody  =  formatTextMail($body);			
				  $mail->Send();
				}else{
				  $body="<p>Dear user,<br/><br/>your registration was successful.</p>";
				  $body.="<p>-----------------------------</p>";
				  $body.="<p>Login: ".$_POST["userLogin"]."<br/>";
				  $body.="Password: ".$_POST["userPsswd"]."</p>";
				  $body.="<p>-----------------------------</p>";
				  $link="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']."/".$_POST["userLogin"]."&".$uid;
				  $body.="<p>Please click on the link to complete the registration: <a href='$link'>$link</a></p>";
				  $body.="<p>-----------------------------</p>";
				  $body.="<p>Thank you and enjoy Festival!</p>";
				  $body.="<p>Team One World<p>";
				  $mail = new PHPMailer();                                			
				  $mail->From="mail@oneworld.cz";
				  $mail->FromName="mail@oneworld.cz";
				  $mail->AddAddress($_POST["userLogin"]); 			
				  $mail->WordWrap = 50;                              // set word wrap
				  $mail->IsHTML(true);                               // send as HTML
				  $mail->CharSet="utf-8"; 
				  $mail->Subject  =  "Registration at www.oneworld.cz";
				  $mail->Body     =  $body;
				  $mail->AltBody  =  formatTextMail($body);			
				  $mail->Send();
				}		
			}
		};//post		
		if($form):
		if ($_ENV["lang"]=="CZ"){		
		?>
        <p>Buďte mezi prvními, kdo se dozví všechny <strong>důležité novinky</strong>. Párkrát před festivalem vám pošleme <strong>newsletter</strong> o tom, na co se můžete těšit. A využijte taky možnosti sestavit si pohodlně online váš <strong>osobní rozvrh projekcí s webovou aplikací Můj program</strong>. </p>
		<p>Stačí se jednoduše zaregistrovat a máte to v kapse. Využít můžete i svých přihlašovacích údajů z Facebooku.</p>
		<p>Až vyplníte údaje, mrkněte na svůj e-mail, kam vám dorazí potvrzovací zpráva. A je to.</p>
		<?
		}else{
		?>
        <p>Subscribe to our festival <strong>newsletter</strong> with interesting tips and be the first to learn <strong>important news</strong> before the festival starts! </p>
        <p>Remember – if you register on our website, you can also create <strong>your own festival programme with My Programme web application</strong>.</p>
        <p>Simply enter your (Facebook login) details, check your mailbox and click on the confirmation link in the email. Registration has never been easier – so register straight away!</p>
		<?
		}
		?>
		
		<form method="post" id="registrationForm" data-abide>
              <div class="row">
              	<div class="medium-12 columns">
                    <div class="panel">
                    	<? if($message){?>
                        	<div data-alert class="alert-box alert radius">
                              	<?=$message?>
                              <a href="#" class="close">&times;</a>
                            </div>
                        <? }?>
                        <div class="row">
                            <div class="medium-6 columns">
                                <label>E-mail <small><?=($_ENV["lang"]=="CZ") ? "povinné": "required";?></small>
                                    <input type="email" name="userLogin" value="<?=$_POST["userLogin"] ?>" required pattern="email">
                                </label>
                               
                                <input class="nS" type="email" name="email" value="">
                               
                            </div>
                            <div class="medium-6 columns">
                                <label><?=($_ENV["lang"]=="CZ") ? "Heslo": "Password";?>  <small><?=($_ENV["lang"]=="CZ") ? "povinné": "required";?></small>
                                    <input type="password" name="userPsswd" value="<?=$_POST["userPsswd"] ?>" required pattern="[a-zA-Z]+">
                                </label>
                            </div>
                         </div>
                         <div class="row">
                            <div class="medium-12 columns">
                                <label for="newsletterOW">
                                    <input style="width:20px"  type="checkbox" name="newsletterOW" value="ano" checked>
                                        <?=($_ENV["lang"]=="CZ") ? "Chci mailem dostávat aktuální informace z festivalu": "Send me the One World Newsletter by mail";?>
                                </label>
                            </div>
                         </div><!--row -->
                         <div class="row">
                            <div class="medium-12 columns">
                                <label for="newsletterPIN">
                                    <input style="width:20px"  type="checkbox" name="newsletterPIN" value="ano" checked>
                                        <?=($_ENV["lang"]=="CZ") ? "Chci mailem dostávat aktuální informace z Člověka v tísni": "Send me the People in Need Newsletter by mail";?>
                                </label>
                            </div>
                         </div><!--row -->
                         <div class="row">
                         	<div class="medium-12 columns">          
                            	<input class="nI" type="text" name="text" value="" />
                           		<input class="nS" type="submit" name="nSu" value="<? echo ($_ENV["lang"]=="CZ") ? "Uložit": "Submit";?>" />
                            	<input class="small radius button" type="submit" name="yS" value="<? echo ($_ENV["lang"]=="CZ") ? "Odeslat": "Send";?>">
                            </div>
                         </div><!--row -->	

                     </div> <!--panel -->
              	</div>         
              </div><!--row -->
			</form>
		<?
		else:
		endif;
}
?>	