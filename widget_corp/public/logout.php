<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/functions.php") ?>

<?php
  // Destroy session

  session_start();

  // Set session to empty array
  $_SESSION = array();

  // Check to see if the cookie for that session name is there
  if (isset($_COOKIE[session_name()])) {
    // Destroy the cookie by giving it a time in the past so it expires
    setcookie(session_name(), '', time()-4200, '/');
  }
  // Destroy the session file on the server
  session_destroy();
  redirect_to("login.php");
?>
