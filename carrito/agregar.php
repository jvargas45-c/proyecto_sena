<?php
session_start();
include("../conexion.php");


if (!isset($_SESSION["id_usuario"])) {

    $_SESSION["mensaje"] = "Debes iniciar sesión para agregar productos al carrito.";
    $_SESSION["tipo"] = "error";

    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_producto = $_POST["id_producto"];


$sql = "SELECT * FROM carrito
        WHERE id_usuario = ? AND id_producto = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

if(mysqli_num_rows($resultado) > 0){

    
    $sql = "UPDATE carrito
            SET cantidad = cantidad + 1
            WHERE id_usuario = ? AND id_producto = ?";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);

}else{

    
    $sql = "INSERT INTO carrito(id_usuario,id_producto,cantidad)
            VALUES(?,?,1)";

    $stmt = mysqli_prepare($conexion, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $id_usuario, $id_producto);

}

mysqli_stmt_execute($stmt);

$_SESSION["mensaje"] = "🛒 Producto agregado al carrito.";
$_SESSION["tipo"] = "success";

header("Location: " . $_SERVER["HTTP_REFERER"]);
exit();
?>