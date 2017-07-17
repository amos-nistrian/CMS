<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php confirm_logged_in(); ?>


<?php
if (isset($_POST['submit'])) {

  // Process the form
  $username = mysql_prep($_POST["username"]);
  $password = password_hash($_POST["password"], PASSWORD_DEFAULT);

  //print_r($_POST);
  //print_r($subject_id);
?>

<?php
  // validation
  $required_fields = array("username", "password");
  validate_presences($required_fields);

  $fields_with_max_length = array("username" => 50, "password" => 50);
  validate_max_lengths($fields_with_max_length);

  if (!empty($errors)) {
    $_SESSION["errors"] = $errors;
    redirect_to("new_admin.php");
  }

  $query  = "INSERT INTO admins (";
	$query .= "  username, hashed_password";
	$query .= ") VALUES (";
	$query .= "  '{$username}', '{$password}'";
	$query .= ")";
  $result = mysqli_query($connection, $query);

	if ($result && mysqli_affected_rows($connection) >= 0 ) {
    // Success
    $_SESSION["message"] = "Admin created.";
    redirect_to("manage_admins.php");
	} else {
		// Failure
		$_SESSION["message"] = "Admin creation failed";
    redirect_to("new_admin.php");
	}
} else {
  // This is probably a GET request
  redirect_to("mange_admins.php");
}
?>


<?php
  if (isset($connection)) {
    mysqli_close($connection);
  }
?>
