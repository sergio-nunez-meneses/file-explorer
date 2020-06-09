/* VARIABLES */

// slide index for lightbox
let slideIndex = 1;

// close modal
const closeModal = () => {
  const close = document.getElementById("close");
  close.addEventListener("click", e => {
    e.preventDefault();
    console.log('modal closed');
    document.getElementById("myModal").style.display = "none";
  });
}
closeModal();

// get all <a> tags containing files and open modal
const openModal = () => {
  const files = document.querySelectorAll('[class*="file"]');
  console.log(files);
  for (let n in files) {
    if (files.hasOwnProperty(n)) {
      files[n].addEventListener("click", e => {
        e.preventDefault();
        console.log('modal opened');
        document.getElementById("myModal").style.display = "block";
        currentSlide(files);
      });
    }
  }
}
// call function
openModal();

// display first modal slide
showSlides(slideIndex);
// modal functions
function currentSlide(n) {
  showSlides(slideIndex = n);
}
function showSlides(n) {
  let slides = document.getElementsByClassName("slide");
  // display selected thumbnail
  slides[slideIndex-1].style.display = "block";
}

// keyboard control
function logKey(e) {
  if (keys[event.keyCode] !== undefined) {
    console.log(e);
    if (keys[event.keyCode] === "esc") {
      console.log('modal closed');
      document.getElementById("myModal").style.display = "none";
    }
  }
}

/* CLASSES AND OBJECTS */

// keyboard 'esc' key
const keys = {
  27: "esc"
}

/* EVENT LISTENERS */

// control modal with "left", "right" and "esc" keys
document.addEventListener('keydown', logKey);
