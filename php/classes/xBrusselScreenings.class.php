<?
class xBrusselScreenings extends Items{
	
	/*
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
	*/
	function listingByDate(){
		$r = $this->db->queryAll("	SELECT *, f.id AS fid, t.id AS sid FROM $this->table AS t
									LEFT JOIN xBrusselFilms AS f
									ON t.id_xBrusselFilms = f.id
									LEFT JOIN xBrusselPlaces AS p
									ON t.id_xBrusselPlaces = p.id
									ORDER BY t.date ASC, t.time ASC
									");
		return $r;
	}
	
    public function findByUid($uid){
        $params=array(":uid" => $uid);
        $r=$this->db->queryOne("SELECT * FROM $this->table WHERE uid=:uid", $params);
        return $r;
    }
	
	public function countOfViewers($screenId){
		$params = array(":screenId" => $screenId);
		$r = $this->db->query("SELECT id FROM xBrusselViewers WHERE id_xBrusselScreenings = :screenId", $params);
		return $r;	
	}
}
?>