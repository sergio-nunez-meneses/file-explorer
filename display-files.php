<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="author" content="Sergio Núñez Meneses">
    <script src="https://use.fontawesome.com/275ae55494.js"></script>
    <link rel="stylesheet" href="main.css">
    <title>File Explorer</title>
  </head>
  <body style="background-color: rgba(0, 0, 0, 0.8);">

    <?php

    if (isset($_POST['selected_file'])) {
      $selected_file = $_POST['selected_file'];
      echo $selected_file;
      echo '<div class="display-content">';
      echo '<a href="index.php">&times;</a>';
      echo '<img src="intro-bg.jpg" class="test-img">';
      echo '</div>';
    }

    ?>
