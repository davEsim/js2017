<?
include_once("../../data/private/2017/config.php");
?>
<!doctype html> 
<html class="no-js" lang="<?=($lang == "CZ")?"cs":"en";?>" xmlns="https://www.w3.org/1999/xhtml"
      xmlns:og="https://opengraphprotocol.org/schema/">
  <head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title><?=($metaTitle)?$metaTitle." &mdash; ".$title:$title?></title>
    <meta name="description" content="<?=$metaDescr?>" />
    <meta property="fb:app_id" content="<?=FACEBOOK_APP_ID?>"/> 
    <meta property="og:title" content="<?=($metaTitle)?$metaTitle." - ".$title:$title?>" />
    <meta property="og:site_name" content="<?=$title?>" />
    <meta property="og:description" content="<?=$metaDescr?>" /> 
	<meta property="og:image" content="<?=$imgPath?>" /> 
	<meta property="og:url" content="<?=$_ENV["host"].$_SERVER['REQUEST_URI']?>" />
    <meta name='robots' content='index,follow'/>
    <meta name='googlebot' content='index,follow,snippet,archive'/>
    <meta name="verify-v1" content="zYH+r0PyxjQQ1ESkUnbymoSfSIYrMZGraEA+mo6O/dA=" />
    <meta name="google-site-verification" content="PrgYPlyYJw5C95NiODh9xMtBHUQFug_9s7kYd-ZmfNY" />
    <link rel="shortcut icon" href="<?=$_ENV["serverPath"]?>imgs/layout/favicon.ico">
    <link rel="icon" type="image/png" href="<?=$_ENV["serverPath"]?>imgs/layout/favicon-32x32.png" sizes="32x32" />
	<link rel="icon" type="image/png" href="<?=$_ENV["serverPath"]?>imgs/layout/favicon-16x16.png" sizes="16x16" />

    <link rel="stylesheet" href="<?=$_ENV["serverPath"]?>assets/css/app.css?v=<?=filemtime('assets/css/css/app.css') ?>" />
    <link rel="stylesheet" href="<?=$_ENV["serverPath"]?>stylesheets/foundation-icons/foundation-icons.css" />
    <link rel="stylesheet" href="https://cdn.linearicons.com/free/1.0.0/icon-font.min.css">
    <link rel="stylesheet" href="<?=$_ENV["serverPath"]?>stylesheets/css.css?v=<?=filemtime('stylesheets/css.css') ?>" />
    <!--
    <link rel="stylesheet" href="<?=$_ENV["serverPath"]?>stylesheets/final.css?v=<?=filemtime('stylesheets/final.css') ?>" />

    <link rel="stylesheet" href="<?=$_ENV["serverPath"]?>stylesheets/cssNoPrint.css?v=<?=filemtime('stylesheets/cssNoPrint.css') ?>" media="print" />

    <link rel="stylesheet" href="<?=$_ENV["serverPath"]?>stylesheets/jquery.powertip.css" />

    <script src="<?=$_ENV["serverPath"]?>js/jquery.powertip.min.js"></script>
      -->

    <!-- share start --> 
    <script type="text/javascript" src="//s7.addthis.com/js/300/addthis_widget.js#pubid=ra-56af40e1d9e46c51" async="async"></script>
    <!-- share end - start -->
    <!-- AddEvent -->
	<script type="text/javascript" src="https://addevent.com/libs/atc/1.6.1/atc.min.js"></script>
    <!-- AddEvent - end -->
    <? //if($title == "regiony"){?>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyCRPOLK_IVptgP_ri5zcCg1ywKpelEkLd0" type="text/javascript"></script>
	<script type="text/javascript" src="<?=$_ENV["serverPath"]?>js/googleMaps.js?v=<?=filemtime("js/googleMaps.js")?>"></script>
    <? //} ?>
    <!-- Facebook Pixel krávovina -->
	<script>
    !function(f,b,e,v,n,t,s){if(f.fbq)return;n=f.fbq=function(){n.callMethod?
    n.callMethod.apply(n,arguments):n.queue.push(arguments)};if(!f._fbq)f._fbq=n;
    n.push=n;n.loaded=!0;n.version='2.0';n.queue=[];t=b.createElement(e);t.async=!0;
    t.src=v;s=b.getElementsByTagName(e)[0];s.parentNode.insertBefore(t,s)}(window,
    document,'script','//connect.facebook.net/en_US/fbevents.js');
    fbq('init', '238559023013397');
    fbq('track', "PageView");</script>
    <noscript><img height="1" width="1" style="display:none"
    src="https://www.facebook.com/tr?id=238559023013397&ev=PageView&noscript=1"
    /></noscript>
    <!-- End Facebook Pixel -->
    <!-- Begin Cookie Consent plugin by Silktide - https://silktide.com/cookieconsent -->
	<script type="text/javascript">
        window.cookieconsent_options = {"message":" <?=__("Tyto webové stránky používají k poskytování služeb, personalizaci reklam a analýze návštěvnosti soubory cookie. Používáním těchto webových stránek souhlasíte s použitím souborů cookie")?>. ","dismiss":"<?=__("Rozumím")?>","learnMore":"More info","link":null,"theme":"dark-bottom"};
    </script>
    <script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/cookieconsent2/1.0.9/cookieconsent.min.js"></script>
    <!-- End Cookie Consent plugin -->


  </head>
  <body onLoad="load()">

  <div id="ETR">
      <? include_once("included/partials/etr.php");?>
  </div>

  <div id="fb-root"></div>
      <script>(function(d, s, id) {
        var js, fjs = d.getElementsByTagName(s)[0];
        if (d.getElementById(id)) return;
        js = d.createElement(s); js.id = id;
        js.src = "//connect.facebook.net/cs_CZ/sdk.js#xfbml=1&version=v2.4";
        fjs.parentNode.insertBefore(js, fjs);
      }(document, 'script', 'facebook-jssdk'));
      </script>

	<div class="row show-for-medium-up" id="head">
    	<div class="medium-6 columns">
            <a title="home" id="logo" href="<?=$_ENV["relPath"]?>">
            	<img src="<?=$_ENV["serverPath"]?>imgs/layout/logo-<?=$_ENV["lang"]?>.png">
            </a>
        </div>
    	<div class="medium-1 columns">
            &nbsp;
        </div>
        <div class="medium-5 columns text-right show-for-medium" style="position:relative">
          	 <? // include("included/partials/socialLinks.php");	?>
              <img src="<?=$_ENV["serverPath"]?>imgs/layout/motto-<?=$_ENV["lang"]?>.png">
            <p id="lang" style="position: absolute; top:-.5em; right:0px; margin:0; padding: .5em; background-color: white; font-weight: 700">
                <?=($_ENV["lang"] == "CZ")?"<a href='https://www.oneworld.cz/2017'><span class='lnr lnr-sync' style='font-weight: 700'></span> English</a>":"<a href='https://www.jedensvet.cz/2017'><span class='lnr lnr-sync'></span> Česky</a>";?>
            </p>
        </div>
    </div><!--row-->

    <div class="row" id="mainMenu">
        <div class="title-bar" data-responsive-toggle="example-menu" data-hide-for="medium">
            <button class="menu-icon" type="button" data-toggle="example-menu"></button>
            <div class="title-bar-title">Menu</div>
        </div>
        <style>
            .wideMenuRegions{
                width: 800px !important;
            }
               .menu.vertical.wideMenuRegions>li{
                    width: 250px;
                    display: inline-block;
                }
                .menu.vertical.wideMenuRegions p{
                    padding: 1em; border-bottom: 1px solid #cacaca;
                }
                .menu.vertical.wideMenuRegions p:hover{
                    background-color: #cacaca;
                }
        </style>
        <div class="top-bar">
            <div class="top-bar-left">
                <ul class="menu vertical medium-horizontal" data-responsive-menu="accordion medium-dropdown">
                    <? generateMenu(7, TRUE, $_ENV["lang"]); ?>
                </ul>
            </div>
            <? if ($_ENV["lang"]=="CZ"){	?>
            <div class="top-bar-right">
                <ul class="menu horizontal inflictions">
                    <li>
                        <a href="<?=$_ENV["serverPath"]?>jeden-svet-pro-vsechny">
                            <img src="<?=$_ENV["serverPath"]?>imgs/icons/inflictions/vozik.svg">
                            <img src="<?=$_ENV["serverPath"]?>imgs/icons/inflictions/oko.svg">
                            <img src="<?=$_ENV["serverPath"]?>imgs/icons/inflictions/ruce.svg">
                            <img src="<?=$_ENV["serverPath"]?>imgs/icons/inflictions/ucho.svg">
                            <img src="<?=$_ENV["serverPath"]?>imgs/icons/inflictions/masky.svg">
                            <img src="<?=$_ENV["serverPath"]?>imgs/icons/inflictions/starik.svg">
                        </a>
                    </li>

                </ul>
            </div>
            <?}?>
        </div>

    </div><!--row-->

    <? if($page != "regiony"){?> 
    <div class="row" id="secondMenu">
        <div class="medium-12 columns">
        	<?
			$parents = parents($rActivePage["id"]);
			$renderRegionHomeTemplate = FALSE;
			$renderRegionTemplate = FALSE;
			if(in_array(11,$parents)){			// jsem na stránce (at už jeho titulka nebo podtránka) některého regionu (page Regiony =11)?
				if($parents[3]){
					 $_ENV["regionId"]=$parents[3]; // podstránka regionu
					 $renderRegionHomeTemplate = FALSE;
					 $renderRegionTemplate = TRUE;
				}else{
					 $_ENV["regionId"]=$rActivePage["id"]; // titulní strana regionu
					 $renderRegionHomeTemplate = TRUE;
					 $renderRegionTemplate = FALSE;
				}
				$regions = new xRegionCities($db, "xRegionCities");
				$region = $regions->findById($_ENV["regionId"]);
				$_ENV["regionSeo"]=$region["seo"];
				$_ENV["regionCity"]=$region["xRegionCities"];
				?>
                <div class="row">
                	<div class="medium-3 columns regionTitle">
                    	<a href="./<?=$region["seo"]?>"><h3><?=pageContentCol($_ENV["regionId"], "name$lang");?></h3></a>
                        <p><?=invertDatumFromDB($region["fromDate"],1)?> &ndash; <?=invertDatumFromDB($region["toDate"],1)?></p>
                    </div>

                    <div class="medium-9 columns">
						<? generateOneLevelMenu($_ENV["regionId"], true);?>
                	</div>
                </div>
                <?
			}else{								// nejsem v regionu
				generateOneLevelMenu($rActivePage["id"], false); 
			}
			?>
        </div>
    </div><!--row-->
    <? }?>
    <div id="<?=(!$_ENV["page"])?"frame":"inFrame"?>">

    <?
		if($template = $routing["template"]){
            include_once("included/templates/$template.php");
        }elseif($renderRegionHomeTemplate){
            include_once("included/homeRegion.php");
        }elseif($renderRegionTemplate){
            include_once("included/inRegion.php");
		}elseif($_ENV["page"]){
            include_once("included/in.php");
        }else{
            include_once("included/home.php");
        }
    ?>
    <? if($page!="partneri" && $page!="partners") include_once("included/partials/partners.php");?>
    <? include_once("included/partials/siteMap.php");?>
      
    <div id="foot">
        <? include_once("included/partials/foot.php");?>
        <? include_once("included/partials/sysFoot.php");?>
    </div>



    <script src="<?=$_ENV["serverPath"]?>assets/js/app.js"></script>
    <script type="text/javascript" src="<?=$_ENV["serverPath"]?>js/default.js?v=<?=filemtime("js/default.js")?>"></script>
    <script>lang = "<?=$lang?>"</script>
    <? if($routing["extraJS"]){?><script type="text/javascript" src="<?=$_ENV["serverPath"]?>js/<?=$routing["extraJS"]?>.js?v=4"></script><?}?>
    
	<!-- google tracker ------------------------------------------------------------- --> 
	<script src="https://www.google-analytics.com/urchin.js" type="text/javascript"></script> 
    <script type="text/javascript">
    _uacct = "UA-764708-4";
    urchinTracker();
    </script>
    
	<!-- google remarket ------------------------------------------------------------- --> 
	<script type="text/javascript">
    /* <![CDATA[ */
    var google_conversion_id = 1031056079;
    var google_conversion_label = "mbLfCO-LlhsQz9XS6wM";
    var google_custom_params = window.google_tag_params;
    var google_remarketing_only = true;
    /* ]]> */
    </script>
    <script type="text/javascript" src="//www.googleadservices.com/pagead/conversion.js">
    </script>
    <noscript>
    <div style="display:inline;">
    <img height="1" width="1" style="border-style:none;" alt="" src="//googleads.g.doubleclick.net/pagead/viewthroughconversion/1031056079/?value=0&amp;label=mbLfCO-LlhsQz9XS6wM&amp;guid=ON&amp;script=0"/>
    </div>
    </noscript>
    </div> <!-- frame -->
  </body>
</html>