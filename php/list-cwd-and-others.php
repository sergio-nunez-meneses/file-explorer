<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <title></title>
  </head>
  <body>
    <?php

    echo '<tr>':
    // echo '<td>';
    // echo '<a href="' . $file . '"><button>' . preg_replace('/\\.[^.\\s]{3,4}$/', '', $files) . '</button></a>';
    // echo '</td>';
    echo '<td>' . filesize($files) . 'bytes</td>';
    echo '<td>' . $file_extension['extension'] . '</td>';
    echo '<td>' . date('d-m-y', filectime($files)) . '</td>';
    echo '</tr>';
  } elseif (is_dir($files)) {
    if ($files == '.') {
      echo '<tr><td><a href="hola">' . $files . '</a></td></tr>';
    } elseif ($files == '..') {
      echo '<tr><td><a href="chao">' . $files . '</a></td></tr>';
    } else {
      /*
      echo '<form method="post">';
      echo '<input type="hidden" name="clicked" value="' . $files . '">';
      echo "<a href=/\"$dir?dir=" . rawurlencode($file) . "\"><button type='submit'>" . $files . '</button></a>';
      echo '</form>';
      */
      echo '<tr><td><a href="/' . $files . '">' . $files . '</a></td></tr>';
    }
  }
}

    /*
    $dir = dirname(getcwd());
    echo getcwd() . '<br>';
    echo $dir . '<br>';
    echo $_SERVER["REQUEST_URI"] . '<br>';
    echo $_SERVER['HTTP_HOST'] . '<br>';
    echo dirname(getcwd()) . '<br>';
    echo dirname(getcwd(),1) . '<br>';
    echo dirname(getcwd(),2) . '<br>';
    echo dirname(getcwd(),3) . '<br>';
    */

    // display all current working directory's folders, subfolder and files
    function list_directory($name) {
      // if is a valid directory
      if ($dir = opendir($name)) {
        // cwd
        while($file = readdir($dir)) {
          echo $file . '<br>';
          // folders and subfolders
          if(is_dir($file) && !in_array($file, array(".",".."))) {
            list_directory($file); // list folder and subfolders' files
          }
        } // while loop
        closedir($dir);
      }
    }
    list_directory(".");

    echo '<br>';

    echo '<div class="myPath">';
    // display all current working directory's folders, subfolder and files
    function list_dir($name, $level=0) {
      // if valid directory
      if ($dir = opendir($name)) {
        while($file = readdir($dir)) {
          // check path levels
          for($i = 1; $i <= (4*$level); $i++) {
            echo '&nbsp;'; // a space that will not break into a new line
          }
          echo $file . '<br>';
          if(is_dir($file) && !in_array($file, array(".", ".."))) {
            list_dir($file, $level+1);
          }
        }
        closedir($dir);
      }
    }
    list_dir(".");
    echo '</div>';

    /* display files from current working directory
    $d = dir(".");
    echo "Handle: " . $d->handle . "<br>";
    echo "Path: " . $d->path . "<br>";

    while (($file = $d->read()) !== false) {
      echo $file . '<br>';
    }
    $d->close();

    echo '<br>';
    */

    /*
    if ($dir = opendir(".")) {
      echo "Handle: " . $dir . '<br>';
      echo "Path: " . getcwd() . '<br>';
      while($file = readdir($dir)) {
        echo $file . '<br>';
      }
      closedir($dir);
    }
    */


    /* parsing path test
    $path_parts = pathinfo(getcwd());
    echo '<ul>';
    $files1 = scandir($path_parts['dirname']);
    foreach ($files1 as $key => $value) {
      echo '<li class="myFiles fa fa-folder">' . '<a>' . $value . '</a>' . '</li>';
    }
    */

    /*
    a more object-oriented
    $d = dir(getcwd());

    echo "Handle: " . $d->handle . "<br>";
    echo "Path: " . $d->path . "<br>";

    while (($file = $d->read()) !== false) {
      echo "filename: " . $file . "<br>";
    }
    $d->close();

    display files
    $fileList = glob('/Applications/MAMP/htdocs/php-file-explorer/*'); // find pathnames matching a pattern
    foreach($fileList as $filename) { // iterate over the array
      if(is_file($filename)) { // make sure that it is not a directory
        echo "<table  width='80%' align='center' style='boder: 1px solid #ccc'><tr>";
        echo "<th width='20%'> $filename </th>" . '<br>';
        echo  "</tr>";
      }
    }

    $dir = "/Users/sergionunez/desktop/";
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          echo "filename:" . $file . "<br>";
        }
        closedir($dh);
      }
    }

    $dir = "/Users/sergionunez/Desktop";
    echo '<a href=' . $dir . '>Click here</a>';
    if (is_dir($dir)){
      if ($dh = opendir($dir)){
        while (($file = readdir($dh)) !== false){
          echo '<li>' . $file . '</li><br>';
        }
        closedir($dh);
      }
    }
    */


    # somewhere in your index.php
    define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
    # in any included file
    $my_path = ROOT_PATH . dir(__file__);
    echo $my_path;

    echo '<header>';
    echo '<h1>My File Explorer</h1>';
    echo '<p>' . date('l jS \of F Y h:i:s A') . '<p>';
    echo '</header>';

    echo '<div class="my-path">';
    echo $PHP_SELF;
    // display all current working directory's folders, subfolder and files
    function list_dir($name, $level=0) {
      // if valid directory
      if ($dir = opendir($name)) {
        while($entry = readdir($dir)) {
          $file = $name."/".$entry;
          // check path levels
          for($i = 1; $i <= (4*$level); $i++) {
            echo '&nbsp;'; // a space that will not break into a new line
          }
          if($file == $cur) {
            echo "<b>$entry</b><br />\n";
          } else {
            echo "<a href=\"$my_path?dir=".rawurlencode($file)."\">$entry</a><br />\n";
          }
          if(is_dir($file) && !in_array($file, array(".", ".."))) {
            list_dir($file, $level+1);
          }
        }
        closedir($dir);
      }
    }
    list_dir(".");
    echo '</div>';

    /*
    $BASE = "../..";
    function list_dir($base, $cur, $level=0) {
      global $PHP_SELF, $BASE;
      if ($dir = opendir($base)) {
        while($entry = readdir($dir)) {
          $file = $base."/".$entry;
          if(is_dir($file) && !in_array($entry, array(".",".."))) {
            for($i=1; $i<=(4*$level); $i++) {
                echo "&nbsp;";
            }
            if($file == $cur) {
              echo "<b>$entry</b><br />\n";
            } else {
              echo "<a href=\"$PHP_SELF?dir=".rawurlencode($file)."\">$entry</a><br />\n";
            }
            if(ereg($file."/",$cur."/")) {
                list_dir($file, $cur, $level+1);
            }
          }
        }
        closedir($dir);
      }
    }
    function list_file($cur) {
      if ($dir = opendir($cur)) {
        while($file = readdir($dir)) {
          echo "$file<br />\n";
        }
        closedir($dir);
      }
    }
    */









    echo '<br><br><br>';
    echo '<form method="post">';
    echo '<label for="directory">Choose Directory</label> ';
    echo '<input type="text" name="directory"> ';
    echo '<button type="submit" name="submit" value="Submit">Submit</button> ';
    echo '</form>';

    if (isset($_POST['submit'])) {
      $new_dir = $_POST['directory'];
      echo $new_dir;
    }





    ?>

  </body>
</html>
