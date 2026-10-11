<?php
session_start();
include("../conexion.php");

if (!isset($_SESSION["id_usuario"])) {
    header("Location: ../sesion/iniciar.html");
    exit();
}

$id_usuario = $_SESSION["id_usuario"];

// Consultar los productos favoritos del usuario
$sql = "SELECT p.*, c.nombre_categoria, t.nombre_tamano, pr.precio 
        FROM favoritos f
        INNER JOIN productos p ON f.id_producto = p.id_producto
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria
        INNER JOIN tamanos t ON p.id_tamano = t.id_tamano
        INNER JOIN precios pr ON p.id_producto = pr.id_producto
        WHERE f.id_usuario = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $id_usuario);
mysqli_stmt_execute($stmt);
$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Mis Favoritos - Dulce Tentación</title>
    <link rel="stylesheet" href="../css/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

<header>
    <h1>Dulce Tentación</h1>
    <a href="../index.php" style="color: white; text-decoration: none;"><i class="fas fa-home"></i> Volver al inicio</a>
</header>

<main>
    <h2>❤️ Mis Productos Favoritos</h2>

    <div class="contenedor-productos">
    <?php
    if(mysqli_num_rows($resultado) > 0){
        while($producto = mysqli_fetch_assoc($resultado)){
    ?>
        <div class="producto">
            <img src="../img/img2/<?= htmlspecialchars($producto['imagen']); ?>" alt="<?= htmlspecialchars($producto['nombre_producto']); ?>">
            <h3><?= $producto['nombre_producto']; ?></h3>
            <p><?= $producto['descripcion']; ?></p>
            <p><strong>Tipo:</strong> <?= $producto['tipo_ponque']; ?></p>
            <p><strong>Tamaño:</strong> <?= $producto['nombre_tamano']; ?></p>
            <h3>$<?= number_format($producto['precio'],0,',','.'); ?></h3>

            <div class="acciones">
                <!-- Botón para eliminar de favoritos si deseas -->
                <form action="eliminar_favorito.php" method="POST">
                    <input type="hidden" name="id_producto" value="<?= $producto['id_producto']; ?>">
                    <button type="submit" class="favorito" style="background: #ff4d4d; color: white;">
                        <i class="fa-solid fa-trash"></i>
                    </button>
                </form>

                <form action="../carrito/agregar.php" method="POST">
                    <input type="hidden" name="id_producto" value="<?= $producto['id_producto']; ?>">
                    <button type="submit" class="carrito">
                        <i class="fa-solid fa-cart-shopping"></i> Agregar al carrito
                    </button>
                </form>
            </div>
        </div>
    <?php
        }
    } else {
        echo "<h3 style='grid-column: 1/-1; text-align: center;'>No tienes productos en favoritos todavía.</h3>";
    }
    ?>
    </div>
</main>

</body>
</html>