<?
// začátek třídy login
class User 
{
	private $db;
	private $userLogin;
	private $userPsswd;
	private $session_login_string;
	private $ip;
	const	TABLE = "visitors";
		
	public function __construct($db)
	{
		$this->db=$db;
		if (isset($_POST["userLogin"]))
		{
			$this->userLogin=$_POST["userLogin"];
		}else{
			$this->userLogin=$_SESSION["userLogin"];
		}
		$this->userPsswd=$_POST["userPsswd"];
		$this->session_login_string=$_SESSION["session_login_string"];
		$this->ip=$_SERVER["REMOTE_ADDR"];
	}
	
	// testování zda je uživatel již přihlášen
	public function logged() {
		$params = array(
						":sls" => $this->session_login_string,
						":userLogin" => $this->userLogin,
						":ip" => $this->ip
						);
		$user = $this->db->queryOne("SELECT id FROM ".self::TABLE." WHERE session = :sls AND userLogin = :userLogin AND ip = :ip)",$params);
		if ($user["id"]){
			$params = array(":id" => $user["id"]);
			$this->db->query("UPDATE ".self::TABLE." SET lastTime = now() WHERE id = :id", $params);
			return true;
		} else {
			return false;
		}
	}
	// přihlášení/odmítnutí uživatele
	public function first_login(){
		if (strlen($this->userLogin)>1){
			$params = array(
							":userLogin"	=> $this->userLogin, 
							":userPsswd" 	=> md5($this->userPsswd),
							":active" 		=> "ano"
							);										
			$user = $this->db->queryOne("SELECT * FROM ".self::TABLE." WHERE userLogin LIKE :userLogin AND userPsswd = :userPsswd AND active LIKE :active", $params);
			if ($user["id"]){ // korektní uživatel...provedu přihlášení
				session_regenerate_id();
				$this->session_login_string=md5(uniqid(rand()));
				$params = array(								
								":ip" 	=> $this->ip,
								":sls" 	=> $this->session_login_string,
								":id"	=> $user["id"]
								);
				$this->db->query("UPDATE ".self::TABLE." SET lastTime = now(), ip= :ip, session = :sls WHERE id = :id", $params);
				$this->loadVarsForWeb($user);
				return true;
			} else {
				//zobrazit hlasku o neduspesnem logovani
				return false;
			}
		} else {
			// nezadano username ...
			return false;
		}
	}
	private function loadVarsForWeb($user){
		//$_SESSION["userLogin"] = $this->userLogin;	
		$_SESSION["session_login_string"] = $this->session_login_string;
		$_SESSION["userId"] = $user['id'];
		//$_SESSION["userName"] = $user['name'];
		$_SESSION["userMail"] = $user['email'];
	}
	// odhlášení uživatele
	public function logout(){
		$params = array(
						":newSession"	=> md5(uniqid(rand())), 
						":session" 	=> $this->session_login_string,
						":ip" 		=> $this->ip
						);										
		$this->db->query("UPDATE ".self::TABLE." SET session=:newSession,  lastTime = now() WHERE session=:session AND ip=:ip", $params);
		$_SESSION = array(); 
		session_unset();
		session_destroy();
		
	}
	
}
?>
