<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sergio Núñez Meneses">
    <script src="https://use.fontawesome.com/275ae55494.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>File Explorer</title>
  </head>
  <body>

    <?php

    /* ----------- USEFUL DIRECTORY INFORMATIONS ----------- */
    echo '<header>';
    // name of the host server, e.g. my.local
    echo 'server name: ' . $_SERVER['SERVER_NAME'] . '<br>';
    // filename of the currently executing script
    echo 'php self: ' . $_SERVER['PHP_SELF'] . '<br>';
    // current directory, e.g. files-explorer
    echo 'current directory: ' . basename(getcwd()) . '<br>';
    // absolute path, e.g. /Applications/MAMP/htdocs/files-explorer/index.php
    $path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'];
    echo 'absolute path: ' . $path . '<br>';
    // site's root path including the script, e.g. /Applications/MAMP/htdocs/files-explorer/index.php
    echo 'script directory: ' . realpath(__FILE__) . '<br>';
    // site's root path without the script's filename, e.g. /Applications/MAMP/htdocs/files-explorer/
    define('ROOT_DIR', realpath(__DIR__));
    echo 'root directory: ' . ROOT_DIR . '<br>';
    echo '</header>';
    /* --------------------------------- */

    echo '<br>';
    echo '<main>';
    echo '<section><div>';

    /* ----------- CHANGE DIRECTORY ----------- */
    // check whether a folder has been clicked
    if (isset($_POST['selected_item'])) {
      // store <form> passed value
      $selected_item = $_POST['selected_item'];
      echo 'selected item: ' . $selected_item . '<br>';
      // check whether to move to a new directory or not
      if (chdir($selected_item)) {
        chdir($selected_item);
        echo 'directory successfully changed' . '<br>';
      } else {
        chdir(getcwd());
        // $selected_item = getcwd();
        echo 'failed to change directory' . '<br>';
      }
    }
    /* --------------------------------- */

    echo '<br>';

    /* ----------- CHECK CURRENT DIRECTORY ----------- */
    // check whether cwd is different than the virtual host
    if (getcwd() !== ROOT_DIR) {
      // remove '/' from path and split it into individual items
      $cwd = explode(DIRECTORY_SEPARATOR, getcwd());
      // get parent directory of every file and folder
      $parent_directory = DIRECTORY_SEPARATOR . $cwd[sizeof($cwd) - 1] . DIRECTORY_SEPARATOR;
      echo "cwd different than virtualhost" . '<br>';
    } else {
      // store absolute path as a single value array
      $cwd = array(getcwd());
      // add a slash
      $parent_directory = DIRECTORY_SEPARATOR;
      echo "cwd same as virtualhost" . '<br>';
    }
    /* --------------------------------- */
    echo '</div></section>';
    echo '<br>';

    /* ----------- ITERATE OVER CURRENT DIRECTORY ----------- */
    // get current working directory
    $cwd_contents = scandir(getcwd());
    print_r($cwd_contents);

    echo '<section><div class="test-container">';
    // iterate over directory
    foreach ($cwd_contents as $item) {
      $absolute_item_path = ROOT_DIR . $parent_directory . $item;
      // check whether the item is a directory
      if (is_dir($absolute_item_path)) {
        // add form tag with post method
        echo '<form method="post" action="" enctype="application/x-www-form-urlencoded"><input type="hidden" name="selected_item" value="' . $absolute_item_path . '"><a class="fa fa-folder-o" href="' . $parent_directory . $item . '"><button type="submit">' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $item) . '</button></a></form>' . '<br>';
        // or a file
      } elseif (is_file($absolute_item_path)) {
        // add anchor tag
        echo '<a class="fa fa-file-o" href="' . $parent_directory . $item . '"><button type="submit">' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $item) . '</button></a>' . '<br>';
      }
    }
    echo '</div></section>';
    echo '</main>';
    /* --------------------------------- */

    ?>

  </body>
</html>
