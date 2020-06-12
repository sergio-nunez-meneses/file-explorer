<?php

if (isset($_POST['selected_file'])) {
  $selected_file = $_POST['selected_file'];
  echo "<section><div id=\"myModal\" class=\"modal\">";
  echo "<span id=\"close\" class=\"go-to-parent-directory\">&times;</span>";
  echo "<div class=\"modal-content\">";
  echo "<div class=\"slide\">";
  echo "<img src=\"intro-bg.jpg\" class=\"file test-img\">";
  echo "</div>";
  echo "</div>";
  echo "</div></section>";
}

?>
