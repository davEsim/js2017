<?
session_start();
include "../../included/exts/fb/src/Facebook/autoload.php"; 
include_once("../classes/dbPdo.class.php");
include_once("../connection.php");

if($_SERVER['HTTP_HOST']=="www.jedensvet.cz"){
  define('FACEBOOK_APP_ID', '133522613372783');
  define('FACEBOOK_SECRET', '7679d4139e58b1ef40b281ef3c79aa13');
  $lang = "CZ";
}else{
  define('FACEBOOK_APP_ID', '145652585486286');
  define('FACEBOOK_SECRET', 'bb21ca04789d1bdb09dbc0bfd800b72a');
  $lang = "EN";
}

$fb = new Facebook\Facebook([
  'app_id' => FACEBOOK_APP_ID,
  'app_secret' => FACEBOOK_SECRET,
  'default_graph_version' => 'v2.4',
]);
if($_GET["logout"] == 1){
	$_SESSION = array(); 
	session_destroy();
	Header("Location: /2016");
}else{
	
	$helper = $fb->getRedirectLoginHelper();
	try {
	  $accessToken = $helper->getAccessToken();
	  $response = $fb->get('/me?fields=id,email', $accessToken);
	} catch(Facebook\Exceptions\FacebookResponseException $e) {
	  echo 'Graph returned an error: ' . $e->getMessage();
	  exit;
	} catch(Facebook\Exceptions\FacebookSDKException $e) {
	  echo 'Facebook SDK returned an error: ' . $e->getMessage();
	  exit;
	}
	
	if (isset($accessToken)) {
	  // Logged in!
		$_SESSION['facebook_access_token'] = (string) $accessToken;
		$user = $response->getGraphUser();
		$_SESSION["userId"] = $user['id'];
		//$_SESSION["userName"] = $user['name'];
		$_SESSION["userMail"] = $user['email'];
		
		$params = array($_SESSION["userId"]);
		$countUsers = $db->query("SELECT id FROM visitorsFB WHERE id = ?", $params);
		if(!$countUsers){
			$params = array($_SESSION["userId"], $_SESSION["userMail"], date("Y-m-d H:s"), $lang);
			$db->query("INSERT INTO visitorsFB VALUES(?,?,?,?)", $params);
		}
	}
	Header("Location: http://".$_SERVER['HTTP_HOST']."/2016/".$_GET["page"]."");
}
?>