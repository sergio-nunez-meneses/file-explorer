<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sergio Núñez Meneses">
    <!-- <script src="https://use.fontawesome.com/275ae55494.js"></script> -->
    <link rel="stylesheet" href="main.css">
    <title>File Explorer</title>
  </head>
  <body>

    <?php

    if (isset($_POST['create'])) {
      $new_file = $_POST['new_file'];
      if (!in_array($new_file, $dir_content)) {
        if (is_file($new_file)) {
          echo "yes";
        } else {
          echo "no, is a directory";
        }
        /*
        $content = "This is a dummy line";
        $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/' . $new_file, "wb");
        fwrite($fp, $content);
        fclose($fp);
        echo "File successfully created!";
        */
      } else {
        echo "File already exists!";
      }
      echo "<meta http-equiv='refresh' content='0'>";
        /*
        if (!file_exists($new_file)) {
          $content = "This is a dummy line";
          $fp = fopen($_SERVER['DOCUMENT_ROOT'] . '/' . $new_file, "wb");
          fwrite($fp, $content);
          fclose($fp);
          echo "File successfully created!";
        } else {
          echo "The file already exists!";
        }
      } else {
        mkdir($_SERVER['DOCUMENT_ROOT'] . '/' . $new_file);
        echo "Folder successfully created!";
      }
      */
    }

    /* ----------- CHANGE DIRECTORY ----------- */
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
    echo '<div class="cwd-container">';
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
    // check whether the cwd is different than the virtualhost
    if (getcwd() !== ROOT_DIR) {
      // $last_directory = $cwd[sizeof($cwd) - 1]; // always get the last directory of the path
      // $parent_directory = DIRECTORY_SEPARATOR . $last_directory . DIRECTORY_SEPARATOR;
      // echo "<h4>parent directory: <span class=\"directory-info\">$parent_directory</span></h4><br>";
    } else {
      // $parent_directory = DIRECTORY_SEPARATOR; // if it's the virtualhost, prepend just a slash
    }
    /* --------------------------------- */

    /* ----------- FORMAT SERVER URL ----------- */
    echo '<div class="cwd-container">';
    // absolute path without script folder
    $base_dir = dirname(ROOT_DIR);
    // format url for files
    $url = str_replace($base_dir, $base_url, $selected_item);
    echo "<h2>url: <span class=\"directory-info\">$url</span></h2>";
    echo '</div>';
    echo '</header>';
    /* --------------------------------- */

    /* ----------- NAVBAR MENU ----------- */
    echo '<div class="breadcrumb-container">';
    echo '<table>'; // begin table
    echo '<tr>';
    // remove '/' from path and split it into individual items
    $cwd = explode(DIRECTORY_SEPARATOR, getcwd());
    $cwd_accum = ''; // initialize increment
    // iterate over root directory
    foreach ($cwd as $file) {
      $cwd_accum = $cwd_accum . $file . DIRECTORY_SEPARATOR; // recursive path increment
      echo '<td>';
      echo '<form method="post" enctype="application/x-www-form-urlencoded">';
      echo "<input type=\"hidden\" name=\"selected_item\" value=\"" . $cwd_accum . "\">";
      echo "<button type=\"submit\">$file</button>";
      echo "</form>";
      echo '</td>';
    }
    echo '</tr>';
    echo '</table>';
    echo '</div>';
    /* --------------------------------- */

    /* ----------- DISPLAY CURRENT DIRECTORY ITEMS ----------- */
    echo '<main>';
    echo '<section><div class="table-container">';
    echo '<div class="table">';
    echo '<table>'; // begin table
    echo '<tr><th>File</th><th>Size</th><th>Type</th><th>Extension</th><th>Date</th></tr>';
    // get current working directory
    $cwd_content = scandir(getcwd());
    // iterate over current working directory
    foreach ($cwd_content as $file) {
      $file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file); // get item name
      $file_size = filesize($file); // get file size
      $file_type = str_replace('/', ' ', mime_content_type(realpath($file))); // get file type
      $file_extension = pathinfo(realpath($file)); // get file extension
      $file_creation_date = date('d-m-y', filectime($file)); // get file creation date
      // check whether the item is a directory
      if (is_dir(realpath($file))) {
        // add <form> tag with post method for changing directory
        if ($file === '.') {
          echo '<tr>';
          // name
          echo '<td>';
          echo '<form method="post" enctype="application/x-www-form-urlencoded">';
          echo "<input type=\"hidden\" name=\"selected_item\" value=\"" . realpath($file) . "\">";
          echo "<a class=\"fa fa-folder-open-o\">";
          echo "<button type=\"submit\">$file_name</button>";
          echo '</a>';
          echo '</form>';
          echo '</td>';
          // size
          echo "<td>$file_size</td>";
          // type
          echo "<td>$file_type</td>";
          echo "<td>no</td>";
          // date
          echo "<td>$file_creation_date</td>";
          echo '</tr>';
        } else {
          echo '<tr>';
          echo '<td>';
          echo '<form method="post" enctype="application/x-www-form-urlencoded">';
          echo "<input type=\"hidden\" name=\"selected_item\" value=\"" . realpath($file) . "\">";
          echo "<a class=\"fa fa-folder-o\">";
          echo "<button type=\"submit\">$file_name</button>";
          echo '</a>';
          echo '</form>';
          echo '</td>';
          echo "<td>$file_size</td>";
          echo "<td>$file_type</td>";
          echo "<td>no</td>";
          echo "<td>$file_creation_date</td>";
          echo '</tr>';
        }
        // or a file
      } elseif (is_file(realpath($file))) {
        $file = DIRECTORY_SEPARATOR . $file;
        // add <anchor> tag to open file
        if (strpos($file_type, 'image') !== false) {
          echo '<tr>';
          echo '<td>';
          echo "<a class=\"fa fa-file-image-o file\" href=\"${url}${file}\">";
          echo "<button type=\"submit\">$file_name</button>";
          echo '</a>';
          echo '</td>';
          echo "<td>$file_size</td>";
          echo "<td>$file_type</td>";
          echo "<td>" . $file_extension['extension'] . "</td>";
          echo "<td>$file_creation_date</td>";
          echo '</tr>';
        } elseif (strpos($file_type, 'text') !== false) {
          echo '<tr>';
          echo '<td>';
          echo "<a class=\"fa fa-file-text-o file\" href=\"${url}${file}\">";
          echo "<button type=\"submit\">$file_name</button>";
          echo '</a>';
          echo '</td>';
          echo "<td>$file_size</td>";
          echo "<td>$file_type</td>";
          echo "<td>" . $file_extension['extension'] . "</td>";
          echo "<td>$file_creation_date</td>";
          echo '</tr>';
        } elseif (strpos($file_type, 'audio') !== false) {
          echo '<tr>';
          echo '<td>';
          echo "<a class=\"fa fa-file-sound-o file\" href=\"${url}${file}\">";
          echo "<button type=\"submit\">$file_name</button>";
          echo '</a>';
          echo '</td>';
          echo "<td>$file_size</td>";
          echo "<td>$file_type</td>";
          echo "<td>" . $file_extension['extension'] . "</td>";
          echo "<td>$file_creation_date</td>";
          echo '</tr>';
        } else {
          echo '<tr>';
          echo '<td>';
          echo "<a class=\"fa fa-file-o file\" href=\"${url}${file}\">";
          echo "<button type=\"submit\">$file_name</button>";
          echo '</a>';
          echo '</td>';
          echo "<td>$file_size</td>";
          echo "<td>$file_type</td>";
          echo "<td>" . $file_extension['extension'] . "</td>";
          echo "<td>$file_creation_date</td>";
          echo '</tr>';
        }
      }
      echo '</tr>';
    }
    echo '</table>'; // end table
    echo '</div>';
    /* --------------------------------- */

    /* ----------- CREATE AND DELETE FILES ----------- */
    echo '<div class="control">';
    echo '<div>';
    echo '<form method="post" enctype="application/x-www-form-urlencoded">';
    echo "<input type=\"text\" name=\"new_file\" value=\"\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="create">Create</button>';
    echo "<input type=\"text\" name=\"new_file\" value=\"\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="delete">Delete</button>';
    echo '</form>';
    echo '</div>';
    echo '<div>';
    echo '<form method="post" enctype="application/x-www-form-urlencoded">';
    echo "<input type=\"text\" name=\"new_file\" value=\"\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="copy">Copy</button>';
    echo "<input type=\"text\" name=\"new_file\" value=\"\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="move">Move</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>'; // end table container divs
    echo '</section>';
    echo '</main>';
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



    /* ----------- TEST ZONE ----------- */
    /* --------------------------------- */





    ?>

    <!-- <script type="text/javascript" src="script.js"></script> -->
  </body>
</html>
