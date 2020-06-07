// get files
const displayFile = () => {
  const files = document.querySelectorAll('[class*="file"]');
  for (let n in files) {
    if (files.hasOwnProperty(n)) {
      files[n].addEventListener("click", e => {
        e.preventDefault();
        alert("clicked!");
      });
    }
  }
}
// call function
displayFile();
