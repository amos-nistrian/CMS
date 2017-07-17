<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php confirm_logged_in(); ?>


<?php
if (isset($_POST['submit'])) {

  // Process the form
  $subject_id = $_POST["subject_id"];
  $menu_name = mysql_prep($_POST["menu_name"]);
	$position = (int) $_POST["position"];
	$visible = (int) $_POST["visible"];
  $content = mysql_prep($_POST["content"]);

  //print_r($_POST);
  //print_r($subject_id);
?>

<?php
  // validation
  $required_fields = array("menu_name", "subject_id", "position", "visible", "content");
  validate_presences($required_fields);

  $fields_with_max_length = array("menu_name" => 30);
  validate_max_lengths($fields_with_max_length);

  if (!empty($errors)) {
    $_SESSION["errors"] = $errors;
    redirect_to("new_page.php");
  }

  $query  = "INSERT INTO pages (";
	$query .= "  subject_id, menu_name, position, visible, content";
	$query .= ") VALUES (";
	$query .= "  {$subject_id}, '{$menu_name}', {$position}, {$visible}, '{$content}'";
	$query .= ")";
  $result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) >= 0 ) {
    // Success
    $_SESSION["message"] = "Page created.";
    redirect_to("manage_content.php");
	} else {
		// Failure
		$_SESSION["message"] = "Page creation failed";
    redirect_to("new_page.php");
	}
} else {
  // This is probably a GET request
  redirect_to("mange_content.php");
}
?>


<?php
  if (isset($connection)) {
    mysqli_close($connection);
  }
?>
