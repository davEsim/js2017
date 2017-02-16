<? $lang = $_ENV["lang"] ?>
<div class="row show-for-medium" id="sysFoot">
    <hr>
    <div class="medium-12 columns text-center">
          <p>
		  	<?
            if($lang=="CZ"){
				echo "&copy; 1999 - ".date("Y")." Člověk v tísni o.p.s., web běží v rámci bezplatného <a target='_blank' title='Serverhosting CZECHIA.COM' href='https://www.czechia.com/serverhosting/'>serverhosting</a> společnosti <a title='Serverhosting CZECHIA.COM' href='https://www.czechia.com/'>CZECHIA.COM</a>";
			}else{
				echo "&copy; 1999 - ".date("Y")." People In Need, web is running under free servehosting on <a title='Serverhosting CZECHIA.COM' href='https://www.czechia.com/'>CZECHIA.COM</a>.";
          	}
			?>
          </p>
    </div>
</div><!--row -->
