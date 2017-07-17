<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php global $layout_context; ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>

<?php confirm_logged_in(); ?>

<?php $admin_set = find_all_admins(); ?>


<div id="main">
  <div id="navigation">
    <br />
  <a href="admin.php">&laquo; Main menu</a><br />
  </div>
  <div id="page">
      <h2>Manage Admins</h2>
      <table>
        <tr>
          <th style ="text-align: left; width: 200px;">Username</th>
          <th colspan="2" style="text-align: left;">Actions</th>
        </tr>
        <!-- loop through all admin usernames  -->
        <?php echo display_admins($admin_set); ?>
      </table>
      <br />
      <a href="new_admin.php">Add new admin</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php") ?>
