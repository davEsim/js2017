<?
class xNews extends Items{
	
	protected $pagePath = array();
	
	public function pagePath($lang){
		$pagePath["CZ"] = "novinky";
		$pagePath["EN"] = "news";
		
		return $pagePath[$lang];
	}	

}
?>