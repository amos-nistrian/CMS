<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>

<?php
if (isset($_POST['submit'])) {

  // validation
  $required_fields = array("username", "password");
  validate_presences($required_fields);

  $fields_with_max_length = array("username" => 50, "password" => 50);
  validate_max_lengths($fields_with_max_length);

  if (empty($errors)) {

    $admin = find_admin_by_id($_POST["id"]);

    // Process the form
    $username = mysql_prep($_POST["username"]);
    $password = mysql_prep($_POST["password"]);
    $id = (int) $_POST["id"];

    // Perform Update
    $query  = "UPDATE admins SET ";
  	$query .= "username = '{$username}', ";
  	$query .= "hashed_password = '{$password}' ";
  	$query .= "WHERE id = {$id} ";
    $query .= "LIMIT 1";
    $result = mysqli_query($connection, $query);

  	if ($result && mysqli_affected_rows($connection) >= 0) {
      // Success
      $_SESSION["message"] = "Admin updated.";
  		redirect_to("manage_admins.php");
  	} else {
  		// Failure
  		$message = "Admin update failed.";
  	}
  }
} else {
  // This is probably a GET request
} // end: if (isset($_POST['submit']))
?>
