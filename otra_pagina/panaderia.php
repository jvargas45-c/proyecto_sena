<?php
include("../conexion.php");


$idCategoria = 5; // Categoría Panadería

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
    4 => "Antojitos",
    5 => "Panadería"
];

$titulo = $titulos[$idCategoria] ?? "Productos";
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panadería Dulce Tentación</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,500;0,600;0,700;1,500&family=Poppins:wght@300;400;500;600&display=swap" rel="stylesheet">
<link rel="stylesheet" href="panaderia.css">
</head>
<body>

<!-- ============================================= -->
<!-- HEADER / NAVEGACIÓN -->
<!-- ============================================= -->
<header class="site-header">
  <div class="container header-inner">
    <button onclick="location.href='../index.php'" class="back-btn">
      <span class="arrow-icon">&#8592;</span> Volver a Dulce Tentación
    </button>

    <div class="brand">
      <!-- IMAGEN: logo pequeño (espiga de trigo dibujada a mano), aprox 24x24px -->
      <span class="brand-logo" aria-hidden="true">☕</span>
      <div class="brand-text">
        <span class="brand-name">Panadería</span>
        <span class="brand-sub">Dulce Tentación</span>
      </div>
    </div>

    <nav class="main-nav">
      <a href="#inicio" class="active">Inicio</a>
      <a href="#panaderia">Panadería</a>
      <a href="#cafeteria">Cafetería</a>
      <a href="#hojaldres">Hojaldres</a>
      <a href="#mas">Más <span class="chevron">&#9662;</span></a>
    </nav>

    
  </div>
</header>

<!-- ============================================= -->
<!-- HERO -->
<!-- ============================================= -->
<section class="hero" id="inicio">
  <div class="container hero-inner">
    <div class="hero-text">
      <h1>El sabor de una<br>tradición</h1>
      <p>Pan recién horneado, café preparado con cariño y momentos para compartir.</p>
      <a href="#menu" class="btn btn-dark">Ver nuestros productos <span class="arrow-icon">&#8594;</span></a>

      <!-- IMAGEN: sello circular "Pan fresco todos los días" (puede ser SVG/badge) -->
      <div class="badge-circle">
        <span>PAN FRESCO · TODOS LOS DÍAS</span>
        <div class="badge-icon">☕</div>
      </div>
    </div>

    <div class="hero-image">
      <!-- IMAGEN PRINCIPAL: foto de canasta de panes variados (baguettes, panes rústicos, croissants)
           con fondo oscuro/pizarra, más una taza de café con leche y un croissant al frente,
           granos de café esparcidos sobre una tabla de madera -->
      <img src="pan-removebg-preview (1).png" alt="Canasta de panes recién horneados con café y croissant">
    </div>
  </div>
</section>

<!-- ============================================= -->
<!-- NUESTROS FAVORITOS -->
<!-- ============================================= -->
<section class="favoritos" id="menu">
  <div class="container">
    <h2 class="section-title"><span class="rule"></span>Nuestros Productos<span class="rule"></span></h2>

<div class="carousel-wrap">

    <div class="carousel-track" id="carouselTrack">

        <?php
        if(mysqli_num_rows($resultado) > 0){

            while($producto = mysqli_fetch_assoc($resultado)){

                echo $producto["nombre_producto"] . "<br>";

                $imagen = $producto["imagen"];

                if(filter_var($imagen, FILTER_VALIDATE_URL)){
                    $rutaImagen = $imagen;
                }else{
                    $rutaImagen = "../img/img2/" . $imagen;
                }
        ?>

<article class="product-card">

    <img src="<?= htmlspecialchars($rutaImagen); ?>"
         alt="<?= htmlspecialchars($producto["nombre_producto"]); ?>">

    <div class="product-info">

        <h3><?= htmlspecialchars($producto["nombre_producto"]); ?></h3>

        <span class="price">
            $<?= number_format($producto["precio"],0,",","."); ?>
        </span>

        <form action="../carrito/agregar.php" method="POST">
            <input type="hidden"
                   name="id_producto"
                   value="<?= $producto["id_producto"]; ?>">

            <button class="btn-carrito">
                🛒 Agregar al carrito
            </button>
        </form>

    </div>

</article>

        <?php
            }
        }else{
            echo "<h2>No hay productos registrados.</h2>";
        }
        ?>

    </div>

</div>

    <div class="cta-center">
      <a href="../index.php" class="btn btn-dark">Ver mas productos<span class="arrow-icon">&#8594;</span></a>
    </div>
  </div>
</section>

<!-- ============================================= -->
<!-- NUESTRA HISTORIA -->
<!-- ============================================= -->
<section class="historia">
  <div class="container historia-inner">

    <div class="historia-image">
      <!-- IMAGEN: panes rústicos horneados de cerca, tono cálido, con textura de harina -->
      <img class="historia-photo" src="https://thumbs.dreamstime.com/b/cerrar-un-mont%C3%B3n-de-panes-fotograf%C3%ADa-detallada-una-selecci%C3%B3n-artesanales-con-exteriores-crujientes-e-interiores-suaves-grabados-384705547.jpg" alt="Panes artesanales recién horneados">
      <span class="handwritten">Hecho <br>con amor &#9825;</span>
    </div>

    <div class="historia-text">
      <h2 class="section-title-left">Nuestra Historia <span class="rule"></span></h2>
      <p>Panadería Dulce Tentación nació del sueño de llevar el sabor artesanal a cada hogar. Comenzamos con una pequeña cocina, con grandes sueños y mucho amor por lo que hacemos. Hoy, seguimos horneando con la misma pasión, ofreciendo panes, café y delicias que conectan personas y crean momentos especiales.</p>
      <a href="../pag_menu/acerca.html" class="btn btn-dark">Conoce más sobre nosotros <span class="arrow-icon">&#8594;</span></a>
    </div>

    <div class="historia-features">
      <div class="feature">
        <span class="feature-icon">🌾</span>
        <p>Ingredientes de calidad</p>
      </div>
      <div class="feature">
        <span class="feature-icon">☕</span>
        <p>Café 100% colombiano</p>
      </div>
      <div class="feature">
        <span class="feature-icon">&#9825;</span>
        <p>Hecho con amor</p>
      </div>
    </div>

  </div>
</section>

<!-- ============================================= -->
<!-- BANNER FINAL / EXPERIENCIA -->
<!-- ============================================= -->
<section class="experiencia">

  <div class="container experiencia-inner">
    <div class="experiencia-text">
      <h2>Más que pan,<br>es una experiencia.</h2>
      <p>Ven y disfruta de nuestros panes, bebidas y delicias, hechas para ti.</p>
    </div>

    <div class="experiencia-image">
      <!-- IMAGEN: mesa oscura con café con leche, croissant y granos de café esparcidos, iluminación cálida y ambiente acogedor -->
      <img src="https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcTDD4hEGhMx5kDG5EcHBEW62UMzFDc9a7246zxjzE-w916-gR58b5rXpMXv&s=10" alt="Café y croissant sobre mesa oscura">
      <span class="handwritten-light">Buen café<br>Buenas ideas<br>Grandes momentos</span>
    </div>
  </div>
</section>

<script src="panaderia.js"></script>
</body>
</html>