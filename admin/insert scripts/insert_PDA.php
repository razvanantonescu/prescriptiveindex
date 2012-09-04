<?php require_once("../includes/init.php") ?>
<?php require_once("../includes/functions.php") ?>
<pre>
<?php


$studiu = array (
	'{"ro":"Profilul Distresului Afectiv (PDA) PLUS","en":"Profilul Distresului Afectiv (PDA) PLUS"}',
	'{"ro":"","en":""}'
);


$chestionare = array (
				array (
						'name' => '{"ro":"Informatii personale","en":"Informatii personale"}',
						'desc' => '{"ro":"","en":""}',
						'max_score' => 0,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				),

				array (
						'name' => '{"ro":"Profilul Distresului Afectiv ","en":"Profilul Distresului Afectiv "}',
						'desc' => '{"ro":"Mai jos va prezentam o lista de cuvinte care descriu emotiile pe care oamenii le au in diverse situatii. Cititi cu atentie fiecare cuvant, apoi marcati prin colorarea cerculetului corespunzator varianta care corespunde cel mai bine intrebarii: CUM V-ATI SIMTIT IN ULTIMELE  DOUA SAPTAMANI?","en":"Mai jos va prezentam o lista de cuvinte care descriu emotiile pe care oamenii le au in diverse situatii. Cititi cu atentie fiecare cuvant, apoi marcati prin colorarea cerculetului corespunzator varianta care corespunde cel mai bine intrebarii: CUM V-ATI SIMTIT IN ULTIMELE  DOUA SAPTAMANI?"}',
						'max_score' => 10,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				)
);


$intrebari = array (
					array (
						'Numele si prenumele' => 'text',
						'Varsta' => 'text'
					),
					array (
						'Optimist (a)' => 'choice',
						'Tensionat (a)' => 'choice',
						'Trist (a)' => 'choice',
						'Melancolic (a)' => 'choice',
						'Vesel (a)' => 'choice',
						'Nefolositor (Nefolositoare)' => 'choice',
						'Ingrijorat (a)' => 'choice',
						'Amarat (a)' => 'choice',
						'Infuriat (a)' => 'choice',
						'Fericit (a)' => 'choice',
						'Anxios (Anxioasa)' => 'choice',
						'Depresiv (a)' => 'choice',
						'Bucuros (bucuroasa)' => 'choice',
						'Preocupat (a)' => 'choice',
						'Voios (voioasa)' => 'choice',
						'Iritat' => 'choice',
						'Inspaimantat (a)' => 'choice',
						'Deprimat (a)' => 'choice',
						'Multumit (a)' => 'choice',
						'Necajit (a)' => 'choice',
						'Incordat (a)' => 'choice',
						'Morocanos (a)' => 'choice',
						'Satisfacut (a)' => 'choice',
						'Mahnit (a)' => 'choice',
						'Ingrozit (a)' => 'choice',
						'Nervos (Nervoasa)' => 'choice',
						'Incantat (a)' => 'choice',
						'Entuziast (a)' => 'choice',
						'Nemutumit (a)' => 'choice',
						'Indurerat (a)' => 'choice',
						'Alarmat (a)' => 'choice',
						'Bine dispus (a)' => 'choice',
						'Panicat (a)' => 'choice',
						'Suparat (a)' => 'choice',
						'Distrus (a)' => 'choice',
						'Jovial (a)' => 'choice',
						'Disperat (a)' => 'choice',
						'Dinamic (a)' => 'choice',
						'Nelinistit (a)' => 'choice',
						'Furios (a)' => 'choice',
						'Infricosat (a)' => 'choice',
						'Plin (a) de vitalitate' => 'choice',
						'Deznadajduit (a)' => 'choice'
					)
				);

$optiuni_raspuns = array(
	'{"ro":"deloc","en":"deloc"}' => 1,
	'{"ro":"foarte putin","en":"foarte putin"}' => 2,
	'{"ro":"mediu","en":"mediu"}' => 3,
	'{"ro":"mult","en":"mult"}' => 4,
	'{"ro":"foarte mult","en":"foarte mult"}' => 5
);


$query = "INSERT INTO studies (`name`, `desc`) VALUES ('".$studiu[0]."', '".$studiu[1]."')";
if($result = mysql_query($query, $dbconnect)) {
	$study_id = mysql_insert_id();
}


$index_chestionar = 0;
foreach($chestionare as $key => $chestionar) {
	$i = 0;
	$query = "INSERT INTO questionnaires SET ";

	foreach ($chestionar as $key => $data) {
			$i++;
			$query .= "`".$key."` = '". $data ."'";
			if($i == 5) break;
			$query .= ", ";
	}
	echo "salvez datele pentru chestionarul ". $index_chestionar .  "<br />";

	if($result = mysql_query($query, $dbconnect)) {
		$questionnaire_id = mysql_insert_id();

		$index_intrebare = 0;
		foreach($intrebari[$index_chestionar] as $data => $type) {
				$index_intrebare++;
				$foo = '{"ro":"'.$data.'","en":"'.$data.'"}';

				$query = "INSERT INTO questions (`questionnaire_id`,`name`,`type`)
							VALUES ('".$questionnaire_id."', '".$foo."', '".$type."')";
				if($result = mysql_query($query, $dbconnect)) {
						$id_intrebare = mysql_insert_id();
						
						if($type == 'choice') {
								foreach($optiuni_raspuns as $nume => $scor) {
			
										$query = "INSERT INTO choices (`question_id`, `name`, `score`)
													VALUES ('".$id_intrebare."', '".$nume."', '".$scor."')";
										$result = mysql_query($query, $dbconnect);
										confirm_query($result);
								}
						}

						echo "am salvat datele pentru intrebarea ". $index_intrebare .  "<br />";
				}
		}
		for ($index_r = 1; $index_r <= 5; $index_r++) {
			$query = "INSERT INTO ratings (`questionnaire_id`, `min_val`, `max_val`, `scoring`, `value`) 
						VALUES ('".$questionnaire_id."', 0, 0, 0, 0)";
			$result = mysql_query($query, $dbconnect);
			confirm_query($result);
		}
		
		$query = "INSERT INTO rel_questionnaire_study (`questionnaire_id`, `study_id`) VALUES ('".$questionnaire_id."', '".$study_id."')";
		$result = mysql_query($query, $dbconnect);
		confirm_query($result);
	}
	$index_chestionar++;
}


?>