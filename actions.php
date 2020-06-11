<?php

/* ----------- CREATE FILE OR FOLDER ----------- */
if (isset($_POST['create'])) {
  $create_file = $_POST['create_file'];
  if (!in_array($create_file, scandir(getcwd()))) {
    if(strpos($create_file, '.') === false) {
      echo "<script type=\"text/javascript\"> alert('folder!'); </script>";
      mkdir(getcwd() . DIRECTORY_SEPARATOR . $create_file, 0777);
    } else {
      echo "<script type=\"text/javascript\"> alert('file!'); </script>";
      fopen(getcwd() . DIRECTORY_SEPARATOR . $create_file, 'a+');
    }
  } else {
    echo "<script type=\"text/javascript\"> alert('exists already!'); </script>";
  }
}
/* ----------- DELETE FILE ----------- */
if (isset($_POST['delete'])) {
  $delete_file = $_POST['delete_file'];
  echo "<script type=\"text/javascript\">
    sure();
    function sure() {
      const ask = confirm('do you really, really want to delete this file?');
      if (ask == true) {
        const askAgain = confirm('are you sure?');
        if (askAgain == true) {
          const answer = prompt('but, what does this file did to you?');
          if (answer !== 'yes') {
            confirm('do you really, really want to delete this file?');
          } else if (answer !== 'no') {
            confirm('are you sure?');
          } else {
            alert('fine, fine, file deleted');
          }
        }
      }
    }
    </script>";
    rename($delete_file, 'C:\wamp64\www\snunezmeneses\files-explorer\trash' . DIRECTORY_SEPARATOR . $delete_file);
}

?>
