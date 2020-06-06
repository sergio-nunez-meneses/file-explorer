<?php

include('index.php');




/*
defined('ROOT_PATH')? null: define('ROOT_PATH', $_SERVER['DOCUMENT_ROOT']);
$my_path = ROOT_PATH . dir(__file__);
echo '<br>root path: ' . $my_path . '<br>';
*/

/*
    $dir_content = scandir(getcwd());

    echo '<div class="table-container">';
    echo '<table>';
    foreach ($dir_content as $content) {
      if ($content !== '.') {
        if (is_dir($content)) {
          echo "<tr><td><a href=$content>". $content .'</a></td></tr>';
        } else {
          echo "<tr><td><a href=$content>" . preg_replace('/\\.[^.\\s]{3,4}$/', '', $content) . '</a></td></tr>';
        }
      }
    }
    echo '</table>';
    echo '</div>';

    // form
    echo '<br><small>Change directory</small><br>';
    echo '<form name="form" method="post" action="open-directory.php" enctype="application/x-www-form-urlencoded">';
    echo '<input type="text" name="selected" value="">';
    echo '</form>';

    // return error
    if ($_GET['error'] == 'yep') {
      echo '<br>sorry, not in array<br>';
    }
    */
    
?>
