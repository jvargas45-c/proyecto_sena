<?php
session_start();
include("../conexion.php"); 


if (!isset($_SESSION["id_usuario"])) {
    $_SESSION['mensaje'] = "Debes iniciar sesión para agregar favoritos.";
    $_SESSION['tipo'] = "error";
    header("Location: ../sesion/iniciar.html");
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $id_usuario = $_SESSION["id_usuario"];
    $id_producto = $_POST["id_producto"];

    $sql_verificar = "SELECT * FROM favoritos WHERE id_usuario = ? AND id_producto = ?";
    $stmt = mysqli_prepare($conexion, $sql_verificar);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
    mysqli_stmt_execute($stmt);
    $resultado = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($resultado) == 0) {
        // Si no existe, lo insertamos
        $sql_insertar = "INSERT INTO favoritos (id_usuario, id_producto) VALUES (?, ?)";
        $stmt_insert = mysqli_prepare($conexion, $sql_insertar);
        mysqli_stmt_bind_param($stmt_insert, "ii", $id_usuario, $id_producto);
        mysqli_stmt_execute($stmt_insert);
    }

    header("Location: " . $_SERVER['HTTP_REFERER']);
    exit();
}
?>