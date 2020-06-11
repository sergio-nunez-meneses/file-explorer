<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sergio Núñez Meneses">
    <script src="https://use.fontawesome.com/275ae55494.js"></script>
    <link rel="stylesheet" href="style.css">
    <title>File Explorer</title>
  </head>
  <body>

    <?php

    /* ----------- PREVENT MOVING TO VIRTUALHOST'S PARENT FOLDER ----------- */
    /* check whether the cwd is different than the virtualhost
    if (getcwd() !== ) {
    } else {
    }
    */
    /* --------------------------------- */

    /* ----------- SET DIRECTORY VARIABLES ----------- */
    define('ROOT_DIR', realpath(__DIR__)); // get absolute path

    echo '<header>';
    echo '<div class="header-container">';
    // server protocol
    $protocol = empty($_SERVER['HTTPS']) ? 'http' : 'https';
    // domain name
    $domain = $_SERVER['SERVER_NAME'];
    // concatenate all variables to get the complete base url
    $base_url = "${protocol}://${domain}";
    // display base url
    echo "<h5>server root: <span class=\"directory-info\">$base_url</span></h5>";
    echo '</div>';

    /* ----------- CHANGE DIRECTORY ----------- */
    echo '<div class="cwd-container">';
    // check if a folder has been clicked
    if (isset($_POST['selected_item'])) {
      $selected_item = $_POST['selected_item']; // store folder path
      chdir($selected_item);
    } else {
      $selected_item = getcwd();
    }

    /* ----------- FORMAT SERVER URL ----------- */
    echo '<div class="cwd-container">';
    // absolute path without script folder
    $base_dir = dirname(ROOT_DIR);
    // format url for files
    $url = str_replace($base_dir, $base_url, $selected_item);
    echo "<h3>url: <span class=\"directory-info\">$url</span></h3>";
    echo '</div>';
    echo '</header>';

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
          echo '<form method="get" enctype="application/x-www-form-urlencoded">';
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

    /* ----------- CREATE AND DELETE FILES ----------- */
    echo '<div class="control">';
    echo '<div>';
    echo '<form method="post" enctype="application/x-www-form-urlencoded">';
    echo "<input type=\"text\" name=\"create_file\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="create">Create</button>';
    echo "<input type=\"text\" name=\"delete_file\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="delete">Delete</button>';
    echo '</form>';
    echo '<form method="post" enctype="application/x-www-form-urlencoded">';
    echo "<input type=\"text\" name=\"copy_file\" value=\"\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="copy">Copy</button>';
    echo "<input type=\"text\" name=\"move_file\" value=\"\" placeholder=\"file or folder\">";
    echo '<button type="submit" name="move">Move</button>';
    echo '</form>';
    echo '</div>';
    echo '</div>';
    echo '</div>'; // end table container divs
    echo '</section>';
    echo '</main>';

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
