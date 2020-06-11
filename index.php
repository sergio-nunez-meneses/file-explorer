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

    include('constants.php');
    include('actions.php');

    ?>

    <!-- SHOW DIRECTORY INFORMATION -->
    <header>
      <section>
        <div class="header-container">
          <h3>server base url: <span class="directory-info">
            <?php echo $base_url; ?>
          </span></h3>
          <h3>filename: <span class="directory-info">
            <?php echo $_SERVER['PHP_SELF']; ?>
          </span></h3>
          <h3>root directory: <span class="directory-info">
            <?php echo ROOT_DIR; ?>
          </span></h3>
        </div>
      </section>
    </header>

    <!-- CURRENT DIRECTORY CONTENT -->
    <main>
      <section>
        <div class="">
          <?php

          // change directory on folder click
          if (!empty($_GET['dir'])) {
            $from = $_GET['dir'];
            echo "<br>path from clicked folder: $from";
          } else {
            $from = ROOT_DIR;
          }
          chdir($from);

          // format url to open files
          $url = str_replace(dirname(ROOT_DIR), $base_url, $from) . '/';
          echo "<br>server url: $url";

          echo '<div style="float:right;"><a href="?dir=./">Root</a></div>'; // this is working but it prepends './' $url

          if (!is_dir($from)) die ("Cannot open directory: $from"); // break
            // open current directory
            if ($dh = opendir($from)) {
              // iterate over current directory
              while(($file = readdir($dh)) !== false) {
                // skip '.', '..' and '.git'
                if ($file == '.' || $file == '..' || $file == '.git')
                continue;
                $path = $from . '/' . $file;

                if (is_dir($path)) echo '<br><a href="?dir='.urlencode($path).'" title="' . $path .'">' . $file .'</a>';
                else echo "<br><a href=\"${url}${file}\" title=\"${url}/${file}\">$file</a>";
              }
              closedir($dh);
            }

          ?>
        </div>
      </section>
    </main>

    <!-- CREATE AND DELETE FILES -->
    <section>
      <div class="control">
        <div>
          <form method="post" action="actions.php" enctype="application/x-www-form-urlencoded">
            <input type="text" name="create_file" placeholder="file or folder">
            <button type="submit" name="create">Create</button>
            <input type="text" name=\"delete_file" placeholder="file or folder">
            <button type="submit" name="delete">Delete</button>
          </form>
          <form method="post" action="actions.php" enctype="application/x-www-form-urlencoded">
            <input type="text" name="copy_file" placeholder="file or folder">
            <button type="submit" name="copy">Copy</button>
            <input type="text" name="move_file" placeholder="file or folder">
            <button type="submit" name="move">Move</button>
          </form>
        </div>

        <?php

        if (!empty($_GET['exists']) && $_GET['exists'] == "yes") {
          echo "<p>File already exists</p>";
        } elseif (!empty($_GET['folder']) && $_GET['folder'] == "created") {
          echo "<p>Folder created</p>";
        } elseif (!empty($_GET['file']) && $_GET['file'] == "created") {
          echo "<p>File created</p>";
        } elseif (!empty($_GET['copied']) && $_GET['copied'] == "yes") {
          echo "<p>File copied</p>";
        } elseif (!empty($_GET['deleted']) && $_GET['deleted'] == "yes") {
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
          echo "<p>File deleted</p>";
        }

        ?>

      </div>
    </section>

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



    /* ----------- TEST ZONE ----------- */
    /* --------------------------------- */

    ?>

    <!-- <script type="text/javascript" src="script.js"></script> -->
  </body>
</html>
