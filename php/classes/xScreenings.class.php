<?
class xScreenings extends Items{
	
	protected $pagePath = array();
	
	public function pagePath($lang){
		$pagePath["CZ"] = "filmy-a-z";
		$pagePath["EN"] = "films-a-z";
		
		return $pagePath[$lang];
	}
	
	public function filmDetailLink($id_film, $title, $lang){
		$link=$this->pagePath($lang);
		$link.="/".$id_film."-";
		$link.=string2domainName($title);
		return $link;
	}

    public function dateTimeRunOut($screeningDate, $screeningTime){
        list($year, $month, $day) = explode("-", $screeningDate);
        list($hours, $mins, $secs) = explode(":", $screeningTime);
        $screenTimeStamp = mktime($hours, $mins, $secs, $month, $day, $year);
        if($screenTimeStamp < time()) { // runOut
            return true;
        }else{
            return false;
        }
    }

    public function inflictions($infliction){
        $params = array(":infliction" => "%".$infliction."%");
        $r=$this->db->queryAll("SELECT * FROM ".$this->table." AS s
                                INNER JOIN xInflictionScreenings AS inflS ON s.id = inflS.id
                                INNER JOIN xTheatres AS t ON s.id_xTheatres = t.id
                                INNER JOIN xFilms AS f ON s.id_xFilms = f.id
                                WHERE inflS.icons LIKE :infliction
                                ORDER BY date ASC, s.time ASC", $params);

        return $r;
    }
		
	public function dates(){
        $r=$this->db->queryAll("SELECT date FROM ".$this->table."
								GROUP BY date  
								ORDER BY date ASC");
        return $r;
    }
	
	public function theatres(){
        $r=$this->db->queryAll("SELECT * FROM xTheatres
								ORDER BY sequence ASC");
        return $r;
    }
	
	public function listingByDay($date){
        $r=$this->db->queryAll("SELECT *,t.id AS sid, f.id AS fid FROM ".$this->table." AS t
								INNER JOIN xFilms AS f
								ON t.id_xFilms = f.id
								INNER JOIN xTheatres AS th
								ON t.id_xTheatres=th.id
								WHERE date='$date'  
								ORDER BY th.id ASC, t.date ASC, t.time ASC");
        return $r;
    }
	
	public function listingByTheatre($id_theatre){
        $r=$this->db->queryAll("SELECT t.*, f.id AS fid, t.id AS sid, f.titleEN, f.titleCZ, f.TITLE_ORIGINAL, f.type FROM ".$this->table." AS t	
								INNER JOIN xFilms AS f
								ON t.id_xFilms = f.id
								WHERE id_xTheatres='$id_theatre' 
								ORDER BY date ASC, time ASC");
        return $r;
    }
	
	public function packageFilms($id_package){
        $r=$this->db->queryAll("SELECT * FROM xPackages AS p	
								INNER JOIN xFilms AS f
								ON p.id_xFilms = f.id
								WHERE p.id_xPackages='$id_package' 
								ORDER BY p.sort ASC");
        return $r;
	}
	
	public function debateGuests($id_screening){
        $r=$this->db->queryAll("SELECT * FROM xDebateGuests	
								WHERE id_xScreenings = '$id_screening'
								ORDER BY id ASC");
								
		/*
		if(count($r)){																// tohle je fujky...ale nechci to zneprehlednovat v template ani na to psat helper
			foreach($r AS $theatreScreeningGuest){
				$debateGuestsString.= $theatreScreeningGuest["position"].": ".$theatreScreeningGuest["fName"]." ".$theatreScreeningGuest["sName"]."<br>";	
			}
		}else{
			$debateGuestsString="";	
		}
						
        return $debateGuestsString;
		*/
		return $r;
	}

}
?>