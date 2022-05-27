<?php

session_start();

require("config.php");
require("template.php");

#Contenidos
$title = "ENTIenda";


//$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);



$content = <<<EOD
<form method="post" action="register_req.php">
<h2>Registrate</h2>

<p><label for="register-user">Usuario:</label> <input type="text" name="user" id="resgister-user" /></p>
<p><label for="register-pass">Contraseña:</label> <input type="password" name="pass" id="register-pass"/></p>
<p><label for="register-re-pass">Confirmar Contraseña:</label> <input type="password" name="re_pass" id="register-re-pass"/></p>
<p><label for="register-name">Nombre:</label> <input type="text" name="name" id="register-name"/></p>
<p><label for="register-surname">Apellido:</label> <input type="text" name="surname" id="register-surname"/></p>
<p><label for="register-email">Email:</label> <input type="email" name="email" id="register-email"/></p>
<p><label for="register-birthdate">Fecha de nacimiento:</label> <input type="date" name="birthdate" id="register-birthdate"/></p>

<p><input type="submit" id="register-submit" value="Register"/></p>

</form>
EOD;


showHeader($title);

showContent($content);

showFooter();

?>
