<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php global $layout_context; ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>
<?php $admin_set = find_all_admins();
?>

<div id="main">
  <div id="navigation"></div>
  <div id="page">
      <div><h2>Manage Admins</h2></div>
      <!-- loop through all admin usernames  -->
      <div id="username">
        <h3>Username</h3>
        <!-- function should display html of username and edit delete link dynamically  -->
      </div>
      <div id="actions">
        <h3>Actions</h3>
        <!-- pass the id of user to next page -->
        <a href="edit_admin.php">Edit</a>
        <a href="delete_admin.php">Delete</a>
      </div>
  </div>
  <a href="new_admin.php">Add new admin</a>
</div>

<?php include("../includes/layouts/footer.php") ?>
