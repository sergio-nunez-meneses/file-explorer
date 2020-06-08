/* VARIABLES */

// slide index for lightbox
let slideIndex = 1;

// close button
const closeButton = () => {
  const close = document.getElementById("close");
  close.addEventListener("click", e => {
    e.preventDefault();
    console.log(close);
    document.getElementById("myModal").style.display = "none";
  });
}
console.log(closeButton());

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

// get all <a> tags containing files
const displayFile = () => {
  const files = document.querySelectorAll('[class*="file"]');
  console.log(files);
  for (let n in files) {
    if (files.hasOwnProperty(n)) {
      files[n].addEventListener("click", e => {
        e.preventDefault();
        // alert("clicked!");
        document.getElementById("myModal").style.display = "block";
        currentSlide(files);
      });
    }
  }
}
// call function
displayFile();

// keyboard control
function logKey(e) {
  if (keys[event.keyCode] !== undefined) {
    if (keys[event.keyCode] === "esc") {
      closeModal();
    }
  }
}


/* CLASSES AND OBJECTS */
// keyboard keys
const keys = {
  27: "esc"
}
