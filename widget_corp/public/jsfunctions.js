<script>
  // loads the subject select element with all the subjects when page first loads
  // subjects is an associative array containg all the subjects in the DB
  function loadSubjects(subjects){
    var sel = document.getElementById("subject");
    // create a select option for each subject
    for(var i = 0; i < subjects.length; i++){
      sel.options[sel.options.length] = new Option(subjects[i]['subjectTitle'], subjects[i]['id']);
    }
  }

  // set the position for the default selected subject when the page first loads
  // pages in an associative array containing all the pages in the DB
  function loadPages(pages) {

    // get the id number of the first item in the subject select element
    var subject = document.getElementById("subject");
    var subject_id = subject.options[subject.selectedIndex].value;

    var sel = document.getElementById("position");

    var pos = 1;
    for(var i = 0; i < pages.length; i++){

      // if the page belongs to the subject_id of the default subject in the select element
      if (pages[i]['subject_id'] == subject_id) {
        // add a new option to the position select element, set the text for that value to pos
        sel.options[sel.options.length] = new Option(pos, pages[i]['subject_id']);
        pos++;
      }
    }
    // set one more option for the new page to be added
    sel.options[sel.options.length] = new Option(pos, pos);
  }

  // updates the position value in new_page.php for when you select a different subject after the page has been loaded once
  function updatePages(pages){
    var subject = document.getElementById("subject");

    // get the id number of the selected subject
    var subject_id = subject.options[subject.selectedIndex].value;
    console.log(subject_id);

    var sel = document.getElementById("position");
    sel.options.length = 0; //clear out any position options that may be present

    var pos = 1;
    for(var i = 0; i < pages.length; i++){

      // if the page belongs to the subject increment position
      if (pages[i]['subject_id'] == subject_id) {
        sel.options[sel.options.length] = new Option(pages[i]['position'], pages[i]['subject_id']);
        pos++;
      }
    }
    //console.log(pos);
    // set one more option for the new page to be added
    sel.options[sel.options.length] = new Option(pos, pos);
  }
</script>
