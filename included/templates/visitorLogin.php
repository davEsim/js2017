<div class="row">
	<div class="medium-12 columns">
    	<h1><?=$metaTitle?></h1>
    </div>
</div>
<div class="row">
	<div class="medium-12 columns">
<?
if(!$message) $message=__("E-mail nebo heslo není správné, zkuste to prosím znovu.");

?>	
<div class="row">
    <div class="medium-6 columns">
        <form method="post" id="loginForm"  action="<?=$_ENV["serverPath"]?>php/logInOut.php" data-abide>
            <div class="panel">
                <? if($message){?>
                    <div data-alert class="alert-box alert radius">
                        <?=$message?>
                      <a href="#" class="close">&times;</a>
                    </div>
                <? }?>
                <div class="row">
                    <div class="medium-6 columns">
                        <label>E-mail <small><?=__("povinné");?></small>
                            <input type="email" name="userLogin" value="<?=$_POST["userLogin"] ?>" required pattern="email">
                             <input type="text" name="e-mail" class="noD" placeholder="email" >
                        </label>
                       
                        <input class="nS" type="email" name="email" value="">
                       
                    </div>
                    <div class="medium-6 columns">
                        <label><?=__("Heslo");?>  <small><?=__("povinné");?></small>
                            <input type="password" name="userPsswd" value="<?=$_POST["userPsswd"] ?>"  > <!-- required pattern="[a-zA-Z]+" -->
                        </label>
                    </div>
                 </div>
                 <div class="row">
                    <div class="medium-6 columns">          
                        <input class="nI" type="text" name="text" value="" />
                        <input class="nS" type="submit" name="nSu" value="<?=__("Přihlásit X");?>" />
                        <input class="small radius button" type="submit" name="yS" value="<?=__("Přihlásit");?>">
                    </div>
                    <div class="medium-6 columns">
                    	<p><a href="./<?=__("zmena-hesla")?>"><?=__("Zapomenuté heslo")?>?</a></p>
                    </div>
                 </div><!--row -->	
				 <input type="hidden" name="backUrl" value="<?=$_POST['backUrl']?>">
             </div> <!--panel -->
        </form>
    </div>
    <div class="medium-6 columns">
    </div>
</div>    
