<?
class Items{
    protected  $db;
    protected  $table;
    protected  $path;

    function __construct($db, $table){
        $this->db=$db;
        $this->table=$table;
    }

    public function getPath($id, $page=""){
		$r=$this->findById($id);
		$routing = $_ENV["routing"]; 
		$lang = $_ENV["lang"];
		if($page){ // chci skákat jinam
			$path=$_ENV["serverPath"].$page."/".$id."-".string2domainName($r[$routing["metaTitle"]]);
		}elseif($page=$this->pagePath($lang)){ // chci skákat na implicitní stránku
			$path=$_ENV["serverPath"].$page."/".$id."-".string2domainName($r[$routing["metaTitle"]]);
		}else{ // zůstávám na stránce kde jsem
			$path=$_ENV["serverPath"].$_ENV["page"]."/".$id."-".string2domainName($r[$routing["metaTitle"]]);
		}
		return $path;
    }

    public function findById($id){
        $params=array(":id" => $id);
        $r=$this->db->queryOne("SELECT * FROM $this->table WHERE id=:id", $params);
        return $r;
    }

    public function listOne($where="",$orderBy="id", $direction="DESC"){
        if($where) $where="WHERE ".$where;
        $r=$this->db->queryOne("SELECT * FROM $this->table $where ORDER BY $orderBy $direction");
        return $r;
    }

    public function listing($where="",$orderBy="id", $direction="DESC", $from=0, $count=6){
        if($where) $where="WHERE ".$where;
        if($count==0) $limit=""; else $limit="LIMIT $from, $count";
        $r=$this->db->queryAll("SELECT * FROM $this->table $where ORDER BY $orderBy $direction $limit");
        return $r;
    }

    public function listingWhereLike($whereCol="", $whereLike="", $orderBy="id", $direction="DESC", $from=0, $count=6){
        $params=array(":like"=>$whereLike);
        if($count==0) $limit=""; else $limit="LIMIT $from, $count";
        $r=$this->db->queryAll("SELECT * FROM $this->table WHERE $whereCol LIKE :like  ORDER BY $orderBy $direction $limit", $params);
        //$r->debugDumpParams();
        return $r;

    }

    // vytahne jen data ze vztahu 1:N
	
    public function getRelRow($id, $relTable){
        $params=array(":id" => $id);
        $r=$this->db->queryOne("SELECT * FROM $relTable WHERE id=:id", $params);
        return $r;
    }
	
    public function getRelCol($id, $relTable, $col){
        $params=array(":id" => $id);
        $r=$this->db->queryOne("SELECT $col FROM $relTable WHERE id=:id", $params);
        return $r[$col];
    }

    public function hasItemsInRelations($id, $relTable){
        $params=array(":id" => $id);
        $relationsTable=$relTable."_".$this->table;
        $r=$this->db->query("SELECT * FROM $relationsTable WHERE id_$this->table=:id", $params);
        return $r;
    }

    public function findItemsInRelations($id, $relTable){
        $relationsTable=$this->table."_".$relTable;
        $params=array(":id" => $id);
        $r=$this->db->queryAll("SELECT * FROM $relTable AS t
                                INNER JOIN $relationsTable AS rt
                                ON t.id=rt.id_$relTable
                                WHERE rt.id_$this->table = :id"
            , $params);

        return $r;
    }

    public function listingByRelation($id, $relTable){
        $relationsTable=$this->table."_".$relTable;
        $params=array(":id" => $id);
        $r=$this->db->queryAll("SELECT t.* FROM $this->table AS t
                                INNER JOIN $relationsTable AS rt
                                ON t.id=rt.id_$this->table
                                WHERE rt.id_$relTable = :id"
            , $params);
        return $r;
    }

    public function listingByRelations($relations, $orderBy="id DESC"){
        $query="SELECT t.* FROM $this->table AS t";
        $i=0;
        $where="";
        foreach($relations AS $relValue => $relTable){
            $relationsTable=$this->table."_".$relTable;
            $query.="
                             INNER JOIN $relationsTable AS rt$i
                             ON t.id=rt$i.id_$this->table";
            if(!$i) $where=" WHERE rt$i.id_$relTable = ?";
            else $where.="   AND rt$i.id_$relTable = ?";

            $i++;
        }
        $query.=$where." ORDER BY ".$orderBy;
        //echo $query;
        $params=array_keys($relations);
        $r=$this->db->queryAll($query, $params);
        return $r;
    }
}
?>