<?
class xFilms extends Items{ 
	
	protected $pagePath = array();
	
	public function pagePath($lang){
		$pagePath["CZ"] = "filmy-a-z";
		$pagePath["EN"] = "films-a-z";
		
		return $pagePath[$lang];
	}	
	
	public function listingByTheme($themeId,$orderBy="id", $direction="DESC", $from=0, $count=6){
        if($count==0) $limit=""; else $limit="LIMIT $from, $count";
		$params=array(":themeId" => $themeId);
        $r=$this->db->queryAll("SELECT * FROM ".$this->table." AS t LEFT JOIN ".$this->table."_xFilmThemes AS ft ON t.id=ft.id_xFilms 
								WHERE type like 'Film' AND ft.id_xFilmThemes = :themeId
								ORDER BY $orderBy $direction $limit"
								, $params);
								
        return $r;
    }

	public function screenings($filmId){
		$params=array(":filmId" => $filmId);
		$lang = $_ENV["lang"];
        $r=$this->db->queryAll("SELECT s.*, t.theatreTitle$lang FROM xScreenings AS s 
								INNER JOIN xTheatres AS t 
								ON s.id_xTheatres=t.id
								WHERE id_xFilms=:filmId 
								ORDER BY date ASC, time ASC"
								, $params);								
        return $r;
		
	}
	
	public function screeningsWithPackages($filmIds){
		$lang = $_ENV["lang"];
        $r=$this->db->queryAll("SELECT s.*, t.theatreTitle$lang, t.address, t.addressEN, f.type, f.title$lang FROM xScreenings AS s
								INNER JOIN xTheatres AS t 
								ON s.id_xTheatres=t.id
								INNER JOIN xFilms AS f
								ON s.id_xFilms = f.id 
								WHERE id_xFilms IN ($filmIds)
								ORDER BY date ASC, time ASC"
								, $params=array());	
		return $r;
		
	}
	
	
	public function findPackages($filmId){
		$params=array(":filmId" => $filmId);
		$rs = "";
		$r=$this->db->queryAll("SELECT id_xPackages FROM xPackages WHERE id_xFilms = :filmId", $params);
		$rs=$filmId;
		foreach($r AS $row){
			$rs.=",".$row["id_xPackages"];	
		}
		return $rs;
	}
	
	public function getParams($filmId){
		$params=array(":filmId" => $filmId);
        $r=$this->db->queryOne("SELECT * FROM xFilmParams WHERE id = :filmId", $params);
		
		return $r; 
	}
	
}
?>