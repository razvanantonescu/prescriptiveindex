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
						'Formuleaza intrebari prin care sa incurajeze explorarea mai multor solutii pentru rezolvarea unei probleme sau sarcini.' => 'choice',
						'Ofera subordonatilor resurse, informatii sau idei pentru a depasi problemele cu care se confrunta.' => 'choice',
						'Responsabilizeaza subordonatii cu privire la rezultatele si deciziile acestora.' => 'choice',
						'Ofera indrumare spre a gasi solutii la probleme, mai degraba decat sa indice direct solutiile.' => 'choice',
						'Ofera feedback pozitiv pentru elementele sarcinii bine indeplinite.' => 'choice',
						'Ofera feedback negativ constructiv pentru elementele sarcinii care nu ating standardele de performanta sau calitate.' => 'choice',
						'Solicita feedback din partea subordonatilor.' => 'choice',
						'Asista subordonatul in depasirea problemelor prin construirea unui plan de rezolvare a acestora.' => 'choice',
						'Ofera subordonatilor oportunitati formale sau informale de invatare, cum ar fi participarea lor la sedintele departamentale, delegarea unui mentor sau altele similare.' => 'choice',
						'Îsi comunica expectantele legate de performanta pe care o asteapta de la subordonati si de modul de finalizare a sarcinilor date.' => 'choice',
						'Stabileste pentru angajati obiective clare legate de sarcini si performanta.' => 'choice',
						'Priveste lucrurile si din perspectiva altor persoane, inclusiv cea a subordonatului.' => 'choice',
						'Încurajeaza subordonatii sa adopte perspective diferite asupra sarcinilor sau problemelor.' => 'choice',
						'Foloseste analogii, scenarii, metafore si exemple pentru a facilita gasirea solutiilor la probleme.' => 'choice',
						'Aduce persoane din exterior care sa faciliteze invatarea, atunci cand a epuizat toate celelalte solutii.' => 'choice'
				);


$optiuni_raspuns = array(
	'In foarte mica masura sau deloc' => 1,
	'In mica masura' => 2,
	'Moderat' => 3,
	'In mare masura' => 4,
	'Foarte mult' => 5
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