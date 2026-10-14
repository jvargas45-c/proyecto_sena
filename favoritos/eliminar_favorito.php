<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION["id_usuario"];
    $id_producto = $_POST["id_producto"];

    
    $sql = "DELETE FROM favoritos WHERE id_usuario = ? AND id_producto = ?";
    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
    mysqli_stmt_execute($stmt);

    header("Location: favorito.php");
    exit();
}
?>