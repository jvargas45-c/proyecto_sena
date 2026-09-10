<?php

$host = "localhost";
$user = "root";
$password = "";
$db = "dulce_tentación"; 

$conexion = mysqli_connect($host, $user, $password, $db);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}

mysqli_set_charset($conexion, "utf8");
?>