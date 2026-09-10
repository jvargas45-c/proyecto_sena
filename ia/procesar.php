<?php

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    exit;
}

$mensaje = strtolower(trim($_POST["mensaje"] ?? ""));

if ($mensaje === "") {
    echo "No recibí ningún mensaje.";
    exit;
}



if (
    str_contains($mensaje, "hola") ||
    str_contains($mensaje, "buenas")
) {

    echo "¡Hola! 👋 Bienvenido a Dulce Tentación. ¿En qué puedo ayudarte?";

}

elseif (
    (
        str_contains($mensaje, "cumpleaños") ||
        str_contains($mensaje, "cumpleanos") ||
        str_contains($mensaje, "cumple")
    )
    &&
    (
        str_contains($mensaje, "torta") ||
        str_contains($mensaje, "tortas") ||
        str_contains($mensaje, "recomienda") ||
        str_contains($mensaje, "recomiendas")
    )
) {

    echo "🎂 ¡Claro! Para un cumpleaños te recomiendo nuestras tortas de chocolate o vainilla. Si me dices cuántas personas son y tu presupuesto, puedo ayudarte a elegir.";

}

elseif (
    str_contains($mensaje, "torta") ||
    str_contains($mensaje, "tortas")
) {

    echo "🍰 Tenemos diferentes tipos de tortas. Puedes entrar a la categoría Pastelería para conocer nuestros productos.";

}

elseif (
    str_contains($mensaje, "mini") ||
    str_contains($mensaje, "minis") ||
    str_contains($mensaje, "cupcake") ||
    str_contains($mensaje, "ponque")
) {

    echo "🧁 En nuestra categoría Minis encontrarás productos como cupcakes y mini ponqués.";

}

elseif (
    str_contains($mensaje, "personalizado") ||
    str_contains($mensaje, "personalizados")
) {

    echo "🎂 En Personalizados puedes encontrar productos preparados para ocasiones especiales.";

}

elseif (
    str_contains($mensaje, "antojito") ||
    str_contains($mensaje, "antojitos")
) {

    echo "🥐 En la categoría Antojitos encontrarás diferentes opciones para disfrutar.";

}

elseif (
    str_contains($mensaje, "comprar") ||
    str_contains($mensaje, "pedido")
) {

    echo "🛒 Para realizar una compra, selecciona el producto que deseas y agrégalo a tu carrito.";

}

elseif (
    str_contains($mensaje, "precio") ||
    str_contains($mensaje, "cuesta") ||
    str_contains($mensaje, "vale")
) {

    echo "💰 Puedes consultar el precio de cada producto entrando a su tarjeta dentro de nuestro catálogo.";

}

elseif (
    str_contains($mensaje, "gracias")
) {

    echo "¡Con mucho gusto! ❤️ Estoy aquí para ayudarte.";

}

else {

    echo "🤔 Todavía estoy aprendiendo. Puedes preguntarme sobre nuestras tortas, minis, personalizados, antojitos o cómo realizar una compra.";

}

?>