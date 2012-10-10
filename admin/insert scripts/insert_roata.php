<?php require_once("../includes/init.php") ?>
<?php require_once("../includes/functions.php") ?>
<pre>
<?php

$chestionar = array (
						'name' => '{"ro":"Chestionar coaching subordonati","en":"Chestionar coaching subordonati"}',
						'desc' => '{"ro":"Cititi cu atentie afirmatiile de mai jos si apreciati cat de bine descrie fiecare dintre aceste afirmatii comportamentele superiorului dvs. fata de dvs.","en":"Cititi cu atentie afirmatiile de mai jos si apreciati cat de bine descrie fiecare dintre aceste afirmatii comportamentele superiorului dvs. fata de dvs."}',
						'max_score' => 0,
						'display_type' => 'normal',
						'quest_type' => 'normal'
);




$intrebari = array (
	"Depresie" => 'choice',
	"Tristete" => 'choice',
	"Anxietate" => 'choice',
	"Preocupare" => 'choice',
	"Rusine" => 'choice',
	"Dezamagire" => 'choice',
	"Vinovatie" => 'choice',
	"Remuscare" => 'choice',
	"Invidie" => 'choice',
	"Resentimente" => 'choice',
	"Gelozie" => 'choice',
	"Rivalitate" => 'choice',
	"Dezgust" => 'choice',
	"Aversiune" => 'choice',
	"Furie" => 'choice',
	"Enervare" => 'choice',
	"Implicare" => 'choice',
	"Interes" => 'choice',
	"Ras" => 'choice',
	"Amuzament" => 'choice',
	"Fericire" => 'choice',
	"Veselie" => 'choice',
	"Satisfactie" => 'choice',
	"Multumire" => 'choice',
	"Dragoste" => 'choice',
	"Tandrete" => 'choice',
	"Despovarare" => 'choice',
	"Usurare" => 'choice',
	"Mirare" => 'choice',
	"Surprindere" => 'choice',
	"Dor" => 'choice',
	"Nostalgie" => 'choice',
);


$optiuni_raspuns = array(
	'foarte usor' => 1,
	'putin' => 2,
	'moderat' => 3,
	'destul de mult' => 4,
	'extrem' => 5
);


	$i = 0;
	$query = "INSERT INTO questionnaires SET ";
	foreach ($chestionar as $key => $data) {
			$i++;
			$query .= "`".$key."` = '". $data ."'";
			if($i == count($chestionar)) break;
			$query .= ", ";
	}

	if($result = mysql_query($query, $dbconnect)) {
		$questionnaire_id = mysql_insert_id();
		
		foreach($intrebari as $data => $type) {
				$foo = '{"ro":"'.$data.'","en":"'.$data.'"}';
		
				$query = "INSERT INTO questions (`questionnaire_id`,`name`,`type`)
							VALUES ('".$questionnaire_id."', '".$foo."', '".$type."')";
				if($result = mysql_query($query, $dbconnect)) {
						$id_intrebare = mysql_insert_id();
						
						if($type == 'choice') {
								foreach($optiuni_raspuns as $nume => $scor) {
										$bar = '{"ro":"'.$nume.'","en":"'.$nume.'"}';
										$query = "INSERT INTO choices (`question_id`, `name`, `score`) VALUES ('".$id_intrebare."', '".$bar."', '".$scor."')";
										$result = mysql_query($query, $dbconnect);
										confirm_query($result);
								}
						}
				}
		}
		for ($index_r = 1; $index_r <= 5; $index_r++) {
			$query = "INSERT INTO ratings (`questionnaire_id`, `min_val`, `max_val`, `scoring`, `value`) 
						VALUES ('".$questionnaire_id."', 0, 0, 0, 0)";
			$result = mysql_query($query, $dbconnect);
			confirm_query($result);
		}
	}


?>