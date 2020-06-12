<?php

// track current working directory
if (!empty($_GET['dir'])) {
  $cwd = $_GET['dir'];
} else {
  $cwd = getcwd() . DIRECTORY_SEPARATOR;
}

// path to trash
$trash_path = realpath(__DIR__) . DIRECTORY_SEPARATOR . 'trash' . DIRECTORY_SEPARATOR;

/* ----------- CREATE FILE ----------- */
if (isset($_POST['create'])) {
  $create_file = $_POST['create_file'];
  if (!in_array($create_file, scandir($cwd))) {
    if(strpos($create_file, '.') === false) {
      echo "<script type=\"text/javascript\"> alert('folder created!'); </script>";
      mkdir($cwd . DIRECTORY_SEPARATOR . $create_file, 0777);
    } else {
      echo "<script type=\"text/javascript\"> alert('file created!'); </script>";
      fopen($cwd . DIRECTORY_SEPARATOR . $create_file, 'a+');
    }
  } else {
    echo "<script type=\"text/javascript\"> alert('file already exists!'); </script>";
  }
}
/* ----------- COPY FILE ----------- */
if (isset($_POST['copy'])) {
  $copy_file = $_POST['copy_file'];
  // copy($copy_file, 'C:\wamp64\www\snunezmeneses\files-explorer\trash' . DIRECTORY_SEPARATOR . $copy_file);
}
/* ----------- DELETE FILE ----------- */
if (isset($_POST['delete'])) {
  $delete_file = $_POST['delete_file'];
  rename($cwd . DIRECTORY_SEPARATOR . $delete_file, $trash_path . $delete_file);
  echo "<script type=\"text/javascript\"> confirm('do you really, really want to delete this file?'); </script>";
}

?>
