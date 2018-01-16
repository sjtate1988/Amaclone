<!-- This page destroys the current session, logging the user out and sending them to the home page. -->
<?php
session_start();
unset($_SESSION['logged_in']);
session_destroy();
header('location: index.php');
 ?>
