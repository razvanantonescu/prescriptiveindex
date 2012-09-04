<?php require_once("../includes/init.php") ?>
<?php require_once("../includes/functions.php") ?>
<pre>
<?php

$studiu = array (
	'{"ro":"M-RIBS - angajati","en":"M-RIBS - angajati"}',
	'{"ro":"Atunci cand se confrunta cu situatii negative, unii angajati au tendinta sa gandeasca in termeni de trebuie cu necesitate/ neparat. In aceleasi situatii, alti oameni gandesc in termeni preferentiali si accepta situatia, chiar daca isi doresc foarte mult ca acele situatii sa nu se intample. De exemplu, unii angajati pot gandi: “Nu trebuia sa strige la mine” sau “Nu as fi vrut sa strige la mine dar uneori mi se intampla si lucruri rele” sau pot avea ambele ganduri. Din perspectiva acestor posibilitati, estimati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut in situatia amintita. ","en":"Atunci cand se confrunta cu situatii negative, unii angajati au tendinta sa gandeasca in termeni de trebuie cu necesitate/ neparat. In aceleasi situatii, alti oameni gandesc in termeni preferentiali si accepta situatia, chiar daca isi doresc foarte mult ca acele situatii sa nu se intample. De exemplu, unii angajati pot gandi: “Nu trebuia sa strige la mine” sau “Nu as fi vrut sa strige la mine dar uneori mi se intampla si lucruri rele” sau pot avea ambele ganduri. Din perspectiva acestor posibilitati, estimati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut in situatia amintita."}'
);


$chestionare = array (
				array (
						'name' => '{"ro":"M-RIBS angajati - sectiunea 1","en":"M-RIBS angajati - section 1"}',
						'desc' => '{"ro":"Va rugam sa va ganditi la o situatie la serviciu in care munca dvs. nu a fost apreciata corect, nu a fost recunoscuta sau rasplatita pe masura. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut. ","en":"Va rugam sa va ganditi la o situatie la serviciu in care munca dvs. nu a fost apreciata corect, nu a fost recunoscuta sau rasplatita pe masura. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut."}',
						'max_score' => 10,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				),

				array (
						'name' => '{"ro":"M-RIBS angajati - sectiunea 2","en":"M-RIBS angajati - section 2"}',
						'desc' => '{"ro":"Va rugam sa va ganditi la o situatie la serviciu cand ati avut rezultate slabe dvs. sau colegii/ echipa din care faceti parte. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut.","en":"Va rugam sa va ganditi la o situatie la serviciu cand ati avut rezultate slabe dvs. sau colegii/ echipa din care faceti parte. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut."}',
						'max_score' => 10,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				),

				array (
						'name' => '{"ro":"M-RIBS angajati - sectiunea 3","en":"M-RIBS angajati - section 3"}',
						'desc' => '{"ro":"Va rugam sa va ganditi la o situatie la serviciu in care v-ati simtit inconfortabil, stresati sau a trebui sa realizati activitati care nu va plac. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut.","en":"Va rugam sa va ganditi la o situatie la serviciu in care v-ati simtit inconfortabil, stresati sau a trebui sa realizati activitati care nu va plac. Incercati sa va amintiti gandurile pe care le-ati avut intr-o asemenea situatie si apreciati cat de mult reprezinta afirmatiile de mai jos gandurile pe care le-ati avut."}',
						'max_score' => 10,
						'display_type' => 'normal',
						'quest_type' => 'normal'
				)
);


