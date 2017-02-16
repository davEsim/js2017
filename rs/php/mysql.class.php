<?php

class tMysql {
  var $dbPassword,
      $dbUser,
      $dbName,
      $dbServer,
      $conn,
      $result,
      $err_handler = false,
      $log_query = false,
      $insert_addslashes = true;
  
  function err($r="", $q="", $e="") {
    if ($this->err_handler) {
      $err_handler = $this->err_handler;
      $err_handler($r, $q, $e);
    } else {
      echo "<code class=\"mysql-error\">MYSQL<br> ";
      if ($r) echo "[$r] ";
      if ($q) echo "Dotaz:$q <br>";
      if ($e) echo "Chyba:$e ";
      echo "</code><br />";
    };
  }
  
  function connect() {
    ($this->conn = mysql_connect($this->dbServer, $this->dbUser, $this->dbPassword)) or $this->err("", "mysql_connect", mysql_error($this->conn));
    ($db = mysql_select_db($this->dbName, $this->conn)) or $this->err("", "mysql_select_db", mysql_error($this->conn));
    return ($this->conn and $db); 
  }

  function query($r, $q) {
    $sr = mysql_query($q, $this->conn);	
    if ($sr) {	
      if ($r) $this->result[$r] = $sr;
      if ($this->log_query) $this->err($r, $q);
    } else $this->err($r, $q, mysql_error($this->conn));
    return($sr);
  }

  function query_result($q, $line=0, $r=0) {
    $sr = $this->query(0, $q);            // proved sql dotaz
    if ($sr) {                            // pokud je nejaky vysledek
      if (mysql_num_rows($sr) > 0) {
        if (!$r) $ret=mysql_result($sr, $line);// vrat hodnotu výsledku
        else $ret=mysql_result($sr, $line, $r);
        mysql_free_result($sr);           // uvolni výsledek
        return($ret);
      } else {
        mysql_free_result($sr);           // uvolni výsledek
        return(null);
      };
    } else return(null);
  }

  function query_result_all($q, $r=0) {
    $sr = $this->query(0, $q);
    if ($sr) {
      $ret = array();
      $c = mysql_num_rows($sr);
      for($i = 0; $i < $c; $i++)
       $ret[] =  ($r ? mysql_result($sr, $i, $r) : mysql_result($sr, $i));
      mysql_free_result($sr);
      return($ret);
    } else return(null);
  }

  function update ($tbl, $cols, $where = "") {
    $s_set = "";
    while(list($k, $v) = each($cols)) {
      if ($s_set != "") $s_set .= ", ";
      $s_set .= "$k='".($this->insert_addslashes ? addslashes($v) : $v)."'";
    };
    $this->query("", "UPDATE $tbl SET $s_set ".($where != "" ? "WHERE $where" : ""));
  }
  
  function insert ($tbl, $cols) {
    $s_set = "";
    while(list($k, $v) = each($cols)) {
      if ($s_set != "") $s_set .= ", ";
      $s_set .= "$k='".($this->insert_addslashes ? addslashes($v) : $v)."'";
    };
    $this->query(0, "INSERT INTO $tbl SET $s_set ");
  }
  
  function replace ($tbl, $cols) {
    $s_set = "";
    while(list($k, $v) = each($cols)) {
      if ($s_set != "") $s_set .= ", ";
      $s_set .= "$k='".($this->insert_addslashes ? addslashes($v) : $v)."'";
    };
    $this->query("", "REPLACE $tbl SET $s_set");
  }
  
  function fetch_assoc($r){
    if ($this->result[$r]) return (mysql_fetch_assoc ($this->result[$r]));
                      else $this->err($r, "", "no result");
  }
  
  function query_fetch_assoc($q){
    $sr = $this->query(0, $q);
    if ($sr) {
      $ret = mysql_fetch_assoc($sr);
      mysql_free_result($sr);
      return($ret);
    } else return(null);
  }

  function query_fetch_assoc_all($q, $index=0){
    $sr = $this->query(0, $q);
    while($row = mysql_fetch_assoc ($sr)) {
      if ($index) $ret[$row[$index]] = $row;
             else $ret[] = $row;
    };
    return($ret);
  }

  function num_rows($r){
    if ($this->result[$r]) return (mysql_num_rows ($this->result[$r]));
                      else $this->err($r, "->num_rows", "no '$r' result");
  }
  
  function result($r, $f, $row = 0){
    if ($this->result[$r]) return mysql_result ($this->result[$r], $row, $f);
                      else $this->err($r, "->result", "no '$r' result");
  }

  function free_result($r){
    if ($this->result[$r]) mysql_free_result ($this->result[$r]);
      unset($this->result[$r]);
  }
  
  function close() {
    mysql_close($this->conn);
  }

  function insert_id(){
    return mysql_insert_id ($this->conn);
  }
  
  function conf($a) {
    while(list($k, $v) = each($a)) {
      $this->$k = $v;
    };
  }

};

?>
