<?
$routing = array();
if($page == "novinky" || $page == "news") $routing = array("template" => "xNews", "metaTable" => "xNews", "metaTitle" => "title$lang", "metaDescr" => "text$lang");
if(strstr($page,"-novinky") || strstr($page,"-news")) $routing = array("template" => "xNewsRegions", "metaTable" => "xNews", "metaTitle" => "title$lang", "metaDescr" => "text$lang");
if($page == "hoste" || $page == "guests") $routing = array("template" => "xGuests", "metaTable" => "xGuests", "metaTitle" => "title$lang", "metaDescr" => "text$lang");
if($page == "filmy-a-z" || $page == "films-a-z") $routing =  array("template" => "xFilms", "metaTable" => "xFilms", "metaTitle" => "title$lang", "metaDescr" => "synopsys$lang", "extraJS" => "filmsAZ");
if($page == "program-po-dnech" || $page == "daily-programme") $routing =  array("template" => "xScreenings", "metaTable" => "", "metaTitle" => "title$lang", "metaDescr" => "");
if($page == "program-kin" || $page == "cinemas") $routing =  array("template" => "xScreeningsTheatres", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
if($page == "tematicke-kategorie" || $page == "thematic-categories") $routing =  array("template" => "xFilmThemes", "metaTable" => "xFilmThemes", "metaTitle" => "name$lang", "metaDescr" => "text$lang");
if($page == "panelove-debaty" || $page == "panel-debates") $routing =  array("template" => "xDebates", "metaTable" => "xDebates", "metaTitle" => "title$lang", "metaDescr" => "text$lang", "filtrParam" => "panelová");
if($page == "masterclasses" || $page == "masterclasses") $routing =  array("template" => "xDebates", "metaTable" => "xDebates", "metaTitle" => "title$lang", "metaDescr" => "text$lang", "filtrParam" => "režisérská");
if($page == "hlavni-porota" || $page == "grand-jury") $routing =  array("template" => "xJuryMembers", "metaTable" => "xJuryMembers", "metaTitle" => "name$lang", "metaDescr" => "descr$lang", "filtrParam" => 1);
if($page == "porota-vaclava-havla" || $page == "vaclav-havel-jury") $routing =  array("template" => "xJuryMembers", "metaTable" => "xJuryMembers", "metaTitle" => "name$lang", "metaDescr" => "descr$lang", "filtrParam" => 2);
if($page == "porota-ceskeho-rozhlasu" || $page == "czech-radio-jury") $routing =  array("template" => "xJuryMembers", "metaTable" => "xJuryMembers", "metaTitle" => "name$lang", "metaDescr" => "descr$lang", "filtrParam" => 3);
if($page == "studentska-porota" || $page == "students-jury") $routing =  array("template" => "xJuryMembers", "metaTable" => "xJuryMembers", "metaTitle" => "name$lang", "metaDescr" => "descr$lang", "filtrParam" => 4);
if($page == "tym" || $page == "team") $routing = array("template" => "xTeamMembers", "metaTable" => "xTeamMembers", "metaTitle" => "name$lang", "metaDescr" => "positionCZ");
if(strstr($page,"-kontakt-tym")) $routing = array("template" => "xRegionTeamMembers", "metaTable" => "xRegionTeamMembers", "metaTitle" => "name$lang", "metaDescr" => "positionCZ");
if($page == "regiony" || $page == "regions") $routing = array("template" => "xRegions", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
if($page == "o-festivalu" || $page == "about-festival") $routing = array("template" => "aboutFestival", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
if($page == "o-poradateli" || $page == "organiser") $routing = array("template" => "aboutOrganiser", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
if($page == "vizual-ke-stazeni" || $page == "download-poster") $routing = array("template" => "visual", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
if($page == "partneri" || $page == "partners") $routing = array("template" => "xPartners", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");



if($page == "registrace" || $page == "registration") $routing = array("template" => "visitorRegistration", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
if($page == "prihlaseni" || $page == "login") $routing = array("template" => "visitorLogin", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
if($page == "zmena-hesla" || $page == "change-password") $routing = array("template" => "visitorChangePsswd", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");

if($page == "jeden-svet-pro-vsechny") $routing = array("template" => "OWForAll", "metaTable" => "", "metaTitle" => "", "metaDescr" => "");
//print_r($routing);

?>  

