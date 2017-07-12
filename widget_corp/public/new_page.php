<?php require_once("../includes/session.php") ?>
<?php require_once("../includes/db_connection.php") ?>
<?php require_once("../includes/functions.php") ?>
<?php global $layout_context; ?>
<?php  $layout_context = "admin"; ?>
<?php include("../includes/layouts/header.php") ?>
<?php include("jsfunctions.js") ?>


<?php find_selected_page(); ?>

<div id="main">
  <div id="navigation">
    <?php echo navigation($current_subject, $current_page); ?>
  </div>
  <div id="page">
    <?php echo message(); ?>
    <?php $errors = errors(); ?>
    <?php echo form_errors($errors); ?>
    <h2>Create Page</h2>

  		<form action="create_page.php" method="post">
  		  <p>Menu name:
  		    <input type="text" name="menu_name" value="" />
  		  </p>
        <p>Subject:
          <?php
            $subject_set = find_all_subjects(false);
            $page_set = find_all_pages();

            //takes the $subject_set and turns each row into an associative array ex subjects[i] = array("id" => $row["id"], "subjectName" => $row["menu_name"])
            $subjects = turn_subject_set_to_assocative_array($subject_set);

            //takes the $page_set and turns each row into an associative array ex pages[i] = array("subjectId" => $row["subject_id"], "pageName" => $row["menu_name"])
            $pages = turn_page_set_to_assocative_array($page_set);
          ?>
          <select name="subject_id" id="subject" onchange="updatePages(pages)">
            <script>
              // turn these into json so we can use js
              var subjects = <?php echo json_encode($subjects); ?>;
              loadSubjects(subjects);
            </script>
          </select>
        </p>
        <p>Position:
          <select name="position" id="position">
            <script>
              var pages = <?php echo json_encode($pages); ?>;
              loadPages(pages);
            </script>
          </select>
        </p>
  		  <p>Visible:
  		    <input type="radio" name="visible" value="0" /> No
  		    &nbsp;
  		    <input type="radio" name="visible" value="1" /> Yes
  		  </p>
        Content:<br />
        <textarea class="view-content-editable" rows="20" cols="80" type="text" name="content"><?php echo htmlentities($current_page["content"]); ?></textarea>
        <br />
  		  <input type="submit" name="submit" value="Create Page" />
  		</form>
  		<br />
      <a href="manage_content.php">Cancel</a>
  </div>
</div>
<?php include("../includes/layouts/footer.php") ?>
