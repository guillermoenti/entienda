<?php

session_start();

require("config.php");
require("template.php");

#Contenidos
$title = "ENTIenda";


$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);


if (!isset($_SESSION["id_user"])){

$content = <<<EOD
<form method="post" action="login_req.php">
<h2>Identificate</h2>

<p><label for="login-user">Usuario:</label> <input type="text" name="user" id="login-user" /></p>
<p><label for="login-pass">Contraseña:</label> <input type="password" name="pass" id="login-pass"/></p>

<p><input type="submit" id="login-submit" value="Login"/></p>

</form>
EOD;
}
else{

	$query = "SELECT * FROM users WHERE id_user=".$_SESSION["id_user"];

	$res = $conn->query($query);
	$user = $res->fetch_assoc();

	$content = <<<EOD
	<p id="greeting">Bienvenido/a, {$user["user"]}</p>
	EOD;

}
showHeader($title);

showContent($content);

showFooter();

?>
