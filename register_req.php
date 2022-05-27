<?php


if(!isset($_POST["user"]) || !isset($_POST["pass"]) || !isset($_POST["re_pass"]) || !isset($_POST["name"]) || !isset($_POST["surname"]) || !isset($_POST["email"]) || !isset($_POST["birthdate"])){
 echo "ERROR 1: Formulario no completo";

 exit();
 }

$user = trim($_POST["user"]);
if (strlen($user) <= 2){
	echo "ERROR 2: El usuario debe tener más de 2 caracteres";

	exit();
}

$pass = trim($_POST["pass"]);
if (strlen($pass) <= 3){
	echo "ERROR 3: La contraseña debe tener más de 3 caracteres";

	exit();
}

$repass = trim($_POST["re_pass"]);
if($repass != $pass){
	echo "ERROR 4: Las contraseñas han de coincidir";

	exit();
}

$name = trim($_POST["name"]);
if (strlen($name) <= 3){
	echo "ERROR 5: El nombre debe tener más de 2 caracteres";

	exit();
}

$surname = trim($_POST["surname"]);
if (strlen($surname) <= 3){
	echo "ERROR 6: El apellido debe tener más de 2 caracteres";

	exit();
}

$email = trim($_POST["email"]);
if (strlen($email) <= 3){
	echo "ERROR 7: El email debe tener más de 2 caracteres";

	exit();
}

$birthdate = trim($_POST["birthdate"]);
if (strlen($birthdate) <= 3){
	echo "ERROR";

	exit();
}


$user_tmp = addslashes($user);

if (strlen($user) != strlen($user_tmp)){
	echo "ERROR 8 = Usuario mal formado";

	exit();
}

$pass_tmp = addslashes($pass);

if (strlen($pass) != strlen($pass_tmp)){
	echo "ERROR 9 = Contraseña mal formada";

	exit();
}

$pass = md5($pass);

$name_tmp = addslashes($name);

if (strlen($name) != strlen($name_tmp)){
	echo "ERROR 10 = Nombre mal formado";

	exit();
}

$surname_tmp = addslashes($surname);

if (strlen($surname) != strlen($surname_tmp)){
	echo "ERROR 11 = Apellido mal formado";

	exit();
}

$email_tmp = addslashes($email);

if (strlen($email) != strlen($email_tmp)){
	echo "ERROR";

	exit();
}



$query = <<<EOD
INSERT INTO users (user, password, email, name, surname, birthdate)
VALUES ("{$user}", "{$pass}", "{$email}", "{$name}", "{$surname}", "{$birthdate}");
EOD;

require("config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);


if (!$conn){
	echo "ERROR 6: No se pudo conectar con la base de datos";

	exit();
}

$res = $conn->query($query);

if (!$res){
	echo "ERROR 7: Query mal formada";

	exit();
}


$id_user = mysqli_insert_id($conn);

session_start();

$_SESSION ["id_user"] = $id_user;



header("Location: index.php");

exit();


?>
