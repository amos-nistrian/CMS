<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>

<?php
  $current_page = $_GET["page"];
  $current_subject = $_GET["subject"];
  if (!$current_page) {
    // page ID was missing or invalid or
    // page couldn't be found in database
    redirect_to("manage_content.php");
  }

  $id = $current_page;
  $query = "DELETE FROM pages WHERE id = {$id} LIMIT 1";
  $result = mysqli_query($connection, $query);

  if ($result && mysqli_affected_rows($connection) == 1) {
    // Success
    $_SESSION["message"] = "Page deleted.";
    redirect_to("manage_content.php");

  } else {
    // Failure
    $_SESSION["message"] = "Page deletion failed.";
    redirect_to("manage_content.php");
  }

?>
