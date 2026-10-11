<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dulce Tentación</title>
    <link rel="stylesheet" href="css/estilo.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Fredoka:wght@500;600;700&family=Poppins:wght@400;500;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>
    
    <header>
        <h1>Dulce Tentación</h1>
        <div class="iconos">
            <a href="favoritos/favorito.html">
                <i class="fa-solid fa-heart"></i>
            </a>
            
            <a href="carrito/carrito.php">
                <i class="fa-solid fa-cart-shopping"></i>
            </a>

            <div class="menu-container">
                <i class="fa-solid fa-bars" id="menuBtn"></i>

                <div id="dropdownMenu" class="dropdown-menu hidden">
                    <?php if(isset($_SESSION["id_usuario"])): ?>

                        <span>👋 Hola, <?= $_SESSION["nombre"]; ?></span>
                        <a href="sesion/logout.php">Cerrar sesión</a>

                    <?php else: ?>

                        <a href="sesion/registrar.html"><i class="fas fa-user-plus"></i>Registrarse</a>
                        <a href="sesion/iniciar.html"><i class="fas fa-user"></i>Iniciar Sesión</a>

                    <?php endif; ?>

                        <a href="pag_menu/postres.html"><i class="fas fa-solid fa-cake-candles"></i>Preparar</a>
                        <a href="panaderia/panaderia.php"><i class="fas fa-mug-saucer"></i>Panadería</a>
                        <a href="carrito/historial.php"><i class="fas fa-box"></i>Mis pedidos</a>
                </div>
            </div>
        </div>
    </header>

    <?php
    if(isset($_SESSION['mensaje'])){
    ?>

    <div class="mensaje <?= $_SESSION['tipo']; ?>">
        <?= $_SESSION['mensaje']; ?>
    </div>

    <?php
    unset($_SESSION['mensaje']);
    unset($_SESSION['tipo']);
    }
    ?>

    <section class="slider">
        <button id="prev">&#10094;</button>
        <a id="enlaceSlide" href="productos.php?categoria=2">
            <img id="slide" src="img/Promocion de pasteles.png">
        </a>
        <button id="next">&#10095;</button>
    </section>

    <section class="categorias">

        <a href="productos.php?categoria=1" class="categoria">
            <img src="img/Torta de Tres Leches.png">
            <div class="overlay">
                <h3>Pastelería</h3>
            </div>
        </a>

        <a href="productos.php?categoria=2" class="categoria">
            <img src="img/Torta personalizado.png">
            <div class="overlay">
                <h3>Personalizados</h3>
            </div>
        </a>

        <a href="productos.php?categoria=3" class="categoria">
            <img src="img/Cupcakes.png">
            <div class="overlay">
                <h3>Minis</h3>
            </div>
        </a>

        <a href="productos.php?categoria=4" class="categoria">
            <img src="img/Galletas.png">
            <div class="overlay">
                <h3>Antojitos</h3>
            </div>
        </a>

    </section>

    <section class="blog">
        <h2>Conoce todo sobre Pastelería</h2>

        <div class="articulos">
        <a href="otras_paginas/historia.html">
            <article>
                <img src="img/Historia.png" alt="HISTORIA DE PASTELERÍA">
                <h3>Historia de la repostería</h3>
                <p>Aprende cómo nació la repostería moderna</p>
            </article>
        </a>

        <a href="otras_paginas/4frutas.html">    
            <article>
                <img src="img/Frutas.png" alt="FRUTAS EXÓTICAS">
                <h3>4 frutas exóticas de Colombia</h3>
                <p>Conoce frutas para usar en tus postres</p>
            </article>
        </a>
        </div>
    </section>

<button id="botonIA" class="boton-ia">
    🍰
</button>

<div id="ventanaIA" class="ventana-ia oculto">

    <div class="encabezado-ia">

        <div>
            <strong>🍰 DulceIA</strong>
            <small>Asistente de Dulce Tentación</small>
        </div>

        <button id="cerrarIA">✕</button>

    </div>

    <div id="mensajesIA" class="mensajes-ia">

        <div class="mensaje ia">
            ¡Hola! 👋<br><br>

            Soy <strong>DulceIA</strong>, el asistente virtual
            de Dulce Tentación.

            <br><br>

            Puedo ayudarte con nuestros productos,
            categorías, compras y más. 🍰
        </div>

    </div>

    <div class="entrada-ia">

        <input
            type="text"
            id="entradaIA"
            placeholder="Escribe tu pregunta..."
        >

        <button id="enviarIA">
            ➤
        </button>

    </div>

</div>

<footer class="footer-section">
  <div class="footer-container">
    
    <!-- Columna 1: Nuestra Empresa -->
    <div class="footer-column">
      <h3 class="footer-title">Nuestra Empresa</h3>
      <a href="pag_menu/acerca.html" class="footer-btn">
        <i class="fas fa-users"></i> 
        <span>Acerca de Nosotros</span>
      </a>
    </div>

    <!-- Columna 2: Otras Tiendas -->
    <div class="footer-column">
      <h3 class="footer-title">Otras Tiendas</h3>
      <a href="panaderia/panaderia.php" class="footer-btn">
        <i class="fas fa-coffee"></i> 
        <span>Panadería Dulce Tentación</span>
      </a>
    </div>

    <!-- Columna 3: Contáctanos -->
    <div class="footer-column">
      <h3 class="footer-title">Contáctanos</h3>
      <a href="https://web.whatsapp.com/" target="_blank" class="footer-btn">
        <i class="fab fa-whatsapp"></i> 
        <span>Contáctanos</span>
      </a>
    </div>

  </div>
</footer>

    <script src="js/script.js"></script>
    <script src="js/asistente.js"></script>

</body>
</html>