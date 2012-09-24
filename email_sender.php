<?
  include_once 'mysql_conf.php';
  include_once 'PHPMailer_5.2.2-beta2/class.phpmailer.php';

  function email($to, $subject, $body){
    $mail = new PHPMailer();

    $mail->SMTPAuth = true;
    $mail->SMTPSecure = "ssl";
    $mail->Host = "smtp.gmail.com";
    $mail->Port = 465;
    $mail->Username = "invitation@prescriptiveindex.ro";
    $mail->Password = "U8GWm&hM";

    $mail->SetFrom("invitation@prescriptiveindex.ro", "Invitatie Studiu/Study Invitation"); 

    if(is_array($to)){
        foreach($to as $t){
            $mail->AddAddress($t);                   
        }
    }else{
        $mail->AddAddress($to);
    }

    $mail->Subject = $subject;
    $mail->Body = $body;

    $res = !$mail->Send();
    unset($mail);
    return $res;
  }

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
    
    $res = 2 + email($to, $subject, $message); 
    $query = "update mails set status = $res where id =".$row['id'];
    mysql_query($query);
  }
