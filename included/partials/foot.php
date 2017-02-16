<? $lang = $_ENV["lang"] ?>
<div class="row">
    <div class="medium-3 columns text-center">
        <? if($lang=="CZ"){
             echo "
                    <address>
                        <strong>Jeden svět</strong><br>
                        Člověk v tísni o.p.s.<br/> 
                        Šafaříkova 635/24<br/> 
                        120 00 Praha 2<br/> 
                    </address>";
            }else{
                echo "<address>
                        <strong>One World</strong><br>
                        People In Need<br/>  
                        Safarikova 635/24<br/> 
                        120 00 Prague 2<br/> 
                        Czech republic<br/> 
                      </address>";
            }?>
    </div>
    <div class="medium-3 columns text-center">
        <? if($lang=="CZ"){
             echo "<address>
                        <strong>Kontakt</strong><br>
                        Tel.: +420 226 200 400<br/> 
                        info@jedensvet.cz
                    </address>";
            }else{
                echo "<address>
                        <strong>Contact</strong><br>
                        Tel.: +420 226 200 400<br/> 
                        info@oneworld.cz
                      </address>";
            }?>                         
    </div>
    <div class="medium-3 columns text-center">
        <? if($lang=="CZ"){
            echo "<address>
                        <strong>Kontakt pro média</strong><br>
                        Zuzana Gruberová<br>
                        Tel.: +420 770 101 158<br/>
                        zuzana.gruberova@jedensvet.cz
                    </address>";
        }else{
            echo "<address>
                        <strong>Media Service</strong><br>
                        Zuzana Gruberova<br>
                        Tel.: +420 770 101 158<br/>
                        zuzana.gruberova@jedensvet.cz
                      </address>";
        }?>
    </div>
    <div class="medium-3 columns  text-center">
        <? include("included/partials/socialLinks.php");?> 
     </div> 
</div><!--row-->