$intrebari = array (
					array (
						'Trebuie neaparat sa fiu apreciat/a corect si recompensat pentru  eforturile mele in munca pe care o defasor. ',
						'Imi doresc foarte mult sa fiu apreciat/a pentru munca mea, dar realizez si accept ca lucrurile nu trebuie sa fie intotdeauna asa cum vreau eu sa fie. ',
						'Este ingrozitor cand nu sunt apreciat/a pentru eforturi si nu mi se recunosc meritele. ',
						'Daca nu nu sunt apreciat/a la serviciu si recompensat/a pe masura eforturilor, inseamna ca nu sunt bun de nimic.',
						'Este insuportabil si nu pot tolera sa nu fiu apreciat/a si tratat/a corect in munca pe care o desfasor.',
						'Pot suporta atunci cand nu sunt apreciat/a si recompensat/a pentru munca mea, chiar daca imi este dificil sa tolerez acest lucru. ',
						'Imi doresc mult sa fiu apreciat/a si recompensat/a pentru eforturile depuse in munca mea, dar asta nu inseamna ca trebuie cu necesitate sa fiu. ',
						'Este neplacut si regretabil sa nu fii apreciat/a pentru munca ta, dar nu este groaznic.',
						'Atunci cand ceilalti nu ma apreciaza si nu imi recunoasc meritele, ma gandesc ca sunt incompetenti sau nu sunt buni de nimic. ',
						'Atunci cand nu sunt apreciat si recompensat corespunzator pentru munca mea, ma pot accepta ca fiind valoros si competent in ciuda acestui lucru. '
					),
					array (
						'Trebuie neaparat sa am realizari in sfera profesionala si sa lucrez cu persoane competente, de la care sa pot invata, la serviciu. ',
						'Imi doresc foarte mult sa sa am realizari profesionale si sa lucrez cu persoane competente si motivate in echipa, dar asta nu inseamna ca trebuie neparat sa se intample acest lucru. ',
						'Este groaznic daca nu am realizari in sfera profesionala si nu am sansa sa lucrez cu persoane competente la serviciu. ',
						'Daca persoanele cu care lucrez la serviciu nu sunt pregatite foarte bine profesional, inseamna ca sunt incompetente si fara valoare. ',
						'Este de nesuportat si nu pot tolera daca nu am realizarile asteptate in sfera profesionala si sa lucrez cu persoane mai nemotivate sau nepregatite la serviciu. ',
						'Pot tolera chiar daca nu apar realizarile asteptate in sfera profesionala sau lucrez cu persoane mai putin motivate si competente decat mi-ar placea in echipa, desi imi este greu sa tolerez acest lucru.  ',
						'Imi doresc foarte mult sa sa am realizari in sfera profesionala si sa lucrez cu persoane competente si motivate in echipa, dar realizez si accept ca lucrurile nu trebuie sa fie intotdeauna asa cum doresc eu sa fie. ',
						'Este neplacut si regretabil sa nu am realizarile dorite in sfera profesionala si sa lucrez cu persoane mai putin competente si motivate decat mi-as dori in echipa, dar nu este ingrozitor.  ',
						'Atunci cand nu sa am realizari in sfera profesionala si  lucrez cu persoane incompetente in echipa, ma consider si eu incompetent si bun de nimic. ',
						'Atunci cand nu am realizari profesionale si sa lucrez cu persoane mai putin pregatite si motivate in echipa, ii pot accepta ca fiind competenti si valorosi ca oameni in ciuda acestui lucru. '
					),
					array (
						'Trebuie neparat sa ma simt confortabil si sa fac activitati de nivelul competentei mele la serviciu. ',
						'Imi doresc foarte mult sa ma simt confortabil si sa realizez activitatile de competenta mea la serviciu, dar nu trebuie neparat sa se intample acest lucru.',
						'Este groaznic daca ma simt inconfortabil, stresat sau realizez activitati care nu imi fac placere  la serviciu. ',
						'Daca atmosfera de la serviciu este una tensionata sau sarcinile mele nu sunt adaptate nivelului meu, asta ma face sa simt ca nu sunt bun de nimic.  ',
						'Este intolerabil si nu pot suporta atunci cand ma simt inconfortabil si stresat la munca sau cand am de realizat activitati neplacute. ',
						'Pot suporta sa ma simt inconfortabil/ stresat la serviciu sau sa realizez sarcini acre nu imi convin, desi imi este greu sa tolerez acest lucru. ',
						'Imi doresc foarte mult sa fiu intr-o atmosfera placuta, sa ma simt confortabil la serviciu si sa-mi placa ceea ce fac, dar realizez ca lucrurile nu trebuie sa fie intotdeauna asa cum doresc eu sa fie. ',
						'Este neplacut si regretabil sa ma simt tensionat si inconfortabil la serviciu, dar nu este groaznic. ',
						'Atunci cand devin stresat la serviciu sau primesc sarcini inadecvate, ma gandesc ca ceilalti sunt incompetenti si fara valoare. ',
						'Atunci cand devin stresat la serviciu si nesatisfacut de ceea ce fac, ma pot accepta ca fiind valoros si competent in ciuda disconfortului si insatisfactiei mele.  '
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