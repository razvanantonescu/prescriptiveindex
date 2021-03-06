<?php require_once("../includes/header.php") ?>

<?php
   if(isset($_POST["filter"])) {
      $filter = $_POST["filter"];
	 //echo "filter: ".$filter."<br />";
   }

   if(isset($_POST["gender"])) {
      $value = $_POST["gender"];
	 //echo "value: ".$value."<br />";
   }

   if(isset($_POST["tested"])) {
      $value = $_POST["tested"];
	 //echo "value: ".$value."<br />";
   }

   if(!empty($filter) && isset($value)){
	 $filtru = $filter." = '".$value."'";
	 //echo $filtru; exit;
   } else {
	 $filtru = 1;
   }

?>

   <h1 class="subjects"><?php __("Subjects Management") ?></h1>
   
   <div id="list_details">
   <?php output_message() ?>
   
   <div class="toolbar">
		<form id="subject_filter" class="subject_filter" method="post" action="manage_subjects.php" >
	
			<select name="filter" id="filter" class="filter" name="filter">
				<option value="gender" <?php //if(isset($filter) && $filter == "gender"){echo "selected=\"selected\"";}?> ><?php __("Gender")?></option>
				<option value="tested" <?php //if(isset($filter) && $filter == "tested"){echo "selected=\"selected\"";}?> ><?php __("Tested") ?></option>
				<!--<option value="status"><?php __("Status") ?></option>-->
				<option value="all"><?php __("Show all") ?></option>
			 
			</select> 
	
			<select class="values selected" id="gender" name="gender">
				<option value="m" <?php //if(isset($value) && $value == "m") {echo "selected=\"selected\"";}?> >masculin</option>
				<option value="f" <?php //if(isset($value) && $value == "f") {echo "selected=\"selected\"";}?> >feminin</option>
			</select>
	
			<select class="values" id="tested" name="tested" disabled="disabled" style="display:none">
				<option value="1" <?php //if(isset($value) && $value == "1") {echo "selected=\"selected\"";}?> >yes</option>
				<option value="0" <?php //if(isset($value) && $value == "0") {echo "selected=\"selected\"";}?> >no</option>
			</select>
	
			<!--<select class="values" id="status" name="status" disabled="disabled" style="display:none">
				<option value="0">pending</option>
				<option value="1">active</option>
			</select>-->
	
			<input name="submit" type="submit" value="<?php __("Filter subjects") ?> &raquo;" class="buton"/>

		</form>
   </div>

      <ul>
         <li class="head">
            <span class="first_name"><?php __("First Name") ?></span>
            <span class="last_name"><?php __("Last Name") ?></span>
            <span class="gender"><?php __("Gender") ?></span>
            <span class="tested"><?php __("Tested") ?></span>
            <span class="email"><?php __("Email") ?></span>
         </li>

      <?php
      
         $all_subjects = filter_active_subjects ($filtru);

         while ($row = mysql_fetch_array($all_subjects)) {
            $subj_id = $row["subj_id"];
            $subj_first_name = $row["first_name"];
            $subj_last_name = $row["last_name"];
            $subj_gender = $row["gender"];
            $subj_status = $row["tested"];
            $subj_email = $row["email"];
         ?>
            <li>
               <span class="first_name"><?php echo $subj_first_name ?></span>
               <span class="last_name"><?php echo $subj_last_name ?></span>
               <span class="gender"><?php echo $subj_gender ?></span>
               <span class="tested"><?php echo $subj_status ?></span>
               <span class="email"><?php echo $subj_email ?></span>
               <span class="view"><a href="view_subject.php?subj_id=<?php echo $subj_id ?>"><?php __("View") ?></a></span>
               <span class="edit"><a href="edit_subject.php?subj_id=<?php echo $subj_id ?>"><?php __("Edit") ?></a></span>
            </li>
         <?php 
         }
      ?>
      </ul>
	 
	 <h2>Pending subjects</h2>
	 <ul>
	    <li class="head">
		  <span class="first_name"><?php __("First Name") ?></span>
		  <span class="last_name"><?php __("Last Name") ?></span>
		  <span class="email"><?php __("Email") ?></span>
	    </li>
      <?php
      
         $pending_subjects = get_pending_subjects ();

         while ($row = mysql_fetch_array($pending_subjects)) {
            $subj_id = $row["subj_id"];
            $subj_first_name = $row["first_name"];
            $subj_last_name = $row["last_name"];
            $subj_email = $row["email"];
         ?>
            <li>
               <span class="first_name"><?php echo $subj_first_name ?></span>
               <span class="last_name"><?php echo $subj_last_name ?></span>
               <span class="email"><?php echo $subj_email ?></span>
               <span class="view"><a href="view_subject.php?subj_id=<?php echo $subj_id ?>"><?php __("View") ?></a></span>
               <span class="edit"><a href="edit_subject.php?subj_id=<?php echo $subj_id ?>"><?php __("Edit") ?></a></span>
            </li>
         <?php 
         }
      ?>
	 </ul>
	 

      <p class="clear"><a href="edit_subject.php"><?php __("Add subject") ?></a></p>

      <form id="import_subjects" action="import_subjects.php" method="post" enctype="multipart/form-data">
         <label for="file"><?php __('Import subjects from csv file') ?></label>
         <input type="file" name="file" id="file" />
         <input type="submit" name="submit" value="<?php __("Import subjects") ?>" onclick="submit_form(this); return false;" />
      </form>

<script>
	function submit_form(element) {
		var elem = $(element);
		var form = elem.parent('form');
		var fileName = $("#file").val();
		
		if(fileName == '') {
			alert('Nu ati selectat nici un fisier!');
		} else {
			form.submit();
		}
	};
</script>

   </div>
  
<?php require_once("../includes/footer.php") ?>