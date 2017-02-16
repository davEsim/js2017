<?
if($_POST && $_POST["mail"]==="" && $_POST["email"]===""){ //pokud jsou vyplnena skryta pole mail a email => spam robot
    $params=array(
        "idPublication"=>$activeItem["id"],
        ":userDegree"=>$_POST["userDegree"],
        ":userFName"=>$_POST["userFName"],
        ":userSName"=>$_POST["userSName"],
        ":userM"=>$_POST["userM"],
        ":userTel"=>$_POST["userTel"],
        ":schoolName"=>$_POST["schoolName"],
        ":schoolIco"=>$_POST["schoolIco"],
        ":schoolDic"=>$_POST["schoolDic"],
        ":schoolStreet"=>$_POST["schoolStreet"],
        ":schoolCity"=>$_POST["schoolCity"],
        ":schoolZip"=>$_POST["schoolZip"],
        ":countPubs"=>$_POST["countPubs"]
    );

    $affectRows=$db->query("INSERT INTO xPublicationsOrders VALUES (NULL, :idPublication, :userDegree, :userFName, :userSName, :userM, :userTel, :schoolName, :schoolIco, :schoolDic, :schoolStreet, :schoolCity, :schoolZip, :countPubs )", $params);

    if($affectRows==1){

        $body="<p>Dobrý den,</p>";
        $body.="<p>potvrzujeme tímto vaší objednávku publikace:<br><strong>".$activeItem["xPublications"]."</strong><br>";
        $body.="Počet kusů: ".$_POST["countPubs"]."</p>";
        $body.="<br><p>Pro kontrolu ještě vámi zadané údaje v rámci objednávky:</p>";
        $body.="<p>";
        $body.="Celé jméno: ".$_POST["userDegree"]." ".$_POST["userFName"]." ".$_POST["userSName"]."<br>";
        $body.="E-mail: ".$_POST["userM"]."<br>";
        if($_POST["userTel"]) $body.="Tel: ".$_POST["userTel"]."<br>";
        $body.="</p><p>Informace o škole:<br>";
        $body.="Název: ".$_POST["schoolName"]."<br>";
        $body.="IĆ: ".$_POST["schoolIco"]."<br>";
        $body.="DIČ: ".$_POST["schoolDic"]."<br>";
        $body.="".$_POST["schoolStreet"]."<br>";
        $body.=$_POST["schoolZip"]." ".$_POST["schoolCity"]."</p>";
        $body.="<br><p>";
        $body.="Vzdělávací program Varianty<br>
                Člověk v tísni, o.p.s.<br>
                Šafaříkova 24, 120 00 Praha 2<br>
                tel: 226 200 467<br>
                web: www.varianty.cz
                ";
        $body.="</p>";


        $mail = new PHPMailer();
        $mail->From = 'varianty@clovekvtisni.cz';
        $mail->FromName = 'Varianty';
        $mail->addAddress($_POST["userM"]);     // uzivateli
        $mail->addAddress('david.simon@clovekvtisni.cz');     // mne pro kontrolu
        $mail->addAddress('katerina.dvorakova@clovekvtisni.cz');     // a holkam
        //$mail->addAddress('petra.skalicka@clovekvtisni.cz');     // a holkam

        $mail->isHTML(true);                                  // Set email format to HTML
        $mail->CharSet="utf-8";
        $mail->Subject = 'Objednávka publikace na webu varianty.cz';
        $mail->Body    = $body;
        $mail->AltBody = formatTextMail($body);

        if(!$mail->send()) {
            $errorMsgs.="Nepodařilo se odeslat mail.<br>";
        }
    }else{
        $errorMsgs.="Objednávku se nepodařilo odeslat.<br>";
    }

    if($errorMsgs){
        echo "<p>".$errorMsgs."</p>";
    }else{
        echo "<p>Vaše objednávka publikace byla odeslána.</p>";
        echo "<p>Potvrzení objednávky bylo zasláno na vámi uvedenou e-mail adresu. Pokud nemůžete e-mail najít, zkontrolujte prosím i vaší složku na spam.</p>";
    }
    echo "<p><a href='".$_SERVER["REQUEST_URI"]."'>Zpět na informace o publikaci</a></p>";
}else{
?>
<div class="row">
    <div class="medium-10 columns notes">
        <div class="string"></div>
        <h2 class="section courseRegHeadline">Objednávka publikace</h2>
        <form method="post" data-abide>
            <label>Titul <input type="text" name="userDegree"></label>
            <div>
                <label>Jméno <small>povinné</small><input type="text" name="userFName" required></label>
                <small class="error">Povinné.</small>
            </div>
            <div>
                <label>Příjmení <small>povinné</small><input type="text" name="userSName" required></label>
                <small class="error">Povinné.</small>
            </div>
            <div>
                <label>E-mail <small>povinné</small><input type="email" name="userM" required></label>
                <small class="error">Povinné.</small></div>
                <input class="mail" type="text" name="email">
                <input class="mail" type="text" name="mail">

            <div>
                <label>Telefon<input type="text" name="userTel"></label>
            </div>



            <fieldset>
                <legend>Adresa školy/pracoviště</legend>
                <div><label>Název školy/pracoviště <small>povinné</small><input type="text" name="schoolName" required></label><small class="error">Povinné.</small></div>
                <div><label>IČ <small>povinné</small><input type="text" name="schoolIco" required></label><small class="error">Povinné.</small></div>
                <div><label>DIČ <small>povinné</small><input type="text" name="schoolDic" required></label><small class="error">Povinné.</small></div>
                <div><label>Ulice a č.p. <small>povinné</small><input type="text" name="schoolStreet" required></label>
                <small class="error">Povinné.</small></div>
                <div><label>Město <small>povinné</small><input type="text" name="schoolCity" required></label>
                <small class="error">Povinné.</small></div>
                <div><label>PSČ <small>povinné</small><input type="text" name="schoolZip" required></label>
                <small class="error">Povinné.</small></div>
            </fieldset>
            <label>Počet publikací <small>povinné</small><select name="countPubs"><option value="1">1</option><option value="2">2</option> </select> </label>
            <input class="button" type="submit" value="odeslat">
        </form>
    </div>
</div>
<?
}
?>