<?
// začátek třídy login
class Login 
{
	private $userLogin;
	private $userPsswd;
	private $session_login_string;
	private $ip;
	const 
		CHECKTIMELIMIT=14440,
		TABLE="users";
		
	public function __construct()
	{
		if (isset($_POST["login"]))
		{
			$this->userLogin=$this->escapeValue($_POST["login"]);
		}else{
			$this->userLogin=$_SESSION["userLogin"];
		}
		$this->userPsswd=$this->escapeValue($_POST["psswd"]);
		$this->session_login_string=$_SESSION["session_login_string"];
		$this->ip=$_SERVER["REMOTE_ADDR"];
	}
	
	// testování zda je uživatel již přihlášen
	public function logged() {
		$query = sprintf("SELECT id FROM %s WHERE session = '%s' AND userLogin = '%s' AND ip = '%s' AND lastTime>=DATE_SUB(now(),INTERVAL %s SECOND)",
						self::TABLE,
						$this->session_login_string,
						$this->userLogin,
						$this->ip,
						self::CHECKTIMELIMIT
						);
		$query = @MySQL_Query($query);				
		if (@MySQL_Num_Rows($query)==1){
			$result= MySQL_Fetch_Array($query);
			$query = sprintf("UPDATE %s SET lastTime = now() WHERE id = '%s'",
						self::TABLE,
						$result["id"]
						);
			@MySQL_Query($query);
			return true;
		} else {
			return false;
		}
	}
	// přihlášení/odmítnutí uživatele
	public function first_login(){
		if (strlen($this->userLogin)>1){
			$query = sprintf("SELECT * FROM %s WHERE userLogin LIKE '%s' AND userPsswd LIKE '%s' AND active LIKE 'yes'",
							self::TABLE,
							$this->userLogin,
							md5($this->userPsswd)
							);
			$query=@MySQL_Query($query);
			if (@MySQL_Num_Rows($query)==1){ // korektní uživatel...provedu přihlášení
				session_regenerate_id();
				$result= MySQL_Fetch_Array($query);
				$this->session_login_string=md5(uniqid(rand()));
				
				$query = sprintf("UPDATE %s SET lastTime = now(), ip= '%s', session = '%s' WHERE id = '%s'",
								self::TABLE,
								$this->ip,
								$this->session_login_string,
								$result["id"]
								);
				@MySQL_Query($query);
					
				$_SESSION["userLogin"] = $this->userLogin;	
				$_SESSION["session_login_string"] = $this->session_login_string;
				$_SESSION["userId"]=$result["id"];
				$_SESSION["userFullName"] = $result["firstName"]." ".$result["secondName"];	
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
	// odhlášení uživatele
	public function logout(){
		$query="UPDATE $this->table SET session='".md5(uniqid(rand()))."' WHERE session='".$this->session_login_string."' and ip='$this->ip'";
		$result = mysql_query($query);
		session_unset();
		session_destroy();
	}
	
	private function escapeValue( $value )
	{
		if( get_magic_quotes_gpc() )
		{
			  $value = stripslashes( $value );
		}
		//check if this function exists
		if( function_exists( "mysql_real_escape_string" ) )
		{
			  $value = mysql_real_escape_string( $value );
		}
		//for PHP version < 4.3.0 use addslashes
		else
		{
			  $value = addslashes( $value );
		}
		return $value;
	} 
}
?>
