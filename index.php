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
    echo '<div class="directory-container">';
    // name of the host server, e.g. my.local
    echo '<h2>server name: <span class="directory-info">' . $_SERVER['SERVER_NAME'] . '</span></h2><br>';
    // filename of the currently executing script
    echo '<h2>script name with php self: <span class="directory-info">' . $_SERVER['PHP_SELF'] . '</span></h2><br>';
    // current directory, e.g. files-explorer
    echo '<h2>script folder #1: <span class="directory-info">' . basename(getcwd()) . '</span></h3><br>';
    // current directory, e.g. files-explorer
    echo '<h2>script folder #2: <span class="directory-info">' . basename(dirname(__FILE__)) . '</span></h2><br>';
    // absolute path, e.g. /Applications/MAMP/htdocs/files-explorer/index.php
    $path = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['SCRIPT_NAME'];
    echo '<h2>absolute path: <span class="directory-info">' . $path . '</span></h2><br>';
    // site's root path including the script, e.g. /Applications/MAMP/htdocs/files-explorer/index.php
    echo '<h2>script directory: <span class="directory-info">' . realpath(__FILE__) . '</span></h2><br>';
    // site's root path without the script's filename, e.g. /Applications/MAMP/htdocs/files-explorer/
    define('ROOT_DIR', realpath(__DIR__));
    echo '<h2>root directory: <span class="directory-info">' . ROOT_DIR . '</span></h2><br>';
    echo '</div>';
    echo '</header>';
    /* --------------------------------- */

    echo '<main>';

    /* ----------- CHANGE DIRECTORY ----------- */
    echo '<section><div class="current-directory-container">';
    // check whether a folder has been clicked
    if (isset($_POST['selected_item'])) {
      // store <form> passed value
      $selected_item = $_POST['selected_item'];
      echo '<h4>selected item: <span class="directory-info">' . $selected_item . '</span></h4><br>';
      // check whether to move to a new directory or not
      if (chdir($selected_item)) {
        chdir($selected_item);
        echo '<h4>directory successfully changed!</h4><br>';
      } else {
        chdir(getcwd());
        // $selected_item = getcwd();
        echo '<h4>failed to change directory!</h4><br>';
      }
    }
    /* --------------------------------- */

    /* ----------- CHECK CURRENT DIRECTORY ----------- */
    // check whether cwd is different than the virtual host
    if (getcwd() !== ROOT_DIR) {
      // remove '/' from path and split it into individual items
      $cwd = explode(DIRECTORY_SEPARATOR, getcwd());
      // get parent directory of every file and folder
      $parent_directory = DIRECTORY_SEPARATOR . $cwd[sizeof($cwd) - 1] . DIRECTORY_SEPARATOR;
      echo '<h4>parent directory: <span class="directory-info">' . $parent_directory . '</span></h4><br>';
      echo '<h4>cwd different than virtualhost</h4><br>';
    } else {
      // store absolute path as a single value array
      $cwd = array(getcwd());
      // add a slash
      $parent_directory = DIRECTORY_SEPARATOR;
      echo '<h4>cwd same as virtualhost</h4><br>';
    }
    echo '</div></section>';
    /* --------------------------------- */

    /* ----------- ITERATE OVER CURRENT DIRECTORY ----------- */
    // get current working directory
    $cwd_content = scandir(getcwd());

    echo '<section><div class="content-container">';
    // iterate over directory
    foreach ($cwd_content as $item) {
      $item_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $item);
      $file_type = str_replace('/', ' ', mime_content_type(realpath($item)));
      // check whether the item is a directory
      if (is_dir(realpath($item))) {
        if ($item === '.') {
          // add form tag with post method
          echo '<form method="post" action="" enctype="application/x-www-form-urlencoded">';
          echo '<input type="hidden" name="selected_item" value="' . realpath($item) . '">';
          echo '<a class="fa fa-folder-open-o" href="' . $parent_directory . $item . '">';
          echo '<button type="submit">' . $item_name . '</button>';
          echo '</a>';
          echo '</form>' . '<br>';
        } else {
          echo '<form method="post" action="" enctype="application/x-www-form-urlencoded">';
          echo '<input type="hidden" name="selected_item" value="' . realpath($item) . '">';
          echo '<a class="fa fa-folder-o" href="' . $parent_directory . $item . '">';
          echo '<button type="submit">' . $item_name . '</button>';
          echo '</a>';
          echo '</form>' . '<br>';
        }
        // or a file
      } elseif (is_file(realpath($item))) {
        if (strpos($file_type, 'image') !== false) {
          // add anchor tag to open file
          echo '<a class="fa fa-file-image-o file" href="' . $parent_directory . $item . '"><button type="submit">' . $item_name . '</button></a>' . '<br>';
        } elseif (strpos($file_type, 'text') !== false) {
          echo '<a class="fa fa-file-text-o file" href="' . $parent_directory . $item . '"><button type="submit">' . $item_name . '</button></a>' . '<br>';
        } elseif (strpos($file_type, 'audio') !== false) {
          echo '<a class="fa fa-file-sound-o file" href="' . $parent_directory . $item . '"><button type="submit">' . $item_name . '</button></a>' . '<br>';
        } else {
          echo '<a class="fa fa fa-file-o file" href="' . $parent_directory . $item . '"><button type="submit">' . $item_name . '</button></a>' . '<br>';
        }
      }
    }
    echo '</div></section>';
    /* --------------------------------- */

    /* ----------- MODAL ----------- */
    echo "<div id=\"myModal\" class=\"modal\">";
    echo "<span id=\"close\" class=\"go-to-parent-directory\">&times;</span>";
    echo "<div class=\"display-content\">";
    echo "<div class=\"slide\">";
    echo "<img src=\"intro-bg.jpg\" class=\"file test-img\">";
    echo "</div>";
    echo "</div>";
    echo "</div>";
    /* --------------------------------- */

    echo '</main>';



    /* ----------- TEST ZONE ----------- */

    /* --------------------------------- */







    ?>

    <script type="text/javascript" src="script.js"></script>
  </body>
</html>
