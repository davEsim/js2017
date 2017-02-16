<?
class xBrusselViewers extends Items{
	
	
    public function findByUid($uid){
        $params=array(":uid" => $uid);
        $r=$this->db->queryOne("SELECT * FROM $this->table WHERE uid=:uid", $params);
        return $r;
    }
	
	public function delReservation($uid){
        $params=array(":uid" => $uid);
        $r=$this->db->query("DELETE FROM $this->table WHERE uid=:uid", $params);
		return $r;	
	}
	
}
?>