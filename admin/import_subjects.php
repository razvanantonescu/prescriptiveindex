<?php require_once("../includes/init.php") ?>
<?php $lang = set_language() ?>
<?php
	if(isset($_POST["submit"])){

		if ( isset($_POST["list_id"])) {
		  $list_id = $_POST["list_id"];
		}
		
		if ( isset($_FILES["file"])) {
		  if ($_FILES["file"]["error"] > 0) {
			  //echo "Return Code: " . $_FILES["file"]["error"] . "<br />";
			  __('You have not selected a file!');
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
					  while (($data = fgetcsv($handle, 0, ",")) !== FALSE) {
			  
							  /* csv file format:
								  * nume
								  * prenume
								  * sex - (m/f)
								  * data nasterii - (yyyy-mm-dd)
								  * email
								  * status - (p/a); p = pending, a = approved
							  */
			  
							  $subj_first_name = $data[0];
							  $subj_last_name = $data[1];
							  $subj_gender = $data[2];
							  $subj_bdate = $data[3];
							  $subj_email = $data[4];
							  $subj_status = $data[5];
			  
							  if(!subject_exists($subj_email)) {
			  
								  $query = "INSERT INTO subjects (`first_name`, `last_name`, `gender`, `birth_date`, `email`, `status`)
											VALUES ('".$subj_first_name."', '".$subj_last_name."', '".$subj_gender."', '".$subj_bdate."', '".$subj_email."', '".$subj_status."') ";
								  $result = mysql_query($query, $dbconnect);
								  confirm_query($result);
								  $subj_id = mysql_insert_id();
								  $subject_count++;
								  
								  if(isset($list_id)) {
									  // add the imported subject to the edited list 
									  $query_rel = "INSERT INTO rel_subj_list (`list_id`, `subj_id`) VALUES ('".$list_id."', '".$subj_id."')";
									  $result_rel = mysql_query($query_rel, $dbconnect);
									  if (mysql_affected_rows() == 1) {
										  $list_name = get_list_name($list_id, $lang);
										  echo "Subject has been added to list {$list_name}.";
									  }
								  }
							  } else {
								  continue;
							  }
					  }
					  fclose($handle);
					  unlink($storage_path);
			  
					  if(isset($list_id)) {
						  $mesaj[] = $subject_count . " subjects were added to this list";
						  $_SESSION["mesaj"] = $mesaj;
						  redirect("view_list.php?list_id=".$list_id);
					  } else {
						  $mesaj[] = $subject_count . " subjects were added";
						  $_SESSION["mesaj"] = $mesaj;
						  redirect("manage_subjects.php");
					  }
				  }
			  }
		  } 
		} else {
			echo "No file selected <br />";
		}
   }
?>