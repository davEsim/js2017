<?
class xFilmThemes extends Items{
	
	protected $pagePath = array();
	
	public function pagePath($lang){
		$pagePath["CZ"] = "tematicke-kategorie";
		$pagePath["EN"] = "thematic-categories";
		
		return $pagePath[$lang];
	}
}
?>