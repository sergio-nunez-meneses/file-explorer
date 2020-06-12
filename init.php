<?php

$home_dir = 'home';
if (!is_dir($home_dir)) mkdir("home");

chdir(getcwd() . DIRECTORY_SEPARATOR . $home_dir);

$init_dir = getcwd();

?>
