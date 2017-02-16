<?
ini_set('display_errors',0);
ini_set('display_startup_errors',1);
error_reporting(-1); // ukaze opravdu vse
//error_reporting(E-ALL);

include_once($_SERVER["DOCUMENT_ROOT"]."/php/funcs.php");
spl_autoload_register('autoload_class_multiple_directory');
include_once($_SERVER["DOCUMENT_ROOT"]."/php/connection.php");
include_once($_SERVER["DOCUMENT_ROOT"]."/php/classes/ext/PHPMailer.class.php");

$m=$_GET["m"];
if (filter_var($m, FILTER_VALIDATE_EMAIL) && preg_match('/@.+\./', $m)) { 
	$uid = md5(uniqid(rand(), true));
    $params=array(
        ":m" => $m,
        ":active" => 0,
        ":uid" => $uid
    );
	$result=$db->query("INSERT INTO newsletters VALUES (NULL, :m, :active, :uid)", $params);
	$link="http://www.varianty.cz/newsletter/".$uid;
	$body="<p>Dobrý den,</p>";
	$body.="<p>děkujeme vám za přihlášení k našemu newsletteru.</p>";
    $body.="<p>Aby byla vaše registrace kompletní, klikněte prosím na následující odkaz pro potvrzení registrace:</p>";
	$body.="<p><a href='$link'>$link</a></p>";
	$body.="<p>Pokud jste registraci na našich stránkách www.varianty.cz neprováděl(a) berte prosím tento mail za bezpředmětný.</p>";
	$body.="<p>For more information, you can contact our team at info@irsec-hub.org</p>";
	$body.="<p>Yours, <br>IRSEC Hub Team</p>";
	
	$mail = new PHPMailer;
	
	$mail->From = "Varianty";
	$mail->FromName = "varianty@clovekvtisni.cz";
	$mail->addAddress($m);      
	$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
	$mail->isHTML(true);                                  // Set email format to HTML
	$mail->CharSet="utf-8"; 
	$mail->Subject = 'Registrace pro newsletter na webu varianty.cz';
	$mail->Body    = $body;
	$mail->AltBody = formatTextMail($body);
	
	$mail->send();
	

    if($result==1)echo "<p>Vaše adresa ".$m." byla přidána do našeho newsletteru. Na tuto adresu byl odeslán potvrzovací e-mail, ve kterém prosím potvrďte registraci.</p>";
}else{
	echo "<p>Špatný e-mail, <a href='' class='again'>try it</a> again.</p>";
}
 
?>
