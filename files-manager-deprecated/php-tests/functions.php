<?php

function path($dir) {
  if ($dir == '') { // if empty directory
    return './'; // return root directory
  }
  $dir = str_replace('//', '/', str_replace('\\', '/', $dir)); // url format based on OS
  if ($dir[strlen($dir)-1] != '/') { // if last character not a slash
    $dir .= '/'; // add it
  }
  return $dir;
  echo "<dir>returned dir: $dir";
}

/* ------- */
/*
function rec_list_files($from = '.') {
  if(!is_dir($from))
  return false; // break function

  $files = array();
  if($dh = opendir($from)) {
    while(($file = readdir($dh)) !== false) {
      // skip '.' and '..'
      if($file == '.' || $file == '..' || $file == '.git')
      continue;
      $path = $from . DIRECTORY_SEPARATOR . $file;

      if(is_dir($path)) {
        $files += rec_list_files($path);
        echo '<br>folder';
      }

      else {
        $files[] = $path;
        echo '<br>file';
      }

    }
    // print_r($files);
    closedir($dh);
  }
  return $files;
}

rec_list_files(ROOT_DIR);
*/

?>
