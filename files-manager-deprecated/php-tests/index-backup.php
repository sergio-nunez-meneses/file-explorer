<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sergio Núñez Meneses">
    <link rel="stylesheet" href="main.css">
    <title>File Explorer</title>
  </head>
  <body>

    <!--my path: /Applications/MAMP/htdocs/php-file-explorer -->

    <?php

    // MOVE THROUGH DIRECTORIES
    if (isset($_POST['selected_directory'])) {
      echo '<br>selected directory: '. $_POST['selected_directory'];
      $selected_directory = $_POST['selected_directory'];
      $selected_directory = getcwd();
    }
    chdir($selected_directory);
    echo '<br>directory changed: ';
    print_r(chdir($selected_directory));
    echo ' (TRUE)<br>';
    echo 'so..., WHY THE FUCK IS NOT CHANGING ?!<br>';

    // DIRECTORIES' BAR
    echo '<header>';
    echo $_SERVER["DOCUMENT_ROOT"];
    echo '<div class="navbar-container">';
    // path increment
    $path_builder = '';
    //step through current working directory
    foreach ($cwd as $item) {
      // item's path increment
      $path_builder = $path_builder . $item . DIRECTORY_SEPARATOR;
      echo "<form method='POST' action='' enctype='application/x-www-form-urlencoded'>";
      echo "<input type='hidden' name='selected_directory' value='" . $path_builder . "'>";
      echo "<a href='$path_builder'><button type='submit'>" . $item . "</button></a>";
      echo "</form>";
      echo $path_builder;
    }
    echo '</div>';
    echo '</header>';

    // DISPLAY DIRECTORY'S CONTENT
    echo '<main>';
    echo '<div class="content-container">';
    $content = scandir(getcwd());
    foreach ($content as $item) {
      if (($item !== '.' && $item !== '..' && $item !== '.git') && is_dir($selected_directory . DIRECTORY_SEPARATOR . $item)) {
        echo "<form method='POST' action='' enctype='application/x-www-form-urlencoded'>";
        echo "<input type='hidden' name='selected_directory' value='" . getcwd() . DIRECTORY_SEPARATOR . $item . "'>";
        echo "<a href='" . getcwd() . DIRECTORY_SEPARATOR . $item . '"><button type="submit">' . $item . "</button></a>";
        echo "</form>";
      } else {
        echo "<a href='" . $item . "'><button>" . $item . "</button></a>";
      }
    }
    echo '</div>';
    echo '</main>';

    ?>

  </body>
</html>
