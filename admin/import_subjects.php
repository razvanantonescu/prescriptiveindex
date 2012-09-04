<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>
<?php
   if(isset($_POST["submit"])){
	 $list_id = $_POST["list_id"];
	 //echo "<pre>";print_r($_POST);echo "<pre>";
	 //echo "<br />";
	 //echo "<pre>";print_r($_FILES);echo "<pre>";//exit;
	 //echo "<br />";

	 if ( isset($_FILES["file"])) {
	    if ($_FILES["file"]["error"] > 0) {
		  echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
	    } else {
	 
		  //if file already exists
		  if (file_exists("../Temp/" . $_FILES["file"]["name"])) {
			echo $_FILES["file"]["name"] . " already exists. ";
		  } else {
			$storagename = $_FILES["file"]["name"];
			move_uploaded_file($_FILES["file"]["tmp_name"], "../Temp/" . $storagename);
			$storage_path = "../Temp/" . $storagename;
			
			$subject_count=0;

			if (($handle = fopen("../Temp/" . $_FILES["file"]["name"], "r")) !== FALSE) {
			   while (($data = fgetcsv($handle, 0, ";")) !== FALSE) {
				 //echo "<pre>";
				 //print_r($data);
				 //echo "<pre>";
				 
					  $subj_first_name = $data[0];
					  $subj_last_name = $data[1];
					  $subj_gender = $data[2];
					  $subj_email = $data[3];

					  if(!subject_exists($subj_email)) {

						$query = "INSERT INTO subjects (`first_name`, `last_name`, `gender`, `email`, `status`)
							    VALUES ('".$subj_first_name."', '".$subj_last_name."', '".$subj_gender."', '".$subj_email."', 'a') ";
						$result = mysql_query($query, $dbconnect);
						confirm_query($result);
						$subj_id = mysql_insert_id();
						$subject_count++;
						//echo "subj id este " . $subj_id . "<br />";
   
						// add the imported subject to the edited list 
						$query_rel = "INSERT INTO rel_subj_list (`list_id`, `subj_id`) VALUES ('".$list_id."', '".$subj_id."')";
						$result_rel = mysql_query($query_rel, $dbconnect);
						if (mysql_affected_rows() == 1) {
						   $list_name = get_list_name($list_id, $lang);
						   echo "Subject has been added to list {$list_name}.";
						}
					  } else {
						//$subj_id = get_subject_id($subj_email);
						continue;
					  }
			   }
			   fclose($handle);
			   unlink($storage_path);
			   $mesaj[] = $subject_count . " subjects were added to this list.";
		        $_SESSION["mesaj"] = $mesaj;
			   redirect("view_list.php?list_id=".$list_id);
			    
			}
		  }
	    }
	 } else {
	    echo "No file selected <br />";
	 }







   }
?>