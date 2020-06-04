<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <script src="https://use.fontawesome.com/275ae55494.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>File Explorer</title>
  </head>
  <body>

    <?php

    echo '<h1>Hello PHP</h1>';
    echo '<h5>Current directory: /' . $_SERVER['SERVER_NAME'] . '</h5>'; // get current server name, e.g. my.local

    $dir = getcwd(); // get path to current working directory (cwd)
    $dir_content = scandir($dir); // grab and store cwd's elements
    echo '<table>'; // begin table
    echo '<tr><th>File</th><th>Size</th><th>Type</th><th>Date</th></tr>'; // table row and heading
    foreach ($dir_content as $files) {
      if(is_file($files)) {
        $file_absolute_path = $dir . $files; // get files' absolute path
        $file_extension = pathinfo($file_absolute_path); // get files' extensions
        echo '<tr><td><a href="/' . $files . '">' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $files) . '</a></td><td>' . filesize($files) . 'bytes</td><td>' . $file_extension['extension'] . '</td><td>' . date('d-m-y', filectime($files)) . '</td></tr>';
      } elseif (is_dir($files)) {
        if ($files == ".") {
          echo '<tr><td><a href="' . dirname($dir, 1) . '">' . $files . '</a></td></tr>';
        } elseif ($files == "..") {
          echo '<tr><td><a href="' . dirname($dir, 2) . '">' . $files . '</a></td></tr>';
        } else {
          echo '<tr><td><a href="/' . $files . '">' . $files . '</a></td></tr>';
        }
      }
    }
    echo '</table>'; // end table

    /*

    echo '<h5>Current directory: /' . basename($dir) . '</h5>'; // display cwd
    echo '<h5>Whole path: ' . $dir . '</h5>'; // display cwd
    dirname($dir, 1) : go one folder back

    */

    ?>

  </body>
</html>

<!-- <h1>Index of /</h1>
<ul><li><a href="acs-logo/"> acs-logo/</a></li>
<li><a href="bootstrap-integration-test/"> bootstrap-integration-test/</a></li>
<li><a href="bootstrap-modal-carousel/"> bootstrap-modal-carousel/</a></li>
<li><a href="bootstrap-test-02/"> bootstrap-test-02/</a></li>
<li><a href="bootstrap-test/"> bootstrap-test/</a></li>
<li><a href="integration-template-restaurant/"> integration-template-restaurant/</a></li>
<li><a href="php-file-explorer/"> php-file-explorer/</a></li>
<li><a href="php-projects/"> php-projects/</a></li>
<li><a href="php_workshop/"> php_workshop/</a></li>
<li><a href="restaurant-integration-test/"> restaurant-integration-test/</a></li>
<li><a href="test-atom/"> test-atom/</a></li>
</ul> -->
