<?php
include("conexion.php");


$idCategoria = $_GET['categoria'] ?? 1;

// Consulta
$sql = "SELECT
            p.id_producto,
            p.nombre_producto,
            p.tipo_ponque,
            p.descripcion,
            p.stock,
            p.imagen,
            c.nombre_categoria,
            t.nombre_tamano,
            pr.precio
        FROM productos p
        INNER JOIN categorias c
            ON p.id_categoria = c.id_categoria
        INNER JOIN tamanos t
            ON p.id_tamano = t.id_tamano
        INNER JOIN precios pr
            ON p.id_producto = pr.id_producto
        WHERE p.id_categoria = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $idCategoria);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);


$titulos = [
    1 => "Pastelería",
    2 => "Personalizados",
    3 => "Minis",
    4 => "Antojitos"
];

$titulo = $titulos[$idCategoria] ?? "Productos";
?>

<!DOCTYPE html>
<html lang="es">

<head>

    <meta charset="UTF-8">

    <title><?= htmlspecialchars($titulo) ?></title>

    <link rel="stylesheet" href="css/estilo.css">

    <link rel="preconnect" href="https://fonts.googleapis.com">

    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

</head>

<body>

<header>

    <h1>Dulce Tentación</h1>

</header>

<main>

    <h2><?= htmlspecialchars($titulo) ?></h2>

    <div class="contenedor-productos">

    <?php

    if(mysqli_num_rows($resultado) > 0){

        while($producto = mysqli_fetch_assoc($resultado)){

    ?>

        <div class="producto">

            <!-- Imagen -->
            <img src="img/img2/<?= htmlspecialchars($producto['imagen']); ?>" alt="<?= htmlspecialchars($producto['nombre_producto']); ?>">

            <h3><?= $producto['nombre_producto']; ?></h3>

            <p><?= $producto['descripcion']; ?></p>

            <p><strong>Tipo:</strong> <?= $producto['tipo_ponque']; ?></p>

            <p><strong>Tamaño:</strong> <?= $producto['nombre_tamano']; ?></p>

            <p><strong>Stock:</strong> <?= $producto['stock']; ?></p>

            <h3>$<?= number_format($producto['precio'],0,',','.'); ?></h3>

            <div class="acciones">

                <form action="favoritos/agregar_favorito.php" method="POST">

                <input type="hidden" name="id_producto" value="<?= $producto['id_producto']; ?>">

                <button type="submit" class="favorito">
                    <i class="fa-solid fa-heart"></i>
                </button>

                </form>

                <form action="carrito/agregar.php" method="POST">
                    <input type="hidden" name="id_producto" value="<?= $producto['id_producto']; ?>">

                    <button type="submit" class="carrito">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Agregar al carrito
                    </button>
                </form>

            </div>

        </div>

    <?php

        }

    }else{

        echo "<h2>No hay productos registrados en esta categoría.</h2>";

    }

    ?>

    </div>

</main>

</body>

</html>