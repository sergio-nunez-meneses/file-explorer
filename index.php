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

    // get absolute path
    define('ROOT_DIR', realpath(__DIR__));

    echo '<header>';
    echo '<div class="header-container">';
    // server protocol
    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    // domain name
    $domain = $_SERVER['SERVER_NAME'];
    // concatenate all variables to get the complete base URL
    $base_url = "${protocol}://${domain}";
    // display url
    echo "<h4>server root: <span class=\"directory-info\">$base_url</span></h3>";
    echo '</div>';

    /* ----------- CHANGE DIRECTORY ----------- */
    echo '<div class="current-directory-container">';
    // check if a folder has been clicked
    if (isset($_POST['selected_item'])) {
      $selected_item = $_POST['selected_item']; // store folder path
      // check whether to change the current directory or not
      if (chdir($selected_item)) {
        chdir($selected_item);
      } else {
        chdir(getcwd());
      }
    }
    /* ----------- CHECK CURRENT DIRECTORY ----------- */
    // remove '/' from path and split it into individual items
    $cwd = explode(DIRECTORY_SEPARATOR, getcwd());
    // check whether the cwd is different than the virtualhost
    if (getcwd() !== ROOT_DIR) {
      $last_directory = $cwd[sizeof($cwd) - 1]; // always get the last directory of the path
      $parent_directory = DIRECTORY_SEPARATOR . $last_directory . DIRECTORY_SEPARATOR;
      echo "<h4>parent directory: <span class=\"directory-info\">$parent_directory</span></h4><br>";
    } else {
      $parent_directory = DIRECTORY_SEPARATOR; // if it's the virtualhost, prepend just a slash
    }
    /* --------------------------------- */

    /* ----------- FORMAT SERVER URL ----------- */
    echo '<div class="current-directory-container">';
    // absolute path without script folder
    $base_dir = dirname(ROOT_DIR);
    // format url for files
    $url = str_replace($base_dir, $base_url, $selected_item);
    echo "<h2>url: <span class=\"directory-info\">$url</span></h2>";
    echo '</div>';
    echo '</header>';
    /* --------------------------------- */

    /* ----------- NAVBAR MENU ----------- */
    echo '<div class="navbar-container">';
    $cwd_accum = ''; // initialize increment
    // iterate over root directory
    foreach ($cwd as $item) {
      $cwd_accum = $cwd_accum . $item . DIRECTORY_SEPARATOR; // recursive path increment
      echo '<form method="post" enctype="application/x-www-form-urlencoded">';
      echo "<input type=\"hidden\" name=\"selected_item\" value=\"" . $cwd_accum . "\">";
      echo "<button type=\"submit\">$item</button>";
      echo "</form>";
    }
    echo '</div>';
    /* --------------------------------- */

    /* ----------- DISPLAY CURRENT DIRECTORY ITEMS ----------- */
    echo '<main>';
    echo '<section><div class="content-container">';
    // get current working directory
    $cwd_content = scandir(getcwd());
    // iterate over current working directory
    foreach ($cwd_content as $item) {
      $item_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $item); // get item name
      $file_type = str_replace('/', ' ', mime_content_type(realpath($item))); // get file type
      // check whether the item is a directory
      if (is_dir(realpath($item))) {
        // add <form> tag with post method for changing directory
        if ($item === '.') {
          echo '<form method="post" enctype="application/x-www-form-urlencoded">';
          echo "<input type=\"hidden\" name=\"selected_item\" value=\"" . realpath($item) . "\">";
          echo "<a class=\"fa fa-folder-open-o\">";
          echo "<button type=\"submit\">$item_name</button>";
          echo '</a>';
          echo '</form><br>';
        } else {
          echo '<form method="post" enctype="application/x-www-form-urlencoded">';
          echo "<input type=\"hidden\" name=\"selected_item\" value=\"" . realpath($item) . "\">";
          echo "<a class=\"fa fa-folder-o\">";
          echo "<button type=\"submit\">$item_name</button>";
          echo '</a>';
          echo '</form><br>';
        }
        // or a file
      } elseif (is_file(realpath($item))) {
        $item = DIRECTORY_SEPARATOR . $item;
        // add <anchor> tag to open file
        if (strpos($file_type, 'image') !== false) {
          echo "<a class=\"fa fa-file-image-o file\" href=\"${url}${item}\">";
          echo "<button type=\"submit\">$item_name</button>";
          echo '</a><br>';
        } elseif (strpos($file_type, 'text') !== false) {
          echo "<a class=\"fa fa-file-text-o file\" href=\"${url}${item}\">";
          echo "<button type=\"submit\">$item_name</button>";
          echo '</a><br>';
        } elseif (strpos($file_type, 'audio') !== false) {
          echo "<a class=\"fa fa-file-sound-o file\" href=\"${url}${item}\">";
          echo "<button type=\"submit\">$item_name</button>";
          echo '</a><br>';
        } else {
          echo "<a class=\"fa fa-file-o file\" href=\"${url}${item}\">";
          echo "<button type=\"submit\">$item_name</button>";
          echo '</a><br>';
        }
      }
    }
    echo '</div></section>';
    /* --------------------------------- */

    /* ----------- MODAL TEST ----------- */
    echo "<section><div id=\"myModal\" class=\"modal\">";
    echo "<span id=\"close\" class=\"go-to-parent-directory\">&times;</span>";
    echo "<div class=\"modal-content\">";
    echo "<div class=\"slide\">";
    echo "<img src=\"intro-bg.jpg\" class=\"file test-img\">";
    echo "</div>";
    echo "</div>";
    echo "</div></section>";
    /* --------------------------------- */
    echo '</main>';



    /* ----------- TEST ZONE ----------- */

    /* --------------------------------- */







    ?>

    <!-- <script type="text/javascript" src="script.js"></script> -->
  </body>
</html>
