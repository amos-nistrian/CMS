<script>
  function loadSubjects(subjects){
    var sel = document.getElementById("subject");
    for(var i = 0; i < subjects.length; i++){
      sel.options[sel.options.length] = new Option(subjects[i]['subjectTitle'], subjects[i]['id']);
    }
  }

  function loadPages(pages) {
    var sel = document.getElementById("position");
    //console.log(sel);
    //console.log(pages);
    //console.log(pages[0]["position"]);

    var pos = 1;
    for(var i = 0; i < pages.length; i++){
      if (pages[i]['subject_id'] == 1) {
        sel.options[sel.options.length] = new Option(pages[i]['position'], pages[i]['subject_id']);
        pos++;
      }
    }
    //console.log(possy);
    sel.options[sel.options.length] = new Option(pos, pos);
  }

  function updatePages(pages){
    var subject = document.getElementById("subject");
    var subject_id = subject.options[subject.selectedIndex].value;
    //console.log(pages);

    var sel = document.getElementById("position");
    sel.options.length = 0; //delete all options if any present

    var pos = 1;
    for(var i = 0; i < pages.length; i++){
      if (pages[i]['subject_id'] == subject_id) {
        sel.options[sel.options.length] = new Option(pages[i]['position'], pages[i]['subject_id']);
        pos++;
      }
    }
    //console.log(pos);
    sel.options[sel.options.length] = new Option(pos, pos);
  }
</script>
