<?
class xDebates extends Items{
	protected $pagePath = array();
	
	public function pagePath($lang){
			$pagePath["CZ"] = "";
			$pagePath["EN"] = "";
		
		return $pagePath[$lang];
	}	

}
?>