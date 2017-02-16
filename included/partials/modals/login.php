<div id="loginModal" class="reveal-modal medium" data-reveal aria-labelledby="login or sign up" aria-hidden="true" role="dialog">
  <div class="row">
    <div class="medium-6 columns auth-plain">
      <div class="signup-panel left-solid">
        <p class="welcome"><?=__("Přihlásit z účtu JS")?></p>
        <p class="alert"></p>
        <form id="logInForm" action="<?=$_ENV["serverPath"]?>php/logInOut.php" method="post" data-abide>
          <div class="row collapse">
            <div class="small-2  columns">
              <span class="prefix"><i class="fi-at-sign"></i></span>
            </div>
            <div class="small-10  columns">
              <input type="text" name="userLogin" placeholder="<?=__("Váše email adresa")?>" required pattern="email">
              <input type="text" name="email" value="" class="noD">
            </div>
          </div>
          <div class="row collapse">
            <div class="small-2 columns ">
              <span class="prefix"><i class="fi-lock"></i></span>
            </div>
            <div class="small-10 columns ">
              <input type="password" name="userPsswd" value="" required>
            </div>
          </div>
          <div class="row">
          	<div class="medium-6 columns">
          		<input type="submit" class="button logIn" value="<?=__("Přihlásit")?>" />
            </div>
            <div class="medium-6 columns">
              	<p><a href="./<?=__("zmena-hesla")?>"><?=__("Zapomenuté heslo")?>?</a></p>
            </div> 
          </div>   
          <input type="hidden" name="backUrl" value="<?=$_SERVER['REQUEST_URI']?>">
        	
        </form>
        
      </div>
		<p class='welcome'><?=__("nebo")?></p>
      <?
	  	$helper = $fb->getRedirectLoginHelper();		
		$permissions = ['email']; // Optional permissions
		$loginUrl = $helper->getLoginUrl($_ENV["serverPath"]."php/ext/fbLogInOut.php?page=".$_ENV["page"], $permissions);
		echo "<a href='".htmlspecialchars($loginUrl)."' class='facebook button split'><span></span>".__("Přihlásit se přes Facebook")."</a>";
	  ?>
    </div>
    <div class="medium-6 columns ">
    	<div class="signup-panel newusers">
    		<p class="welcome"><?=__("Registrace")?></p>
					<?
                    if ($_ENV["lang"]=="CZ"){		
						?>
						<p>Buďte mezi prvními, kdo se dozví všechny <strong>důležité novinky</strong>. Párkrát před festivalem vám pošleme <strong>newsletter</strong> o tom, na co se můžete těšit. A využijte taky možnosti sestavit si pohodlně online váš <strong>osobní rozvrh projekcí s webovou aplikací Můj program</strong>. </p>
						
						<p>Až vyplníte údaje, mrkněte na svůj e-mail, kam vám dorazí potvrzovací zpráva. A je to.</p>
						<?
                    }else{
						?>
						<p>Subscribe to our festival <strong>newsletter</strong> with interesting tips and be the first to learn <strong>important news</strong> before the festival starts! </p>
						
						<p>Simply enter your (Facebook login) details, check your mailbox and click on the confirmation link in the email. Registration has never been easier – so register straight away!</p>
						<?
                    }
                    ?>
    		<a href="<?=($_ENV["lang"]=="CZ")?"/registrace":"/registration"?>" class="button "><?=__("Registrace")?></a></br>
    	</div>
    </div>
   </div>
  <a class="close-reveal-modal" aria-label="Close">&#215;</a>
</div>

<script>
/*
	$(document).ready(function(){
			$(".logIn").click(function(){
				if($("input[name=username]").val() == "" || $("input[name=password]").val() == ""){
					 	$(".alert").text("Obě pole jsou povinná.");
				}else{ 
						$.ajax({
							url:'<?=$_ENV["serverPath"]?>included/ajax/login.php', 
							data:$("#loginModal form").serialize(),
							type:'POST',
							dataType: 'html',
							beforeSend: function(){
								$("#loginModal").html("<div class='ajaxLoading'><img src='<?=$_ENV["serverPath"]?>imgs/ajax-loader-green.gif'> Loading...</div>").show(1000);						
							},
							success: function(html, textSuccess){
								//$('#logInForm')[0].reset();
								$("#loginModal").html(html).fadeIn(1000);
							},
							complete: function(){
								
							},
							error: function(xhr, textStatus, errorThrown){	
								alert("Nastala chyba "+errorThrown);
							}
						});
				}
			});
	});*/
</script>