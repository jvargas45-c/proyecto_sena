const imagenes = [
    "img/Promocion de pasteles.png",     // Índice 0
    "img/Promocion de postres.png",     // Índice 1
    "img/Promocion_antojos.png"         // Índice 2
];

// Los enlaces correspondientes a cada banner en orden exacto:
const enlaces = [
    "productos.php?categoria=2",        // Banner 1 -> Categoría 2 (Pasteles Altos)
    "productos.php?categoria=1",        // Banner 2 -> Categoría 1 (Postres / 25%)
    "productos.php?categoria=3,4"       // Banner 3 -> Categorías 3 y 4 (Antojos / 50%)
];

let actual = 0;

const slide = document.getElementById("slide");
const enlaceSlide = document.getElementById("enlaceSlide");
const next = document.getElementById("next");
const prev = document.getElementById("prev");

function actualizarSlider() {
    slide.src = imagenes[actual];
    enlaceSlide.href = enlaces[actual]; // Esto actualiza el link del <a> según la imagen activa
}

next.addEventListener("click", function () {
    actual++;
    if (actual >= imagenes.length) {
        actual = 0;
    }
    actualizarSlider();
});

prev.addEventListener("click", function () {
    actual--;
    if (actual < 0) {
        actual = imagenes.length - 1;
    }
    actualizarSlider();
});

setInterval(function () {
    actual++;
    if (actual >= imagenes.length) {
        actual = 0;
    }
    actualizarSlider();
}, 5000);

const menuBtn = document.getElementById('menuBtn');
const dropdownMenu = document.getElementById('dropdownMenu');

menuBtn.addEventListener('click', () => {
  dropdownMenu.classList.toggle('hidden');
});

document.addEventListener('click', (e) => {
  if (!menuBtn.contains(e.target) && !dropdownMenu.contains(e.target)) {
    dropdownMenu.classList.add('hidden');
  }
});