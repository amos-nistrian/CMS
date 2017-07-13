<?php
  function redirect_to($new_location) {
    header("Location: " .$new_location);
    exit;
  }

  function mysql_prep($string) {
    global $connection;

    $escaped_string = mysqli_real_escape_string($connection, $string);
    return $escaped_string;
  }

// Test if there was a query error
  function confirm_query($result_set) {
    if (!$result_set) {
      die("Database query failed.");
    }
  }

  function form_errors($errors=array()) {
    $output = "";
    if (!empty($errors)) {
      $output .= "<div class=\"error\">";
      $output .= "Please fix the following errors:";
      $output .= "<ul>";
      foreach ($errors as $key => $error) {
        $output .= "<li>";
        $output .= htmlentities($error);
        $output .= "</li>";
      }
      $output .= "</ul>";
      $output .= "</div>";
    }
    return $output;
  }

  function find_all_subjects($public=true) {
    global $connection;

    $query  = "SELECT * ";
    $query .= "FROM subjects ";
    if ($public) {
      $query .= "WHERE visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
    $subject_set = mysqli_query($connection, $query);
    confirm_query($subject_set);
    return $subject_set;
  }

  function find_all_pages() {
    global $connection;

    $query  = "SELECT * ";
    $query .= "FROM pages ";
    //$query .= "WHERE visible = 1 ";
    $query .= "ORDER BY position ASC";
    $page_set = mysqli_query($connection, $query);
    confirm_query($page_set);
    return $page_set;
  }

  function find_all_admins() {
    global $connection;

    $query  = "SELECT * ";
    $query .= "FROM admins ";
    $query .= "ORDER BY username ASC";
    $admin_set = mysqli_query($connection, $query);
    confirm_query($admin_set);
    return $admin_set;
  }

  function display_admins($admin_set) {
    $output = null;
    while ($admin = mysqli_fetch_assoc($admin_set)) {

      //$break = "<br />";
      //printf("name is %s %s", $admin["username"], $break);

      $output .= "<tr>";
      $output .= "<td>";
      $output .= htmlentities($admin["username"]);
      $output .= "</td>";

      $output .= "<td>";
      $output .= "<a href=\"edit_admin.php?id=";
      $output .= urlencode($admin["id"]);
      $output .= "\">";
      $output .= "Edit";
      $output .= "</a>";
      $output .= "</td>";

      $output .= "<td>";
      $output .= "<a href=\"delete_admin.php?id=";
      $output .= urlencode($admin["id"]);
      $output .= "\"";
      $output .= " onclick=\"return confirm('Are you sure?');";
      $output .= "\">";
      $output .= "Delete";
      $output .= "</a>";
      $output .= "</td>";
      $output .= "</tr>";
    }
    mysqli_free_result($admin_set);
    return $output;
  }

  function find_pages_for_subject($subject_id, $public=true) {
    global $connection;

    $safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

    $query  = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE subject_id = {$safe_subject_id} ";
    if ($public) {
      $query .= "AND visible = 1 ";
    }
    $query .= "ORDER BY position ASC";
    $page_set = mysqli_query($connection, $query);
    confirm_query($page_set);
    return $page_set;
  }

  function find_subject_by_id($subject_id, $public=true) {
		global $connection;

		$safe_subject_id = mysqli_real_escape_string($connection, $subject_id);

		$query  = "SELECT * ";
		$query .= "FROM subjects ";
		$query .= "WHERE id = {$safe_subject_id} ";
    if ($public) {
      $query .= "AND visible = 1 ";
    }
		$query .= "LIMIT 1";
		$subject_set = mysqli_query($connection, $query);
		confirm_query($subject_set);
		if($subject = mysqli_fetch_assoc($subject_set)) {
			return $subject;
		} else {
			return null;
		}
	}

  function find_page_by_id($page_id, $public=true) {
    global $connection;

    $safe_page_id = mysqli_real_escape_string($connection, $page_id);

    $query  = "SELECT * ";
    $query .= "FROM pages ";
    $query .= "WHERE id = {$safe_page_id} ";
    if ($public) {
      $query .= "AND visible = 1 ";
    }
    $query .= "LIMIT 1";
    $page_set = mysqli_query($connection, $query);
    confirm_query($page_set);
    if($page = mysqli_fetch_assoc($page_set)) {
      return $page;
    } else {
      return null;
    }

  }

  function find_default_page_for_subject($subject_id) {
    $page_set = find_pages_for_subject($subject_id);
    if($first_page = mysqli_fetch_assoc($page_set)) {
      return $first_page;
    } else {
      return null;
    }
  }

  function find_selected_page($public=false) {
    global $current_subject;
    global $current_page;

    if (isset($_GET["subject"])) {
      $current_subject = find_subject_by_id($_GET["subject"], $public);
      if ($current_subject) {
        if ($public) {
          $current_page = find_default_page_for_subject($current_subject["id"]);
        } else {
          $current_page = null;
        }
      }
    } elseif (isset($_GET["page"])) {
      $current_subject = null;
      $current_page = find_page_by_id($_GET["page"], $public);
    } else {
      $current_page = null;
      $current_subject = null;
    }
  }

  // navigation take 2 arguments
  // - the current subject array or null
  // - the current page array or null
  function navigation($subject_array, $page_array) {
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects(false);
    while($subject = mysqli_fetch_assoc($subject_set)) {
      $output .=  "<li";
      if ($subject_array && $subject["id"] == $subject_array["id"]) {
        $output .= " class=\"selected\"";
      }
      $output .= ">";
      $output .= "<a href=\"manage_content.php?subject=";
      $output .= urlencode($subject["id"]);
      $output .= "\">";
      $output .= htmlentities($subject["menu_name"]);
      $output .= "</a>";

      $page_set = find_pages_for_subject($subject["id"], false);
      $output .= "<ul class=\"pages\">";
      while($page = mysqli_fetch_assoc($page_set)) {
        $output .= "<li";
        if ($page_array && $page["id"] == $page_array["id"]) {
          $output .= " class=\"selected\"";
        }
        $output .= ">";
        $output .= "<a href=\"manage_content.php?page=";
        $output .= urlencode($page["id"]);
        $output .= "\">";
        $output .=  htmlentities($page["menu_name"]);
        $output .= "</a></li>";
      }
      mysqli_free_result($page_set);
      $output .= "</ul></li>";
    }
    mysqli_free_result($subject_set);
    $output .= "</ul>";
    return $output;
  }

  function public_navigation($subject_array, $page_array) {
    $output = "<ul class=\"subjects\">";
    $subject_set = find_all_subjects();
    while($subject = mysqli_fetch_assoc($subject_set)) {
      $output .=  "<li";
      if ($subject_array && $subject["id"] == $subject_array["id"]) {
        $output .= " class=\"selected\"";
      }
      $output .= ">";
      $output .= "<a href=\"index.php?subject=";
      $output .= urlencode($subject["id"]);
      $output .= "\">";
      $output .= htmlentities($subject["menu_name"]);
      $output .= "</a>";

      if ($subject_array["id"] == $subject["id"] || $page_array["subject_id"] == $subject["id"]) {
        $page_set = find_pages_for_subject($subject["id"]);
        $output .= "<ul class=\"pages\">";
        while($page = mysqli_fetch_assoc($page_set)) {
          $output .= "<li";
          if ($page_array && $page["id"] == $page_array["id"]) {
            $output .= " class=\"selected\"";
          }
          $output .= ">";
          $output .= "<a href=\"index.php?page=";
          $output .= urlencode($page["id"]);
          $output .= "\">";
          $output .=  htmlentities($page["menu_name"]);
          $output .= "</a></li>";
        }
        $output .= "</ul>";
        mysqli_free_result($page_set);
      }

      $output .= "</li>"; // end of subject li
    }
    mysqli_free_result($subject_set);
    $output .= "</ul>";
    return $output;
  }

  function turn_subject_set_to_assocative_array($subject_set) {
    while($row = mysqli_fetch_assoc($subject_set)){
      $associativeArray[] = array("id" => $row['id'], "subjectTitle" => $row['menu_name']);
    }
    return $associativeArray;
  }

  function turn_page_set_to_assocative_array($page_set) {
    while($row = mysqli_fetch_assoc($page_set)){
      $associativeArray[] = array('subject_id' => $row['subject_id'],  "position" => $row['position']);
      //$associativeArray[] = array("subject_id" => $row["subject_id"], "pageTitle" => $row['menu_name']);
    }
    return $associativeArray;
  }

  // navigation take 1 arguments
  // - the current subject id
  function display_pages($subject_id) {
    $output = null;
    $output .= "<ul class=\"pages\">";
    $page_set = find_pages_for_subject($subject_id, false);
    while ($page = mysqli_fetch_assoc($page_set)) {
      $output .= "<li>";
      $output .= "<a href=\"manage_content.php?page=";
      $output .= urlencode($page["id"]);
      $output .= "\">";
      $output .=  htmlentities($page["menu_name"]);
      $output .= "</a></li>";
    }
    mysqli_free_result($page_set);
    $output .= "</ul></li>";
    return $output;
  }
?>
