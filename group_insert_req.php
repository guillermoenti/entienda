<?php

session_start();

if(!isset($_SESSION["id_user"])){
	echo "Inicia sesión";
	exit();
}

if($_SESSION["id_user"] != 1){
	echo "Necesitas ser tremendo admin";
	exit();
}


if (!isset($_POST["group_name"]) || !isset($_POST["course"]) || !isset($_POST["jam_year"]) || !isset($_POST["mark"])){
	echo "ERROR 1: Formulario incompleto";
	exit();
}


$group_name = $_POST["group_name"];
$course = intval($_POST["course"]);
$jam_year = intval($_POST["jam_year"]);
$mark = floatval($_POST["mark"]);


$query = <<<EOD
INSERT INTO groups (`group`, course, jam_year, mark)
VALUES ("{$group_name}", "{$course}", "{$jam_year}", "{$mark}");
EOD;

require("config.php");

$conn = mysqli_connect($db_server, $db_user, $db_pass, $db);

$res = $conn->query($query);

if(!$res){
	echo "Error al insertar";
	exit();
}

$id_product = mysqli_insert_id($conn);

header("Location: index.php");


?>
