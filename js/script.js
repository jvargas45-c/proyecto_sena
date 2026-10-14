const imagenes = [
    "img/Promocion de pasteles.png",    
    "img/Promocion de postres.png",     
    "img/Promocion_antojos.png"         
];


const enlaces = [
    "productos.php?categoria=2",        
    "productos.php?categoria=1",        
    "productos.php?categoria=3,4"       
];

let actual = 0;

const slide = document.getElementById("slide");
const enlaceSlide = document.getElementById("enlaceSlide");
const next = document.getElementById("next");
const prev = document.getElementById("prev");

function actualizarSlider() {
    slide.src = imagenes[actual];
    enlaceSlide.href = enlaces[actual]; 
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