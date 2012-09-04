<?php require_once("../includes/init.php") ?>
<?php require_once("../includes/functions.php") ?>
<pre>
<?php



$optiuni_raspuns = array(
	array (
	'Comunica exact obiectivele sarcinii, clarifica si se asigura ca acestea au fost clar intelese.' => 3,
	'Comunica doar cerintele sarcinii.' => 2,
	'Comunica lacunar cerintele sarcinii.' => 1
	),

	array (
	'Formuleaza intrebari care incurajeaza explorarea solutiilor pentru rezolvarea problemei (minim 2 solutii generate).' => 3,
	'Formuleaza intrebari dar se opreste la prima solutie identificata.' => 2,
	'Nu formuleaza intrebari care incurajeaza explorarea solutiilor pentru rezolvarea problemei.' => 1
	),

	array (
	'Face sumarizari periodice (cel putin doua).' => 3,
	'Face o singura sumarizare.' => 2,
	'Nu sumarizeaza.' => 1
	),

	array (
	'Ofera in repetate randuri feedback pozitiv specific (cel putin in doua randuri pe parcursul sarcinii).' => 3,
	'Ofera feedback pozitiv general sau cel mult un singur feedback pozitiv specific.' => 2,
	'Nu ofera nici un fel de feedback pozitiv.' => 1
	),

	array (
	'Ofera in repetate randuri feedback negativ specific constructiv (cel putin in doua randuri pe parcursul sarcinii).' => 3,
	'Nu ofera feedback negativ.' => 2,
	'Ofera feedback negativ general.' => 1
	),

	array (
	'Formuleaza intrebari pentru obtinerea unei perspective diferite asupra sarcinii sau problemei.' => 3,
	'Ofera o perspectiva diferita asupra sarcinii.' => 2,
	'Nu este interesat de generarea altei perspective asupra sarcinii.' => 1
	),

	array (
	'Foloseste cel putin doua analogii/scenarii/metafore pentru a facilita procesul de realizare a sarcinii.' => 3,
	'Foloseste o singura analogie/metafora/scenariu pentru a facilita procesul de realizare a sarcinii.' => 2,
	'Nu foloseste analogii/scenarii/metafore pentru a facilita procesul de realizare a sarcinii.' => 1
	),

	array (
	'Pune intrebari care vizeaza identificarea a cel putin urmatorilor doi pasi in rezolvarea sarcinii.' => 3,
	'Identifica cel putin urmatorii doi pasi in rezolvarea sarcinii, oferindu-i direct sau prin combinare cu ghidarea.' => 2,
	'Se opreste la cel mult identificarea primului pas in rezolvarea problemei (nu face aproape deloc planificare)' => 1
	),

	array (
	'Foloseste doar intrebari pentru anticiparea de catre subordonat a obstacolelor in implementarea solutiei alese (exclus avertizari directe!)' => 3,
	'Avertizeaza direct cu privire la posibile obstacole in implementarea solutiei sau combina avertizarile directe cu intrebari de anticipare a obstacolelor.' => 2,
	'Nu anticipeaza obstacole in implementarea solutiei.' => 1
	),

	array (
	'Pune intrebari care vizeaza auto-evaluarea subordonatului la nivel de performanta.' => 3,
	'Realizeaza direct evaluarea performantei subordonatului.' => 2,
	'Nu realizeaza nici un fel de evaluare a performantei subordonatului.' => 1
	),

	array (
	'Argumenteaza capacitatea de realizare a sarcinii pe baza progreselor anterioare, a experientei subordonatului sau a abilitatilor acestuia.' => 3,
	'Transmite mesaje pozitive care atesta capacitatea de finalizare a sarcinii fara insa a argumenta de ce subordonatul are capacitatea de a o finaliza.' => 2,
	'Transmite mesaje negative legate de finalizarea sarcinii.' => 1
	),

	array (
	'Pre-test' => 1,
	'Post-test' => 2
	)

);


$chestionar = array (
						'name' => '{"ro":"Grila de evaluare observationala a abilitatilor de coaching","en":"Grila de evaluare observationala a abilitatilor de coaching"}',
						'desc' => '{"ro":"descrere","en":"description"}',
						'max_score' => 0,
						'display_type' => 'normal',
						'quest_type' => 'normal'
);


$intrebari = array (
						'Numele persoanei evaluate' => 'text',
						'Numele evaluatorului' => 'text',
						'Comunicarea obiectivelor' => 'choice',
						'Intrebari de ghidare' => 'choice',
						'Sumarizare' => 'choice',
						'Feedback pozitiv' => 'choice',
						'Feedback negativ constructiv' => 'choice',
						'Perspective diferite' => 'choice',
						'Analogii, scenarii, metafore' => 'choice',
						'Ghidarea construirii planului de rezolvare a sarcinii (De ex. Ce te-ai gandit sa faci? Acopera tot ceea ce ti-ai propus tu? Mai sunt alte lucruri de luat in considerare in acest plan?)' => 'choice',
						'Obstacole viitoare' => 'choice',
						'Evaluarea subordonatului' => 'choice',
						'Expectante' => 'choice',
						'Incercuiti varianta potrivita' => 'choice'
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
		
		$index_tip_choice = 0;
		foreach($intrebari as $data => $type) {
				$foo = '{"ro":"'.$data.'","en":"'.$data.'"}';
		
				$query = "INSERT INTO questions (`questionnaire_id`,`name`,`type`)
							VALUES ('".$questionnaire_id."', '".$foo."', '".$type."')";
				if($result = mysql_query($query, $dbconnect)) {
						$id_intrebare = mysql_insert_id();
						
						if($type == 'choice') {
								foreach($optiuni_raspuns[$index_tip_choice] as $nume => $scor) {
										$bar = '{"ro":"'.$nume.'","en":"'.$nume.'"}';
										$query = "INSERT INTO choices (`question_id`, `name`, `score`) VALUES ('".$id_intrebare."', '".$bar."', '".$scor."')";
										$result = mysql_query($query, $dbconnect);
										confirm_query($result);
								}
								$index_tip_choice++;
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