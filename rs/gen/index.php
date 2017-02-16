<?
include_once("../php/mysql.class.php");
include_once("../php/connection.php");
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Generátor databáze pro redakční systém</title>
  </head>
  <body>
  <h1>Generátor databáze pro redakční systém</h1>
  <? 
  	if($_POST["prefix"]!="")
	{
		$prefix=$_POST["prefix"]."_";
		
			  $queryDocs = sprintf("CREATE TABLE IF NOT EXISTS `%s` (
									`id` int(11) NOT NULL AUTO_INCREMENT,
									`docs` varchar(150) NOT NULL,
									`seo` varchar(150) NOT NULL,
									`ext` varchar(5) NOT NULL,
									PRIMARY KEY (`id`)
									) ENGINE=MyISAM DEFAULT CHARSET=utf8 AUTO_INCREMENT=1 ;",
									$prefix."docs"
								);
		$queryDocsTables = sprintf("CREATE TABLE IF NOT EXISTS `%s` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `id_docs` int(11) NOT NULL,
									  `id_flagsTables` int(11) NOT NULL,
									  `idInTable` int(11) NOT NULL,
									  `sequence` smallint(6) NOT NULL DEFAULT '0',
									  PRIMARY KEY (`id`)
									) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;",
									$prefix."docsTables"
								);
			$queryFlags = sprintf("CREATE TABLE IF NOT EXISTS `%s` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `tableName` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
									  `colDbName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
									  `colWebName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
									  `descr` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
									  `inputSize` int(11) NOT NULL DEFAULT '0',
									  `sequence` int(11) NOT NULL DEFAULT '0',
									  PRIMARY KEY (`id`)
									) ENGINE=MyISAM  DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='popisky' AUTO_INCREMENT=1 ;",
									$prefix."flags"
								);
	  $queryFlagsTables = sprintf("CREATE TABLE IF NOT EXISTS `%s` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `tableDbName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
									  `tableWebName` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
									  `pdf` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
									  `img` enum('0','1') COLLATE utf8_unicode_ci NOT NULL DEFAULT '0',
									  `imgSmallSize` int(11) NOT NULL DEFAULT '200',
									  `imgSize` int(11) NOT NULL DEFAULT '700',
									  PRIMARY KEY (`id`)
									) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci COMMENT='metadata; pole pdf a img urcuji zda se v RS daji pridat' AUTO_INCREMENT=1",
									$prefix."flagsTables"
						  		);
			$queryGroups = sprintf("CREATE TABLE IF NOT EXISTS `%s` (
									  `id` int(11) NOT NULL AUTO_INCREMENT,
									  `groups` varchar(255) NOT NULL,
									  PRIMARY KEY (`id`)
									) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci AUTO_INCREMENT=1 ;",
									$prefix."groups"
						  		);
 $queryGroupsFlagsTables = sprintf("CREATE TABLE IF NOT EXISTS `%s` (
									  `id_groups` int(11) NOT NULL,
									  `id_flagsTables` int(11) NOT NULL,
									  KEY `id_groups` (`id_groups`),
									  KEY `id_flagsTables` (`id_flagsTables`)
									) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ciAUTO_INCREMENT=1;",
									$prefix."groups_flagsTables"
						  		);

	}else{
		?>
        	<form method="post">
            	Prefix pro systémové tabulky: <input type="text" name="prefix" value="rs" />
                <input type="submit" name="generovat" />
            </form>
        <?	
	}
  ?>
  </body>
</html>