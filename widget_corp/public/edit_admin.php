<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php require_once("../includes/validation_functions.php") ?>


<?php find_selected_admin(); ?>

<?php
  if (!$current_admin) {
    // admin ID was missing or invalid or
    // admin couldn't be found in database
    redirect_to("manage_admins.php");
  }
?>

<?php
if (isset($_POST['submit'])) {

  // validation
  $required_fields = array("username", "password");
  validate_presences($required_fields);

  $fields_with_max_length = array("username" => 50, "password" => 50);
  validate_max_lengths($fields_with_max_length);

  if (empty($errors)) {

    //$admin = find_admin_by_id($_POST["id"]);
    $id = $current_admin["id"];

    // Process the form
    $username = mysql_prep($_POST["username"]);
    $password = password_hash($_POST["password"], PASSWORD_DEFAULT);


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

<?php global $layout_context; ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>

<div id="main">
  <div id="navigation"></div>
    &nbsp;
  <div id="page">
    <?php
      if (!empty($message)) {
        echo "<div class = \"message\">" .htmlentities($message). "</div>";
      }
    ?>
    <?php echo form_errors($errors); ?>
    <h2>Edit Admin: <?php echo htmlentities($current_admin["username"]); ?></h2>
    <form action="edit_admin.php?id=<?php echo urlencode($current_admin['id']); ?>" method="post">
      <p>Username:
        <input type="text" name="username" value="<?php echo htmlentities($current_admin['username']); ?>" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
        <button type="submit" name="submit">Edit Admin</button>
    </form>
    <br />
    <a href="manage_admins.php">Cancel</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php") ?>
