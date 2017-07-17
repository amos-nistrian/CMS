<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>

<?php global $layout_context; ?>
<?php $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>
<?php $admin_set = find_all_admins(); ?>


<div id="main">
  <div id="navigation"></div>
    &nbsp;
  <div id="page">
    <?php echo message(); ?>
    <?php $errors = errors(); ?>
    <?php echo form_errors($errors); ?>
    <h2>Create Admin</h2>
    <form action="create_admin.php" method="post">
      <p>Username:
        <input type="text" name="username" value="" />
      </p>
      <p>Password:
        <input type="password" name="password" value="" />
      </p>
        <button type="submit" name="submit">Create Admin</button>
    </form>
    <br />
    <a href="manage_admins.php">Cancel</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php") ?>
