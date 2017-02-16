<?
if($lang=="CZ"){
  $body="<p>Dobrý den,</p>
  <p>Děkujeme za váš zájem a registraci na projekci.</p><br>
  <p>
	Vaše jméno: ".$_POST['brusselViewerFullName']."<br />";
	if($_POST['brusselViewer2FullName']) $body.="Druhá osoba: ".$_POST['brusselViewer2FullName']."<br />";
	$body.="
	Film: ".$activeBrusselScreeningFilm["title$lang"]."<br />
	Místo projekce: ".$activeBrusselScreeningPlace["xBrusselPlaces"].", ".$activeBrusselScreeningPlace["address"]."<br />
	Datum a čas: ".invertDatumFromDB($activeBrusselScreening["date"],1)." | ".$activeBrusselScreening["time"]."<br />
  </p>";
  $link="http://www.jedensvet.cz/2016/brusel-zruseni-rezervace/$uid";
  $body.="<p>Z projekce se můžete odhlásit kliknutím na odkaz: <a href='$link'>$link</a></p>"; 
  $body.="
    <p>Užijte si festival!<br />
    Tým Jednoho světa</p>
    <p>---</p>
    <p>MFF Jeden svět<br/>
    Člověk v tísni, o. p. s.<br/>
    Šafaříkova 24, 120 00 Praha 2
    </p>";

}else{
  $body="<p>Dear Sir/Madam,</p>
  <p>Thank you for registering for the screening.</p>
  <p> 
	Your Name: ".$_POST['brusselViewerFullName']."<br />";
	if($_POST['brusselViewer2FullName']) $body.="Accompanying person: ".$_POST['brusselViewer2FullName']."<br />";
	$body.="
	Film: ".$activeBrusselScreeningFilm["title$lang"]."<br />
	Venue: ".$activeBrusselScreeningPlace["xBrusselPlaces"].", ".$activeBrusselScreeningPlace["address"]."<br />
	Date and time: ".invertDatumFromDB($activeBrusselScreening["date"],1)." | ".$activeBrusselScreening["time"]."<br />
  </p>";
  $link="http://www.oneworld.cz/2016/brussel-cancel-reservation/$uid";
  $body.="<p>You can cancel the registration using this link: <a href='$link'>$link</a>"; 
  $body.="
    <p>Enjoy One World Brussels!<br />
    One World IFF team</p>
    <p>---</p>
    <p>MFF One World<br/>
    People in Need<br/>
    Safarikova 24, 120 00 Prague 2
    </p>
  ";

}
?>