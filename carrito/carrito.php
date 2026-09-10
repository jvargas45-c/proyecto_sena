<?php
session_start();
include("../conexion.php");

// Verificar que haya iniciado sesión
if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

// Consulta
$sql = "SELECT
            c.id_carrito,
            c.cantidad,
            p.id_producto,
            p.nombre_producto,
            p.imagen,
            pr.precio
        FROM carrito c
        INNER JOIN productos p
            ON c.id_producto = p.id_producto
        INNER JOIN precios pr
            ON p.id_producto = pr.id_producto
        WHERE c.id_usuario = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);

$total = 0;
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mi carrito</title>

<link rel="stylesheet" href="../css/estilo.css">

<style>

body{
    font-family: Arial, sans-serif;
    background:#fff7fb;
}

.contenedor{
    width:90%;
    max-width:1000px;
    margin:40px auto;
}

.producto{
    display:flex;
    align-items:center;
    gap:20px;
    background:white;
    border-radius:15px;
    padding:20px;
    margin-bottom:20px;
    box-shadow:0 5px 15px rgba(0,0,0,.08);
}

.producto img{
    width:130px;
    height:130px;
    object-fit:cover;
    border-radius:12px;
}

.info{
    flex:1;
}

.precio{
    color:#e91e63;
    font-size:22px;
    font-weight:bold;
}

.subtotal{
    font-weight:bold;
    margin-top:10px;
}

.total{
    text-align:right;
    font-size:30px;
    font-weight:bold;
    color:#e91e63;
    margin-top:30px;
}

.botones{
    margin-top:30px;
    display:flex;
    justify-content:space-between;
}

.boton{
    background:#e91e63;
    color:white;
    text-decoration:none;
    padding:12px 25px;
    border-radius:10px;
}

.acciones{
    display:flex;
    align-items:center;
    gap:10px;
    margin-top:15px;
}

.btn{
    text-decoration:none;
    background:#e91e63;
    color:white;
    width:35px;
    height:35px;
    border-radius:8px;
    display:flex;
    justify-content:center;
    align-items:center;
    font-size:18px;
    transition:.2s;
}

.btn:hover{
    background:#c2185b;
}

.eliminar{
    background:#dc3545;
}

.eliminar:hover{
    background:#b02a37;
}

.cantidad{
    min-width:30px;
    text-align:center;
    font-weight:bold;
    font-size:18px;
}

</style>

</head>
<body>

<div class="contenedor">

<h1>🛒 Mi carrito</h1>

<?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

<?php
$subtotal = $fila["precio"] * $fila["cantidad"];
$total += $subtotal;
?>

<div class="producto">

    <img src="../img/img2/<?= $fila["imagen"]; ?>">

    <div class="info">

        <h2><?= $fila["nombre_producto"]; ?></h2>

        <p class="precio">
            $<?= number_format($fila["precio"],0,",","."); ?>
        </p>

        <div class="acciones">

            <a href="disminuir.php?id=<?= $fila['id_producto']; ?>" class="btn">➖</a>

            <span class="cantidad"><?= $fila["cantidad"]; ?></span>

            <a href="aumentar.php?id=<?= $fila['id_producto']; ?>" class="btn">➕</a>

            <a href="eliminar.php?id=<?= $fila['id_producto']; ?>" class="btn eliminar">🗑️</a>

        </div>

        <p class="subtotal">
            Subtotal:
            $<?= number_format($subtotal,0,",","."); ?>
        </p>

    </div>

</div>

<?php } ?>

<div class="total">

Total:
$<?= number_format($total,0,",","."); ?>

</div>

<div class="botones">

    <a href="../index.php" class="boton">
        ← Seguir comprando
    </a>

    <a href="#" class="boton">
        Finalizar compra
    </a>

</div>

</div>

</body>
</html>