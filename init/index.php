<?php include('constants.php'); include('actions.php'); ?>

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

    /* CHECK CURRENT WORKING DIRECTORY OR CHANGE IT ON FOLDER CLICK */
    if (!empty($_GET['dir'])) $from = $_GET['dir'];
    else $from = ROOT_DIR;

    chdir($from);

    /* an idea for denying access to folder before virtualhost
    if current directory is not equal to dirname(ROOT_DIR, 2) "change directory" else "not change" */

    ?>

    <!-- BREADCRUMB NAVIGATION -->
    <header>
      <section>
        <nav>
          <div class="breadcrumb-container">
            <div class="breadcrumb-title">
              <h1>file manager</h1>
            </div>
            <div class="breadcrumb-content">
              <table>
                <tr>
                  <?php

                  // break absolute path into individual items
                  $cwd = explode(DIRECTORY_SEPARATOR, getcwd());
                  $cwd_accum = ''; // initialize increment
                  // iterate over root directory
                  foreach ($cwd as $item) {
                    $cwd_accum = $cwd_accum . $item . DIRECTORY_SEPARATOR; // recursive path increment
                    echo "<td><a href=\"?dir=$cwd_accum\" title=\"$cwd_accum\">$item</a></td>";
                  }

                  ?>
                </tr>
              </table>
            </div>
          </div>
        </nav>
      </section>
    </header>

    <!-- LIST CURRENT DIRECTORY CONTENT -->
    <main>
      <section>
        <div class="manager-container">
          <div class="table-container">
            <table>
            <?php

            // format url to open files
            $url = str_replace(dirname(ROOT_DIR), $base_url, $from) . '/';
            // scan directory
            if (!is_dir($from)) die ("Cannot open directory: $from"); // break
              // open current directory
              if ($dh = opendir($from)) {
                // iterate over current directory
                while(($file = readdir($dh)) !== false) {
                  // skip '.', '..' and '.git'
                  if ($file == '.' || $file == '..' || $file == '.git')
                  continue;
                  $path = $from . '/' . $file;

                  /* get file information */
                  $file_name = preg_replace('/\\.[^.\\s]{3,4}$/', '', $file);
                  $file_size = filesize($file);
                  $file_type = str_replace('/', ' ', mime_content_type(realpath($file)));
                  $file_extension = pathinfo(realpath($file));
                  $file_creation_date = date('d-m-y', filectime($file));

                  /* list current directory content */
                  if (is_dir($path)) {
                    echo '<tr>';
                    echo '<td><i class="fa fa-folder-o"></i><a href="?dir='. urlencode($path) . '" title="' . $path .'">' . $file .'</a></td>';
                    echo "<td>$file_size</td><td>$file_type</td><td>no</td><td>$file_creation_date</td>";
                    echo '</tr>';
                  } else {
                    echo '<tr>';
                    echo "<td><i class=\"fa fa-file-o file\"></i><a class=\"file\" href=\"${url}${file}\" title=\"${url}/${file}\">$file</a></td>";
                    echo "<td>$file_size</td><td>$file_type</td><td>" . $file_extension['extension'] . "</td><td>$file_creation_date</td>";
                    echo '</tr>';
                  }
                }
                closedir($dh);
              }

            ?>
          </table>
          </div>

          <!-- ACTION FORM -->
          <div class="control">
            <form method="post" action="" enctype="application/x-www-form-urlencoded">
              <input type="text" name="create_file" placeholder="file or folder">
              <button type="submit" name="create">Create</button>
              <input type="text" name="delete_file" placeholder="file or folder">
              <button type="submit" name="delete">Delete</button>
              <input type="text" name="copy_file" placeholder="file or folder">
              <button type="submit" name="copy">Copy</button>
              <input type="text" name="move_file" placeholder="file or folder">
              <button type="submit" name="move">Move</button>
              <!-- to do for copying qnd pasting files (create this with a loop)
              <select>
                <option selected>Folder 1</option>
                <option>Folder 2</option>
                <option>Folder 3</option>
                <option>Folder 4</option>
                <option>Folder 5</option>
                <option>Folder 6</option>
                <option>Folder 7</option>
                <option>Folder 8</option>
              </select> -->
            </form>
          </div>
        </div>
      </section>

    </main>

    <?php

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

    ?>

    <!-- <script type="text/javascript" src="script.js"></script> -->
  </body>
</html>
