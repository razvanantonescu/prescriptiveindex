<?
  header('Content-type: text/csv');
  header('Content-disposition: attachment;filename=results.csv');
  include_once '../mysql_conf.php';
  include_once '../includes/functions.php';


  if(isset($_GET["study_id"])){
    $study_id = $_GET["study_id"];

    $outstream = fopen("php://output", 'w');
    $data = array(
              'subj_id'				=> 'subj_id',
              'response_id' 		=> 'response_id',
              'study_id'		   => 'study_id',
              'questionnaire_id' => 'questionnaire_id',
              'question_id' 		=> 'question_id',
              'question_name' 	=> 'question_name',
              'question_type'		=> 'question_type',
              'choice_id' 			=> 'choice_id',
              'data' 				=> 'data',
            );
    fputcsv($outstream, $data);

    if(isset($_GET["subj_id"])){
      $subject_id = $_GET["subj_id"];
      $query = "SELECT * FROM results WHERE subj_id = ".$subject_id." AND study_id = ".$study_id;
    } else {
      $query = "SELECT * FROM results WHERE study_id = ".$study_id." ORDER BY subj_id ASC, question_id ASC";
    }

    $result = mysql_query($query);


    while ($row = mysql_fetch_array($result)) {
        $data = array();
        //
        $data['subj_id']          = $row['subj_id'];
        $data['response_id']      = $row['response_id'];
        $data['study_id']         = $row['study_id'];
        $data['questionnaire_id'] = $row['questionnaire_id'];
        $data['question_id'] 	   = $row['question_id'];
        $data['question_name'] 	= get_question_name($row['question_id'], 'ro');
        $data['question_type']    = get_question_type($row['question_id']);
        $data['choice_id']        = $row['choice_id'];
        $data['data'] 			   = $row['data'];
        fputcsv($outstream, $data);
    }
    fclose($outstream);

  }
  
?>