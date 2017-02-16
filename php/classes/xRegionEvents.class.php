<?
class xRegionEvents extends Items{
	
	public function types($regionCity){
		$params = array(":regionCity" => "$regionCity%");
		$r = $this->db->queryAll("	SELECT * FROM $this->table AS t
									INNER JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									LEFT JOIN xRegionEventTypes AS et
									ON t.id_xRegionEventTypes = et.id
									WHERE p.xRegionPlaces LIKE :regionCity
									GROUP BY id_xRegionEventTypes",
									$params);
		return $r;							
	}
	public function newest($regionCity){
		$params = array(":regionCity" => "$regionCity%");
		$r = $this->db->queryAll("	SELECT *, t.id AS eid FROM $this->table AS t
									INNER JOIN xRegionPlaces AS p
									ON t.id_xRegionPlaces = p.id
									LEFT JOIN xRegionEventTypes AS et
									ON t.id_xRegionEventTypes = et.id
									WHERE p.xRegionPlaces LIKE :regionCity
									ORDER BY datumFrom ASC",
									$params);
		return $r;							
	}
	
}
?>