<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];
$id_pedido = $_GET["id"];

// Verificar que el pedido pertenezca al usuario
$sql = "SELECT *
        FROM pedidos
        WHERE id_pedido = ? AND id_usuario = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "ii", $id_pedido, $id_usuario);
mysqli_stmt_execute($stmt);

$pedido = mysqli_stmt_get_result($stmt);

if (mysqli_num_rows($pedido) == 0) {
    die("Pedido no encontrado.");
}

$pedido = mysqli_fetch_assoc($pedido);

// Obtener los productos del pedido
$sql = "SELECT
            dp.cantidad,
            dp.precio,
            p.nombre_producto,
            p.imagen
        FROM detalle_pedido dp
        INNER JOIN productos p
            ON dp.id_producto = p.id_producto
        WHERE dp.id_pedido = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_pedido);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Detalle del pedido</title>

<style>

body{
    font-family: Arial, sans-serif;
    background:#fff7fb;
}

.contenedor{
    width:90%;
    max-width:900px;
    margin:40px auto;
}

.producto{
    display:flex;
    gap:20px;
    align-items:center;
    background:white;
    margin-bottom:20px;
    padding:20px;
    border-radius:12px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.producto img{
    width:120px;
    height:120px;
    object-fit:cover;
    border-radius:10px;
}

.info{
    flex:1;
}

.total{
    text-align:right;
    font-size:28px;
    color:#e91e63;
    font-weight:bold;
    margin-top:30px;
}

.boton{
    display:inline-block;
    margin-top:25px;
    background:#e91e63;
    color:white;
    padding:12px 20px;
    text-decoration:none;
    border-radius:8px;
}

</style>

</head>
<body>

<div class="contenedor">

<h1>📦 Pedido #<?= $pedido["id_pedido"]; ?></h1>

<p><strong>Fecha:</strong> <?= $pedido["fecha"]; ?></p>

<hr><br>

<?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

<?php
$subtotal = $fila["cantidad"] * $fila["precio"];
?>

<div class="producto">

    <?php 
    $imagen = $fila["imagen"];

    if (filter_var($imagen, FILTER_VALIDATE_URL)) {
        $rutaImagen = $imagen;
    } else {
        $rutaImagen = "../img/img2/" . $imagen;
    }
    ?>

    <img src="<?= htmlspecialchars($rutaImagen); ?>">

    <div class="info">

        <h2><?= $fila["nombre_producto"]; ?></h2>

        <p>Precio: $<?= number_format($fila["precio"],0,",","."); ?></p>

        <p>Cantidad: <?= $fila["cantidad"]; ?></p>

        <p><strong>Subtotal:</strong>
        $<?= number_format($subtotal,0,",","."); ?></p>

    </div>

</div>

<?php } ?>

<div class="total">

Total:
$<?= number_format($pedido["total"],0,",","."); ?>

</div>

<a href="historial.php" class="boton">
    ← Volver al historial
</a>

</div>

</body>
</html>