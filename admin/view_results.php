<?php require_once("../includes/header.php") ?>

<?php
if(isset($_GET["study_id"]) && isset($_GET["subj_id"])){
   $study_id = $_GET["study_id"];
   $subject_id = $_GET["subj_id"];

   $query = "SELECT * FROM results WHERE results.subj_id = ".$subject_id." AND results.study_id = ".$study_id;
   $result = mysql_query($query, $dbconnect);
   while($row = mysql_fetch_array($result)){
      echo "<pre>";
      print_r($row);
      echo "</pre>";
   }
   $query = "SELECT rel_list_study.list_id, rel_list_study.study_id, liste.name FROM rel_list_study, liste WHERE rel_list_study.study_id = {$study_id} AND liste.list_id = rel_list_study.list_id";

   $query = "SELECT 
   ";


} else {
   redirect("manage_subjects.php");
}
?>

<?php require_once("../includes/footer.php") ?>