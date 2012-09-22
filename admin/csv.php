<?
  header('Content-type: text/csv');
  header('Content-disposition: attachment;filename=results.csv');
  include_once '../mysql_conf.php';
  include_once '../includes/functions.php';
  $lang = set_language();

  if(isset($_GET["study_id"])){
    $study_id = $_GET["study_id"];

    $outstream = fopen("php://output", 'w');
    
    $query = "SELECT subj_id, question_id FROM results WHERE `study_id` = '".$study_id."'";
    if(isset($_GET["subj_id"])){
      $subject_id = $_GET["subj_id"];
      $query .= " AND `subj_id` = '$subject_id'";
    }
    $result = mysql_query($query);
    confirm_query($result);

    while ($row = mysql_fetch_array($result)) {
      $subject_ids[] = $row['subj_id'];
      $question_ids[] = $row['question_id'];
      $header_data['subj_id'] = 'Subject id';
      $header_data['subj_name'] = 'Subject name';
      $header_data[$row['question_id']] = get_question_name($row['question_id'], $lang);
    }
    fputcsv($outstream, $header_data);


    $subject_ids = array_unique($subject_ids);
    
    foreach ($subject_ids as $subject_id) {
      $query = "SELECT * FROM results WHERE `study_id` = '".$study_id."' AND `subj_id` = '".$subject_id."'
      ";
      $result = mysql_query($query);
      confirm_query($result);
      while ($row = mysql_fetch_assoc($result)) {
        $data['subj_id'] = $subject_id;
        $data['subj_name'] = get_subj_name($subject_id);
        $data[$row['question_id']] = $row['data'];
      }
      fputcsv($outstream, $data);
    }
    fclose($outstream);
  }
?>