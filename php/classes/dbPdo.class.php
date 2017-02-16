<?
class dbPdo{
    private $spojeni;

    function __construct($host,$user,$pass,$name){
        $options=array(
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8",
            PDO::ATTR_EMULATE_PREPARES => false
        );
        $this->spojeni= @new PDO("mysql:host=$host;dbname=$name",$user,$pass,$options);
    }
    function query($query,$param=Array()){
        $navrat=$this->spojeni->prepare($query);
        $navrat->execute($param);
        return $navrat->rowCount();
    }

    function queryOne($query,$param=Array()){
        $navrat=$this->spojeni->prepare($query);
        $navrat->execute($param);
        return $navrat->fetch(PDO::FETCH_ASSOC);
    }

    function queryAll($query,$param=Array()){
        $navrat=$this->spojeni->prepare($query);
        $navrat->execute($param);
        return $navrat->fetchAll(PDO::FETCH_ASSOC);
    }
}
?>