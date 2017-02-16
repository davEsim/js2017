<?
session_start();
ini_set('display_errors',0);
ini_set('display_startup_errors',0);
error_reporting(-1); // ukaze opravdu vse
//error_reporting(E-ALL);
if($_SERVER['HTTP_HOST']=="www.jedensvet.cz"){
	$lang =  "CZ";
	$prihlaseni = "prihlaseni";
}else{
	$lang = "EN";
	$prihlaseni = "login";
}


include_once("funcs.php"); 
spl_autoload_register('autoload_class_multiple_directory');
include_once("connection.php");

$user = new User($db);
if($_POST["userLogin"] && $_POST["userPsswd"] && empty($_POST["email"])){ // user vyplnil klasické přihlášení ... e-mail je skryté pole
		if($user->first_login()){
			if($_POST["backUrl"]){
				Header("Location: ".$_POST["backUrl"]);
			}else{
				Header("Location: /2016");
			}
		}else{
			Header("Location:/2016/$prihlaseni");	
		}
}else{ // user se odhlašuje
		$user->logout();
		Header("Location: /2016");
}

?> 

