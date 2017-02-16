<?
class xRegionScreenings extends Items{
	
	function days($regionCity){
		$r = $this->db->queryAll("	SELECT * FROM $this->table AS t
									LEFT JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									WHERE  p.xRegionPlaces LIKE '$regionCity%'
									AND t.lang LIKE '".$_ENV["lang"]."'
									GROUP BY date
									");
									
		return $r;
	}
	
	function allDays(){
		$r = $this->db->queryAll("	SELECT * FROM $this->table AS t
									LEFT JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									WHERE t.lang LIKE '".$_ENV["lang"]."'
									GROUP BY date
									");
									
		return $r;
	}
	
	function places($regionCity){
		$r = $this->db->queryAll("	SELECT * FROM $this->table AS t
									LEFT JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									WHERE  p.xRegionPlaces LIKE '$regionCity%'
									AND t.lang LIKE '".$_ENV["lang"]."'
									GROUP BY p.id
									");
		return $r;
	}
	
	
	function listingByDate($regionCity){
		$r = $this->db->queryAll("	SELECT *, f.id AS fid, t.id AS sid FROM $this->table AS t
									LEFT JOIN xFilms AS f
									ON t.id_xFilms = f.id
									LEFT JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									WHERE  p.xRegionPlaces LIKE '$regionCity%'
									AND t.lang LIKE '".$_ENV["lang"]."'
									ORDER BY t.date ASC, t.time ASC
									");
		return $r;
	}
	
	function allListingByDate($date){
		$params = array(":date" => $date, ":lang" => $_ENV["lang"]);
		$r = $this->db->queryAll("	SELECT *, f.id AS fid, t.id AS sid FROM $this->table AS t
									LEFT JOIN xFilms AS f
									ON t.id_xFilms = f.id
									LEFT JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									WHERE t.lang LIKE :lang
									AND t.date LIKE :date
									ORDER BY t.time ASC
									LIMIT 0,50
									", $params);
		return $r;
	}
	
	function listingByFilm($filmId){
		$params = array(":filmId" => $filmId, ":lang" => $_ENV["lang"]);
		$r = $this->db->queryAll("	SELECT *, f.id AS fid, t.id AS sid FROM $this->table AS t
									LEFT JOIN xFilms AS f
									ON t.id_xFilms = f.id
									LEFT JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									WHERE t.lang LIKE :lang
									AND t.id_xFilms = :filmId
									ORDER BY t.date ASC
									", $params);
		return $r;
	}
}
?>