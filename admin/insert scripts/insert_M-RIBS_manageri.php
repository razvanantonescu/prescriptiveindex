<?php require_once("../includes/init.php") ?>
<?php require_once("../includes/functions.php") ?>
<pre>
<?php

$studiu = array (
	'{"ro":"M-RIBS - manageri","en":"M-RIBS - manageri"}',
	'{"ro":"Atunci cand se confrunta cu situatii negative, unii angajati au tendinta sa gandeasca in termeni de trebuie cu necesitate/ neparat. In aceleasi situatii, alti oameni gandesc in termeni preferentiali si accepta situatia, chiar daca isi doresc foarte mult ca acele situatii sa nu se intample. De exemplu, unii manageri pot gandi: “Ar fi trebuit sa asculte cind vobesc” sau “As fi vrut sa ma asculte dar asta nu inseamna ca asa si trebuie sa se intample” sau pot avea ambele ganduri. Din perspectiva acestor posibilitati, estimati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut in situatia amintita.","en":"Atunci cand se confrunta cu situatii negative, unii angajati au tendinta sa gandeasca in termeni de trebuie cu necesitate/ neparat. In aceleasi situatii, alti oameni gandesc in termeni preferentiali si accepta situatia, chiar daca isi doresc foarte mult ca acele situatii sa nu se intample. De exemplu, unii manageri pot gandi: “Ar fi trebuit sa asculte cind vobesc” sau “As fi vrut sa ma asculte dar asta nu inseamna ca asa si trebuie sa se intample” sau pot avea ambele ganduri. Din perspectiva acestor posibilitati, estimati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut in situatia amintita."}'
);


$chestionare = array (
				array (
						'name' => '{"ro":"M-RIBS - sectiunea 1","en":"M-RIBS - section 1"}',
						'desc' => '{"ro":"Va rugam sa va ganditi la o situatie la serviciu in care performanta dvs. nu a fost atat de buna precum va asteptati sau in care aceasta nu a fost apreciata. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut.","en":"Va rugam sa va ganditi la o situatie la serviciu in care performanta dvs. nu a fost atat de buna precum va asteptati sau in care aceasta nu a fost apreciata. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut."}',
						'max_score' => 10,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				),

				array (
						'name' => '{"ro":"M-RIBS - sectiunea 2","en":"M-RIBS - section 2"}',
						'desc' => '{"ro":"Va rugam sa va ganditi la o situatie la serviciu in care performanta dvs. nu a fost atat de buna precum va asteptati sau in care aceasta nu a fost apreciata. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut.","en":"Va rugam sa va ganditi la o situatie la serviciu in care performanta dvs. nu a fost atat de buna precum va asteptati sau in care aceasta nu a fost apreciata. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut."}',
						'max_score' => 10,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				),

				array (
						'name' => '{"ro":"M-RIBS - sectiunea 3","en":"M-RIBS - section 3"}',
						'desc' => '{"ro":"Va rugam sa va ganditi la o situatie la serviciu in care v-ati simtit stresati. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut.","en":"Va rugam sa va ganditi la o situatie la serviciu in care v-ati simtit stresati. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut."}',
						'max_score' => 10,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				)
);


