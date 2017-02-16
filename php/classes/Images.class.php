<?
class Images extends Items{
	
	public function getAllForItem($table, $itemId){
		
		$r=$this->db->queryAll("SELECT i.* FROM media AS i
								INNER JOIN mediaTables AS it ON i.id=it.id_media 
								INNER JOIN flagsTables as ft ON it.id_flagsTables=ft.id
								 WHERE ft.tableDbName='$table'
								 AND idInTable='$itemId'
								 AND i.ext IN ('jpg', 'gif', 'png')
								 ORDER BY it.sequence DESC");
								 	
		return $r;
	}
}
?>