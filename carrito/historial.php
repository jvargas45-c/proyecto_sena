<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

$sql = "SELECT *
        FROM pedidos
        WHERE id_usuario = ?
        ORDER BY fecha DESC";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<title>Mis pedidos</title>

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

table{
    width:100%;
    border-collapse:collapse;
    background:white;
    box-shadow:0 5px 15px rgba(0,0,0,.1);
}

th,td{
    padding:15px;
    text-align:center;
}

th{
    background:#e91e63;
    color:white;
}

tr:nth-child(even){
    background:#fdf2f8;
}

.boton{
    display:inline-block;
    margin-top:20px;
    background:#e91e63;
    color:white;
    padding:12px 20px;
    text-decoration:none;
    border-radius:8px;
}

.eliminar{
    background:#dc3545;
}

.eliminar:hover{
    background:#b02a37;
}
</style>

</head>
<body>

<div class="contenedor">

<h1>📦 Mis pedidos</h1>

<table>

<tr>
    <th>ID Pedido</th>
    <th>Fecha</th>
    <th>Total</th>
    <th>Acción</th>
</tr>

<?php while($fila = mysqli_fetch_assoc($resultado)){ ?>

<tr>
    <td><?= $fila["id_pedido"]; ?></td>
    <td><?= $fila["fecha"]; ?></td>
    <td>$<?= number_format($fila["total"], 0, ",", "."); ?></td>
    <td>
        <a href="detalle_pedido.php?id=<?= $fila["id_pedido"]; ?>" class="boton">
            Ver detalle
        </a>

        <a href="eliminar_pedido.php?id=<?= $fila["id_pedido"]; ?>"
            class="boton eliminar"
            onclick="return confirm('¿Seguro que deseas eliminar este pedido?');">
            Eliminar
        </a>
    </td>
</tr>

<?php } ?>

</table>

<a href="../index.php" class="boton">← Volver al inicio</a>

</div>

</body>
</html>