$intrebari = array (
					array (
						'Trebuie neaparat sa obtin performante ridicate si sa fiu apreciat in munca pe care o defasor.',
						'Atunci cand nu obtin performante ridicate si nu sunt apreciat, ma gandesc ca sunt incompetent sau fara valoare.',
						'Daca nu am rezultate ridicate si nu sunt apreciat la serviciu, inseamna ca sunt fara valoare ca om.',
						'Este ingrozitor cand nu obtin performante ridicate si nu sunt apreciat.',
						'Este insuportabil si nu pot tolera sa nu am rezultate ridicate si sa fiu apreciat in munca pe care o desfasor.',
						'Pot suporta atunci cand nu am rezultate ridicate si nu sunt apreciat in munca mea, chiar daca imi este dificil sa tolerez acest lucru.',
						'Imi doresc foarte mult sa am rezultate bune si sa fiu apreciat pentru munca mea, dar realizez si accept ca lucrurile nu trebuie sa fie intotdeauna asa cum vreau eu sa fie.',
						'Este neplacut si regretabil sa nu ai rezultate ridicate si sa nu fii apreciat pentru munca ta, dar nu este groaznic.',
						'Atunci cand nu obtin performante ridicate si nu sunt apreciat, ma pot accepta ca fiind valoros si competent in ciuda performantei mele.',
						'Imi doresc mult sa obtin performante ridicate si sa fiu printre cei mai buni in munca pe care o desfasor, dar asta nu inseamna ca trebuie cu necesitate sa fiu.'
					),
					array (
						'Trebuie neaparat sa detin controlul asupra ceea ce se intampla la serviciu.',
						'Imi doresc foarte mult sa detin controlul la serviciu, dar nu trebuie neparat sa se intample acest lucru.',
						'Este groaznic daca nu detin controlul total asupra situatiilor de la serviciu.',
						'Daca nu detin controlul total asupra ceea ce se intampla la serviciu, inseamna ca sunt incompetent si fara valoare.',
						'Este de nesuportat si nu pot tolera sa nu am control asupra ceea ce se petrece la serviciu.',
						'Pot tolera sa nu am control asupra ceea ce se petrece la serviciu, desi imi este greu sa tolerez acest lucru.',
						'Imi doresc foarte mult sa nu pierd controlul la serviciu, dar realizez si accept ca lucrurile nu trebuie sa fie intotdeauna asa cum doresc eu sa fie.',
						'Este neplacut si regretabil sa nu detin controlul total asupra ce se intampla la serviciu, dar nu este ingrozitor.',
						'Atunci cand nu detin controlul total asupra ce se intampla la serviciu, ma consider incompetent si lipsit de valoare.',
						'Atunci cand nu detin controlul total asupra ce se intampla la serviciu, ma pot accepta ca fiind competent si valoros in ciuda performantei mele.'
					),
					array (
						'Trebuie neparat sa ma simt confortabil emotional si sa nu fiu stresat la serviciu.',
						'Imi doresc foarte mult sa ma simt confortabil emotional si sa nu fiu stresat la serviciu, dar nu trebuie neparat sa se intample acest lucru.',
						'Este groaznic daca ma simt stresat la serviciu.',
						'Daca ma simt stresat la serviciu inseamna ca sunt lipsit de valoare ca om.',
						'Este intolerabil si nu pot suporta sa ma simt stresat la munca.',
						'Pot suporta sa ma simt stresat la serviciu, desi imi este greu sa tolerez acest lucru.',
						'Imi doresc foarte mult sa nu ma simt stresat la lerviciu, dar realizez ca lucrurile nu trebuie sa fie intotdeauna asa cum doresc eu sa fie.',
						'Este neplacut si regretabil sa ma simt stresat la serviciu, dar nu este groaznic.',
						'Atunci cand devin stresat la serviciu, ma gandesc ca sunt incompetent si fara valoare.',
						'Atunci cand devin stresat la serviciu, ma pot accepta ca fiind valoros si competent in ciuda disconfortului meu emotional.'
					)
				);


$optiuni_raspuns = array(
	'{"ro":"Acord puternic","en":"Acord puternic"}' => 1,
	'{"ro":"Intrucatva de acord","en":"Intrucatva de acord"}' => 2,
	'{"ro":"Dezacord partial","en":"Dezacord partial"}' => 3,
	'{"ro":"Dezacord puternic","en":"Dezacord puternic"}' => 4
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
		foreach($intrebari[$index_chestionar] as $intrebare => $data) {
				$index_intrebare++;
				$foo = '{"ro":"'.$data.'","en":"'.$data.'"}';
				$query = "INSERT INTO questions (`questionnaire_id`,`name`,`type`)
							VALUES ('".$questionnaire_id."', '".$foo."', 'choice')";
				if($result = mysql_query($query, $dbconnect)) {
						$id_intrebare = mysql_insert_id();
						
						foreach($optiuni_raspuns as $nume => $scor) {
	
								$query = "INSERT INTO choices (`question_id`, `name`, `score`)
											VALUES ('".$id_intrebare."', '".$nume."', '".$scor."')";
								$result = mysql_query($query, $dbconnect);
								confirm_query($result);
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