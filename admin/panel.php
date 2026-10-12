<?php
session_start();
include("../conexion.php");

// Verificar si es administrador
if (!isset($_SESSION["rol"]) || $_SESSION["rol"] !== "admin") {
    header("Location: ../index.php");
    exit();
}

// Lógica para eliminar producto si se envía una petición POST o GET
if (isset($_GET["eliminar"])) {
    $id_eliminar = $_GET["eliminar"];
    // Borramos primero de precios para respetar las llaves foráneas y luego de productos
    mysqli_query($conexion, "DELETE FROM precios WHERE id_producto = $id_eliminar");
    mysqli_query($conexion, "DELETE FROM productos WHERE id_producto = $id_eliminar");
    header("Location: panel.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Panel de Administración - Dulce Tentación</title>
    <link rel="stylesheet" href="../css/estilo.css">
</head>
<body>
    <div style="background: white; padding: 20px; max-width: 900px; margin: 40px auto; border-radius: 10px;">
        <h2>Panel de Administración 🛠️</h2>
        <p>Bienvenido, Administrador <b><?php echo $_SESSION["nombre"]; ?></b> | <a href="../sesion/cerrar.php">Cerrar Sesión</a></p>
        
        <hr style="margin: 20px 0;">

        <h3>Agregar Nuevo Producto</h3>
        <form action="agregar_producto_backend.php" method="POST" style="display: grid; gap: 10px;">
            <input type="text" name="nombre" placeholder="Nombre del producto" required style="padding: 8px;">
            <textarea name="descripcion" placeholder="Descripción" required style="padding: 8px;"></textarea>
            <input type="text" name="tipo" placeholder="Tipo (ej. Panadería, Chocolate)" required style="padding: 8px;">
            <input type="number" name="stock" placeholder="Stock" required style="padding: 8px;">
            <input type="text" name="imagen" placeholder="Nombre de imagen (ej. bunuelos.jpg)" required style="padding: 8px;">
            <input type="number" name="id_categoria" placeholder="ID de Categoría" required style="padding: 8px;">
            <input type="number" name="precio" placeholder="Precio ($)" required style="padding: 8px;">
            <button type="submit" style="background: #8b4513; color: white; padding: 10px; border: none; border-radius: 5px; cursor: pointer;">Guardar Producto</button>
        </form>

        <h3 style="margin-top: 30px;">Productos Existentes</h3>
        <table border="1" width="100%" style="border-collapse: collapse; margin-top: 10px; text-align: left;">
            <tr style="background: #f2f2f2;">
                <th style="padding: 8px;">ID</th>
                <th style="padding: 8px;">Nombre</th>
                <th style="padding: 8px;">Acciones</th>
            </tr>
            <?php
            $resultado = mysqli_query($conexion, "SELECT * FROM productos");
            while ($row = mysqli_fetch_assoc($resultado)) {
                echo "<tr>
                    <td style='padding: 8px;'>{$row['id_producto']}</td>
                    <td style='padding: 8px;'>{$row['nombre_producto']}</td>
                    <td style='padding: 8px;'><a href='panel.php?eliminar={$row['id_producto']}' style='color: red; text-decoration: none;' onclick='return confirm(\"¿Estás seguro de eliminar este producto?\")'>Eliminar</a></td>
                </tr>";
            }
            ?>
        </table>
    </div>
</body>
</html>