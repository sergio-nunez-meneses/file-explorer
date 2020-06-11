<?php

/* ----------- CREATE FILE ----------- */
if (isset($_POST['create'])) {
  $create_file = $_POST['create_file'];
  if (!in_array($create_file, scandir($path))) {
    if(strpos($create_file, '.') === false) {
      header("Location:index.php?folder=created");
      // mkdir(getcwd() . DIRECTORY_SEPARATOR . $create_file, 0777);
    } else {
      header("Location:index.php?file=created");
      // fopen(getcwd() . DIRECTORY_SEPARATOR . $create_file, 'a+');
    }
  } else {
    header("Location:index.php?exists=yes");
  }
}
/* ----------- COPY FILE ----------- */
if (isset($_POST['copy'])) {
  $copy_file = $_POST['copy_file'];
    header("Location:index.php?copied=yes");
    // copy($copy_file, 'C:\wamp64\www\snunezmeneses\files-explorer\trash' . DIRECTORY_SEPARATOR . $copy_file);
}
/* ----------- DELETE FILE ----------- */
if (isset($_POST['delete'])) {
  $delete_file = $_POST['delete_file'];
    header("Location:index.php?deleted=yes");
    // rename($delete_file, 'C:\wamp64\www\snunezmeneses\files-explorer\trash' . DIRECTORY_SEPARATOR . $delete_file);
}

?>
