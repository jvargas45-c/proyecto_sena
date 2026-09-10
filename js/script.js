const imagenes = [
    "img/Promocion de bodas.png",
    "img/Promocion de postres.png",
    "img/Promocion_antojos.png"
];

let actual = 0;

const slide = document.getElementById("slide");
const next = document.getElementById("next");
const prev = document.getElementById("prev");

next.addEventListener("click", function () {
    actual++;

    if (actual >= imagenes.length) {
        actual = 0;
    }

    slide.src = imagenes[actual];
});

prev.addEventListener("click", function () {
    actual--;

    if (actual < 0) {
        actual = imagenes.length - 1;
    }

    slide.src = imagenes[actual];
});

setInterval(function () {
    actual++;

    if (actual >= imagenes.length) {
        actual = 0;
    }

    slide.src = imagenes[actual];
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