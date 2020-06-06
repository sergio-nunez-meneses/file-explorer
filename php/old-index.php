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

    /* HEADER */
    echo '<header><h1>Hello PHP</h1>';
    echo '<h5>Current directory: ' . $_SERVER['SERVER_NAME'] . '</h5></header>'; // get current server name such as /my.local or /localhost

    /* MAIN CONTENT */
    $dir = getcwd(); // get path to current working directory (cwd), e.g. /Applications/MAMP/htdocs/files-explorer
    $dir_content = scandir($dir); // grab and store cwd's elements
    // this also works: $dir = scandir(getcwd());
    echo '<main>';
    echo '<section>';
    echo '<div class="table-container">'; // begin container div
    echo '<div class="my-table">'; // begin table div
    echo '<table>'; // begin table
    echo '<tr><th>File</th><th>Size</th><th>Extension</th><th>Date</th></tr>'; // table row and heading

    foreach ($dir_content as $files) { // step through cwd's files
      if(is_file($files)) {
        // get files' absolute path
        $file_absolute_path = $dir . $files;
        // get files' extensions
        $file_extension = pathinfo($file_absolute_path);

        echo '<tr>';
        // filename
        echo "<td><a href=/$files>" . preg_replace('/\\.[^.\\s]{3,4}$/', '', $files) . '</a></td>';
        // file size
        echo '<td>' . filesize($files) . 'bytes</td>';
        // file extension
        echo '<td>' . $file_extension['extension'] . '</td>';
        // creation date
        echo '<td>' . date('d-m-y', filectime($files)) . '</td>';
        echo '</tr>';
      } elseif (is_dir($files)) {
        // echo '<tr><td><a href="/' . $files . '">' . $files . '</a></td></tr>';
        echo '<tr><td>';
        // echo '<form method="post">';
        echo '<form method="post"><input type="hidden" name="choosen" value="' . $files . '">';
        echo '<a href="' . $files . '"><button type="submit" name"file">' . $files . '</button></a></form>';
        // echo "</form>";
        echo '</td></tr>';
        /*
        if ($files == ".") {
          echo '<tr><td><a href="/' . dirname($dir, 1) . '">' . $files . '</a></td></tr>';
        } elseif ($files == "..") {
          echo '<tr><td><a href="/">' . $files . '</a></td></tr>';
        } else {
          echo '<tr><td><a href="/' . $files . '">' . $files . '</a></td></tr>';
        }
        */
      }
    }
    echo '</table></div>'; // end table and table div

    /*
    if (isset($_POST['choosen'])) {
      $value = $_POST['value'];
      echo $value;
      /*
      $arr = array("si", "oui", "yes", "ja");
      echo $arr[rand(0, 3)];
      */
    //}

    /* CONTROLS */
    /*
    echo '<div class="handle-dir-content">';
    echo '<h3>Create something</h3> ';
    echo '<form method="post" enctype="application/x-www-form-urlencoded">';
    echo '<input type="text" name="new_file" value="" placeholder="file or folder"> ';
    echo '<button type="submit" name="create">Create</button>';
    echo '</form>';
    */
    /* get file/folder name */
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
    echo '</div></div>'; // end handle-dir-content and container div
    echo '</section></main>'; // end section and main tag


    ?>

  </body>
</html>
