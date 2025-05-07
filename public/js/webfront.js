const images = [
  "/assets/cagsawa.jpg",
  "/assets/mayinsky.jpg",
  "/assets/sulong.jpg",
  "/assets/wild.jpg",
  "/assets/pina.jpg",
  "/assets/corangon.jpg"
];

const titles = [
  "Cagsawa Ruins",
  "Mayon Skyline",
  "Sulong Eco Park",
  "Albay Park & Wildlife",
  "Pinamuntugan Beach",
  "Corangon Shoal"
];

let index = 0;
const sectionTop = document.querySelector("header");
const titleElement = document.querySelector("header h1");

function changeBackground() {

  titleElement.style.opacity = 0;


  setTimeout(() => {
    sectionTop.style.backgroundImage = `url('${images[index]}')`;
    titleElement.textContent = titles[index];


    titleElement.style.opacity = 1;


    index = (index + 1) % images.length;
  }, 500);
}

// Initialize the background and title
changeBackground();

// Change the background and title every 3 seconds
setInterval(changeBackground, 3000);


function scrollToSection() {
  document.querySelector("#journey-section").scrollIntoView({
    behavior: "smooth"
  });
}