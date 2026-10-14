<?php
include("../conexion.php");

$idCategoria = 5; 

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
        INNER JOIN categorias c ON p.id_categoria = c.id_categoria
        INNER JOIN tamanos t ON p.id_tamano = t.id_tamano
        INNER JOIN precios pr ON p.id_producto = pr.id_producto
        WHERE p.id_categoria = ?";

$stmt = mysqli_prepare($conexion, $sql);
mysqli_stmt_bind_param($stmt, "i", $idCategoria);
mysqli_stmt_execute($stmt);

$resultado = mysqli_stmt_get_result($stmt);
?>

<!DOCTYPE html>
<html lang="es">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Panadería Dulce Tentación</title>
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:ital,wght@0,600;0,700;1,400&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
<link rel="stylesheet" href="panaderia.css">
</head>
<body>


<header class="site-header">
  <div class="top-bar">
    <p>🥖 ¡Pan recién horneado todos los días! Envíos locales y pedidos programados.</p>
  </div>
  
  <div class="container header-inner">
    <button onclick="location.href='../index.php'" class="back-btn">
      <span class="arrow-icon">&#8592;</span> Volver al inicio
    </button>

    <div class="brand">
      <span class="brand-logo">🥐</span>
      <div class="brand-text">
        <span class="brand-name">Dulce Tentación</span>
        <span class="brand-sub">Panadería & Repostería</span>
      </div>
    </div>

    <div class="header-actions">
      <div class="search-box">
        <input type="text" placeholder="¿Qué se te antoja hoy?...">
        <button type="submit">🔍</button>
      </div>
    </div>
  </div>

</header>


<section class="hero-banner">
  <div class="container hero-content">
    <div class="hero-tag">Novedades de la semana</div>
    <h1>El sabor artesanal que te acompaña en cada momento</h1>
    <p>Desde crujientes croissants hasta panes de masa madre horneados esta mañana.</p>
    <a href="#productos" class="btn btn-primary">Explorar Carta de Productos</a>
  </div>
</section>


<section class="productos-section" id="productos">
  <div class="container">
    <div class="section-header">
      <h2>Nuestros Productos Destacados</h2>
      <p>Selecciona tus favoritos y pídelos directo a tu mesa o a domicilio</p>
    </div>

    <div class="products-grid">
      <?php
      if(mysqli_num_rows($resultado) > 0){
          while($producto = mysqli_fetch_assoc($resultado)){
              $imagen = $producto["imagen"];
              $rutaImagen = filter_var($imagen, FILTER_VALIDATE_URL) ? $imagen : "../img/img2/" . $imagen;
      ?>
      <article class="product-card">
          <div class="badge-discount">Fresco</div>
          <div class="card-img-wrap">
            <img src="<?= htmlspecialchars($rutaImagen); ?>" alt="<?= htmlspecialchars($producto["nombre_producto"]); ?>">
          </div>

          <div class="product-info">
              <span class="category-tag">Panadería Artesanal</span>
              <h3><?= htmlspecialchars($producto["nombre_producto"]); ?></h3>
              <p class="desc"><?= htmlspecialchars($producto["descripcion"] ?? 'Pan recién horneado con ingredientes de alta calidad.'); ?></p>
              
              <div class="card-footer">
                <span class="price">$<?= number_format($producto["precio"],0,",","."); ?></span>
                <form action="../carrito/agregar.php" method="POST">
                    <input type="hidden" name="id_producto" value="<?= $producto["id_producto"]; ?>">
                    <button class="btn-add-cart">🛒 Agregar</button>
                </form>
              </div>
          </div>
      </article>
      <?php
          }
      } else {
          echo "<p class='no-products'>No hay productos disponibles en esta sección por el momento.</p>";
      }
      ?>
    </div>
  </div>
</section>


<footer class="main-footer">
  <div class="container footer-grid">
    
    
    <div class="footer-col">
      <a href="../acerca.php" class="footer-brand-link">
        <div class="footer-logo">
          <i class="fa-solid fa-wheat-awn"></i>
        </div>
        <h3>Acerca de nosotros</h3>
      </a>
      <p>Conoce nuestra historia, nuestra pasión por la repostería artesanal y el secreto detrás de nuestras mejores recetas.</p>
      <a href="../acerca.php" class="footer-link-btn">Saber más <i class="fa-solid fa-arrow-right"></i></a>
    </div>

    
    <div class="footer-col">
      <div class="footer-header">
        <div class="footer-logo">
          <i class="fa-solid fa-cake-candles"></i>
        </div>
        <h3>Otras tiendas</h3>
      </div>
      <p>Visita nuestras sedes aliadas y disfruta de la experiencia completa:</p>
      <div class="store-badge">
        <span class="store-icon"><i class="fa-solid fa-store"></i></span>
        <span class="store-name">Dulce Tentación</span>
      </div>
    </div>

    
    <div class="footer-col">
      <div class="footer-header">
        <div class="footer-logo whatsapp-logo">
          <i class="fa-solid fa-comments"></i>
        </div>
        <h3>Contáctanos</h3>
      </div>
      <p>¿Tienes dudas con tu pedido o deseas realizar un pedido especial?</p>
      <a href="https://wa.me/573000000000?text=Hola,%20quisiera%20hacer%20un%20pedido%20en%20Dulce%20Tentaci%C3%B3n" target="_blank" class="whatsapp-btn">
        <i class="fa-brands fa-whatsapp"></i> Chatea por WhatsApp
      </a>
    </div>

  </div>

  <div class="footer-bottom">
    <div class="container">
      <p>&copy; <?= date('Y'); ?> Dulce Tentación. Todos los derechos reservados.</p>
    </div>
  </div>
</footer>

<script src="panaderia.js"></script>
</body>
</html>