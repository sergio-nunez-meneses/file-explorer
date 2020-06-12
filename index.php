<?php

// include scripts
include 'header.php';
include 'init.php';
include 'constants.php';
include 'actions.php';

/* CHECK CURRENT WORKING DIRECTORY OR CHANGE IT ON FOLDER CLICK */
if (!empty($_GET['dir'])) $cwd = $_GET['dir'];
else $cwd = $init_dir;;

chdir($cwd);

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
              $breadcrumb_menu = explode(DIRECTORY_SEPARATOR, getcwd());
              $path_accum = ''; // initialize increment
              $is_home = false;
              // iterate over root directory
              foreach ($breadcrumb_menu as $item) {
                $path_accum .= $item . DIRECTORY_SEPARATOR; // recursive path increment
                if ($item === $home_dir) {
                  $is_home = true;
                }
                if ($is_home) {
                  echo "<td><a href=\"?dir=$path_accum\" title=\"$path_accum\">$item</a></td>";
                }
              }

              ?>
            </tr>
          </table>
        </div>
      </div>
    </nav>
  </section>

</header>

<main>

  <div class="main-container">
    <!-- LIST CURRENT DIRECTORY CONTENT -->
    <section>
      <div class="table-container">
        <table>
        <?php

        // format url to open files
        $url = str_replace(dirname(ROOT_DIR), $base_url, $cwd) . '/';
        // scan directory
        if (!is_dir($cwd)) die ("Cannot open directory: $cwd"); // break
          // open current directory
          if ($dh = opendir($cwd)) {
            // iterate over current directory
            while(($file = readdir($dh)) !== false) {
              // skip '.', '..' and '.git'
              if ($file == '.' || $file == '..' || $file == '.git')
              continue;
              $path = $cwd . '/' . $file;

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
                echo "<td><i class=\"fa fa-file-o\"></i><a class=\"file\" href=\"${url}${file}\" title=\"${url}/${file}\">$file</a></td>";
                echo "<td>$file_size</td><td>$file_type</td><td>" . $file_extension['extension'] . "</td><td>$file_creation_date</td>";
                echo '</tr>';
              }
            }
            closedir($dh);
          }

        ?>
        </table>
      </div>
    </section>

    <!-- ACTION FORM -->
    <section>
      <div class="control-container">
        <form method="post" enctype="application/x-www-form-urlencoded">
          <input type="text" name="create_file" placeholder="file or folder">
          <button type="submit" name="create">Create</button>
          <input type="text" name="delete_file" placeholder="file or folder">
          <button type="submit" name="delete">Delete</button>
          <input type="text" name="copy_file" placeholder="file or folder">
          <button type="submit" name="copy">Copy</button>
          <input type="text" name="move_file" placeholder="file or folder">
          <button type="submit" name="move">Move</button>
            <?php

            $cwd = scandir(getcwd());

            echo "<select name=\"from_dir\">";
            foreach ($cwd as $file) {
              if (is_dir($file) && $file !== '.' && $file !== '..') {
                echo "<option value=\"$file\" selected>$file</option>";
              }
            }
            echo "</select>";
            echo "<select name=\"to_dir\">";
            foreach ($cwd as $file) {
              if (is_dir($file) && $file !== '.' && $file !== '..') {
                echo "<option value=\"$file\" selected>$file</option>";
              }
            }
            echo "</select>";

            ?>
        </form>
      </div>
    </section>
  </div>

</main>

<?php

include 'footer.php';

?>
