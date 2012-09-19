<?
  include_once 'mysql_conf.php';
  $query = "select * from mails where status = 0 limit 10;";
  $result = mysql_query($query);
  
  $data = array();
  $in = "-1";
  while ($row = mysql_fetch_assoc($result))
  {
    $data[] = $row;
    $in .= ','.$row['id'];
  }
  
  $query = "update mails set status = 1 where id in ($in)";
  mysql_query($query);
  
  foreach ($data as $row)
  {
    $query = "select name,`desc`,questionnaire_id from studies,rel_questionnaire_study where studies.study_id=".$row['study_id']." and rel_questionnaire_study.study_id = studies.study_id";
    $res2 = mysql_query($query);
    $row2 = mysql_fetch_assoc($res2);
    $sname = json_decode($row2['name']);
    $sdesc = json_decode($row2['desc']);

    $tags = array("[nume]", "[studiu]", "[descriere studiu]", "[url]");
    $values = array(
      $row['nume'],
      $sname->ro,
      $sdesc->ro,
      'http://www.prescriptiveindex.ro/fill.php?data='.base64_encode(implode(',', array($row['study_id'], $row['subj_id']))),
    );

    $from = "invitatie-studiu@prescriptiveindex.ro";
    $to = $row['email'];
    
    $subject = str_replace($tags, $values, $row['titlu']);
    $message = html_entity_decode(str_replace($tags, $values, $row['body']));
    
    $headers = 	'From: '.$from."\r\n" .
                'Reply-To: '.$from."\r\n";

    mail($to, $subject, $message, $headers); 
    $query = "update mails set status = 2 where id =".$row['id'];
    mysql_query($query);
  }
