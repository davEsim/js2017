<?
/*
echo "jo";
echo $_SERVER["REQUEST_URI"];
$uid=substr($_SERVER["REQUEST_URI"],strrpos($_SERVER["REQUEST_URI"], "/"));
*/
$uid=$itemId;

$result=$db->query("SELECT * FROM newsletters WHERE uid LIKE :uid", array(":uid" => $uid));
if($result==1){
    $db->query("UPDATE newsletters SET active=:active WHERE uid LIKE :uid", array(":active" => 1, ":uid" => $uid));
    echo "<p>Váše e-mailová adresa je nyní aktivní v rámci rozesilání našich novinek</p><p>Děkujeme, vaše Varianty</p>";
}else{
    echo "<p>Nepodařilo se potvrdit vaší e-mail adresu</p>";
}
?>



