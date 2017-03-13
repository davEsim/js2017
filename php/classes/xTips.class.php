<?
class xTips extends Items{

    public function listingGroupAndRand($from=0, $count=6){

        if($count==0) $limit=""; else $limit="LIMIT $from, $count";
        $r=$this->db->queryAll("SELECT * FROM $this->table GROUP BY name ORDER BY RAND() $limit");
        return $r;
    }

}
?>