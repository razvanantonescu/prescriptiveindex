<?
/**
 * @file
 * This file containes the Marital Satisfaction Questionaire
 *
 * The questionaire is hardcodded since it had to be done quickly and has features that cannot be generated with the main tool
 */
?>
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
        <title>Satisfactie Maritala</title>
        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
        <link href="css/reset.css" rel="stylesheet" type="text/css" />
        <link href="css/uvt.css" rel="stylesheet" type="text/css" />
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
        <script src="js/script.js"></script>
        
        <link rel="stylesheet" type="text/css" href="http://www.prescriptiveindex.ro/slider/dhtmlxSlider/codebase/dhtmlxslider.css">
        <script src="http://www.prescriptiveindex.ro/slider/dhtmlxSlider/codebase/dhtmlxcommon.js"></script>
        <script src="http://www.prescriptiveindex.ro/slider/dhtmlxSlider/codebase/dhtmlxslider.js"></script>
        <script>window.dhx_globalImgPath="http://www.prescriptiveindex.ro/slider/dhtmlxSlider/codebase/imgs/";</script>

</head>
<body style='padding:20px'>
<div id="wrapper">
  <div id='main_content'>
    <p class="title">Prescriptive Index</p>
    <div id="list_details" style="margin-top:30px;">
      <h2><strong>Chestionar - Satisfactie Maritala</strong></h2>
      <p>Vi se cere sa participati la un studiu in cadrul caruia veti ramane anonim. Participarea dumneavoastra este voluntara. Acest studiu se adreseaza oamenilor casatoriti si va fi aplicat in cadrul a 45 de tari din intreaga lume.</p>
      <b>Nu uitati ca nu exista raspunsuri corecte sau gresite (ceea ce conteaza este opinia dumneavoastra).</b>
      <div class='questionnaire'>
<?
//! 2nd set of Questions & Answers.
$inf_pers = array(
  'Gen' => array(
    'Masculin',
    'Feminin',
  ),
  'Varsta' => 'text',
  'De cat timp sunteti casatorit/casatorita (ani):' => 'text',
  'Cati copii aveti:' => 'text',
  'Cateodata oamenii cresc deopotriva si copiii care nu sunt ai lor sau nu isi cresc propriii copii (ex. pentru ca sunt adulti). Cati copii cresteti in familia dumneavoastra in prezent?' => 'text',
  'Educatia' => array(
    'nicio educatie formala',
    'scoala primara',
    'scoala gimnaziala',
    'liceu sau colegiul tehnic',
    'licenta sau masterat'),
  'Situatia mea materiala este:' => array(
    'mult peste media din tara mea',
    'peste media din tara mea',
    'similara cu media din tara mea',
    'mai scazuta fata de media din tara mea',
    'mult mai scazuta fata de media din tara mea'
  ),
  'Care este apartenenta ta religioasa in prezent' => array(
    'Ortodox',
    'Protestant',
    'Catolic',
    'Evreu',
    'Musulman',
    'Budist',
    'Nici una',
    'Alta',
  ),
  'Alta apartenenta religioasa:' => 'text',
  'Esti un om religios?' => array(
    '1  - deloc religios','2','3','4 - moderat','5','6','7 - extrem de religios'
  ),
  'Cand voi imbatrani, voi putea trai din pensie si beneficiile sociale.' => array(
    '+3 Acord puternic',
    '+2 Acord',
    '+1 Acord usor',
    '0 Nici acord, nici dezacord',
    '-1 Dezacord usor',
    '-2 Dezacord',
    '-3 Dezacord puternic'
  ),
);

//! answers for the 3rd set of questions
$scala_1_a1 = array(
  '+2 Da', 
  '+1 Mai degraba da', 
  '0 Nici da nici nu', 
  '-1 Mai degraba nu', 
  '-2 Nu'
);
//! Answers & Questions for the 3rd set of questions
$scala_1 = array(
  'Va face placere compania sotiei/sotului?' => $scala_1_a1,
  'Sunteti fericit/fericita?' => $scala_1_a1,
  'Considerati ca sotul/sotia este o persoana atractiva?' => $scala_1_a1,
  'Va place sa faceti lucruri impreuna?' => $scala_1_a1,
  'Va place sa va imbratisati sotul/sotia?' => $scala_1_a1,
  'Va respectati sotul/ sotia?' => $scala_1_a1,
  'Sunteti mandru/ mandra de sotul/ sotia dumneavoastra?' => $scala_1_a1,
  'Are relatia dumneavoastra si o parte romantica?' => $scala_1_a1,
  'Va iubiti sotul/ sotia?' => $scala_1_a1,
);

//! Answers for "Satisfactie Maritala" section

$sm_a1 = array(
  '1 foarte insatisfacut',
  2,
  3,
  4,
  5,
  6,
  '7 foarte satisfacut'
);
//! Questions & Answers for 4th section: Satisfactie Maritala
$sm = array(
  '__INFO__' => 'Va rugam sa alegeti cifra din scala urmatoare pentru a indica cat de satisfacut/a sau nesatisfactu/a sunteti in casnicia curenta. Incercuiti cifra de la finalul fiecarei intrebari.',
  'Cat de satisfacut/satisfacuta sunteti de casatoria dumneavoastra?' => $sm_a1,
  'Cat de satisfacut/satisfacuta sunteti de partenerul/partenera dvs. in calitate de sot/sotie?' => $sm_a1,
  'Cat de satisfacut/satisfacuta sunteti de relatia pe care o aveti cu sotul/ sotia?' => $sm_a1,
);

//! Answers for Scala 2
$scala_2_a1 = array('Acord puternic', 'Acord moderat', 'Acord usor', 'Nici acord, nici dezacord', 'Dezacord usor', 'Dezacord moderat', 'Dezacord puternic');
//! Questions & Answerd for Scala 2
$scala_2 = array(
  '__INFO__' => 'In cadrul urmatoarelor opt intrebari, veti descrie atat situati generala din cultura dumneavoastra cat si cea din familie. Aceste doua dimensiuni nu trebuie sa fie in corcondanta, va rugam sa separati perspectiva proprie de cunostintele transmise din societate.',
  'In aceasta societate copiii se mandresc cu realizarile personale ale parintilor.' => $scala_2_a1,
  'In aceasta societate parintii se mandresc cu realizarile personale ale copiiilor.' => $scala_2_a1,
  'In aceasta societate, parintii in varsta in general locuiesc acasa cu copiii lor.' => $scala_2_a1,
  'In aceasta societate, copiii locuiesc in general cu parintii lor pana cand se casatoresc.' => $scala_2_a1,
  'Consider ca copiii trebuie sa se mandreasca cu realizarile personale ale parintilor.' => $scala_2_a1,
  'Consider ca parintii ar trebui sa fie mandri de realizarile personale ale copiiilor.' => $scala_2_a1,
  'Consider ca parintii in varsta ar trebui sa locuiasca acasa cu copiii lor.' => $scala_2_a1,
  'Consider ca copiii ar trebui sa locuiasca cu parintii pana cand se casatoresc.' => $scala_2_a1,
);

//! Answers for 6th section: Scala 3
$scala_3_a1 = array(
  'niciodata / foarte rar', 
  'rar', 
  'cateodata', 
  'des', 
  'foarte des'
);
//! Questions & Answers for 6th section: Scala 3
$scala_3 = array(
  '__INFO__' => 'Aceasta scala este construita pentru a aprecia modul in care dvs. si partenera/partenera faceti fata stresului. Va rugam sa indicate primul raspuns pe care il simtiti mai apropiat. Va rugam sa fiti foarte sincer. Completati fiecare item prin marcarea variantei care se poriveste cel mai bine situatiei dvs. personale. Nu exista raspunsuri gresite.',
  'Ii spun partenerului meu/partenerei mele ca ii apreciez suportul practic, sfaturile sau ajutorul.' => $scala_3_a1,
  'Ii spun deschis partenerului meu/partenerei mele ce simt si ca as aprecia suportul lui/ei emotional.' => $scala_3_a1,
  'Cand partenerul/ partenera mea este stresat/a este problema ei/lui.' => $scala_3_a1,
  'Cand sunt stresat/stresata, partenerul meu se asteapta sa ma descurc singur/a.' => $scala_3_a1,
  'Cand unul dintre noi este stresat, il consideram "stresul nostru".' => $scala_3_a1,
  'Cand sunt stresat/a, partenerul/partenera ma asculta si imi ofera oportunitatea sa comunic ceea ce ma deranjeaza cu adevarat.' => $scala_3_a1,
  'Cand sunt stresat/a, partenerul/ partenera meu/mea nu considera acesta un lucru serios.' => $scala_3_a1,
  'Partenerul/ partenera mea da dovada de empatie si intelegere cand am nevoie.' => $scala_3_a1,
  'Cand sunt stresat/a, partenerul/ partenera imi ofera support, dar o face fara sa vrea si lipsit de motivatie.' => $scala_3_a1,
  'Cand suntem stresati, ne ajutam reciproc sa observam problema dintr-o alta perspectiva.' => $scala_3_a1,
  'Cand suntem stresati, facem ceva impreuna, suntem afectuosi si facem fata impreuna stresului.' => $scala_3_a1,
);

//! 1st set of answers for 7th section: Scala 4
$scala_4_a1 = array(
  'Intotdeauna', 
  'De obicei', 
  'Cateodata', 
  'Rar', 
  'Niciodata'
);
//! 2nd set of answers for 7th section: Scala 4
$scala_4_a2 = array(
  'Foarte multa influenta', 
  'Multa influenta', 
  'Influenta moderata', 
  'Putina influenta', 
  '(Aproape) nu are influenta'
);
//! Questions & answers for 7th section: Scala 4
$scala_4 = array(
  'Oferi atentie parfumului, deodorantului sau afteshave-ului pe care le folosesc alte persoane?' => $scala_4_a1,
  'Cat de important este pentru tine ca partenerul tau/partenera ta sa miroasa placut?' => $scala_4_a2,
  'Simti mirosul de transpiratie al altor oameni?' => $scala_4_a1,
  'Cand o persoana are un miros al corpului placut, aceasta te face sa o gasesti ca fiind neatractiva? Mirosul corpului are........' => $scala_4_a2,
  'Esti in public si stai langa cineva care are un miros neplacut. Cauti un alt loc daca este posibil?'=> array(
    'Da', 'Probabil', 'Poate', 'Probabil nu', 'Nu'
  ),
  'Cat de importante sunt mirosurile pentru tine in viata de zi cu zi?' => array(
    'Foarte important', 'Destul de important', 'Putin important', 'Mai degraba neimportant decat important', '(Aproape) deloc important'
  ),
  'Oamenii difera in ceea ce priveste sensibilitatea la mirosuri. Un miros neplacut poate lasa o persoana neafectata, insa sa fie de nesuportat pentru o alta persoana. Cat sensibility la mirosuri considerati ca sunteti?' => array(
    'Mult mai sensibil decat ceilalti', 'Mai sensibil decat ceilalti', 'La fel de sensibil ca ceilalti', 'Mai putin sensibil decat ceilalti', 'Mult mai putin sensibil decat ceilalti'
  ),
);

/**
 * The 3 slides from the 8th section
 */
//$sliders = array(
//  'Imaginati-va ca sunteti persoana A (stanga). Persoana B se apropie de dvs. Daca este un strain, cat de mult se poate apropia de dvs. pentru a va simti confortabil in conversatie? Va rugam sa indicati pe scala de mai jos.' => 'slider',
//  'Imaginati-va ca sunteti persoana A (stanga). Persoana B se apropie de dvs. Daca este o cunostinta (nu foarte apropiata), cat de mult se poate apropia de dvs. pentru a va simti confortabil in conversatie? Va rugam sa indicati pe scala de mai jos.' => 'slider',
//  'Imaginati-va ca sunteti persoana A (stanga). Persoana B se apropie de dvs. Daca este o persoana apropiata (un prieten sau ruda), cat de mult se poate apropia de dvs. pentru a va simti confortabil in conversatie? Va rugam sa indicati pe scala de mai jos.' => 'slider',
//);

$scala_5_a1 = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10 );

$scala_5 = array(
  'Imaginati-va ca sunteti persoana A (stanga). Persoana B se apropie de dvs. Daca este un strain, cat de mult se poate apropia de dvs. pentru a va simti confortabil in conversatie? Va rugam sa indicati pe scala de mai jos.' => $scala_5_a1,
  'Imaginati-va ca sunteti persoana A (stanga). Persoana B se apropie de dvs. Daca este o cunostinta (nu foarte apropiata), cat de mult se poate apropia de dvs. pentru a va simti confortabil in conversatie? Va rugam sa indicati pe scala de mai jos.' => $scala_5_a1,
  'Imaginati-va ca sunteti persoana A (stanga). Persoana B se apropie de dvs. Daca este o persoana apropiata (un prieten sau ruda), cat de mult se poate apropia de dvs. pentru a va simti confortabil in conversatie? Va rugam sa indicati pe scala de mai jos.' => $scala_5_a1,
);

/**
 * The main questionaire array. It contains the 8 sections as members.
 * First secton is the email.
 * _INFO_ is used for extra info. See $scala_3
 */ 

$data = array(
  'Email' => array('Email' => 'text'),
  'Informatii personale' => $inf_pers,
  'Scala 1' => $scala_1,
  'SATISFACTIE MARITALA' => $sm,
  'Scala 2' => $scala_2,
  'Scala 3' => $scala_3,
  'Scala 4' => $scala_4,
  'Scala 5' => $scala_5
);
?>

<form name='marital_satisfaction' method='post' action='marital_satisfaction_submit.php'>
<?
/**
 * Storing the question index. It is incremented for each question
 */
  $i = 0;
  foreach ($data as $idata => $vdata)
  {
    echo "<h3 style='padding-top:20px'>$idata</h3><ul>";

        if ($vdata == $scala_5) {
               foreach ($vdata as $question => $answer) {
                        if ($question == '__INFO__') {
                                echo "<p><em>$answer</em></p>";
                                continue;
                        }
                        $i++;
                        echo "<li>";
                        echo "<p>$question</p>";
                        ?>
                        <table>
                                <tr>
                                        <td><img src='images/human_l.png'><h1>A</h1></td>
                                        <td width='630'><div style='margin-top:100px'>
                                        <div>
                                            <?php
                                                    foreach ($answer as $aid => $avalue) {
                                                            echo "<input type='radio' style='width: 13px; height:13px; margin:0 0 0 45px; ' name='a$i' value='$avalue'>";
                                                    }
                                            ?>
                                        </div>
                                        </div></td>
                                        <td><img src='images/human_r.png'><h1>B</h2></td>
                                </tr>
                        </table>
                        <?php
                        echo "</li>";
                } 

        } else {
                foreach ($vdata as $question => $answer) {
                        if ($question == '__INFO__') {
                                echo "<p><em>$answer</em></p>";
                                continue;
                        }
                        $i++;
                        echo "<li>";
                        echo "<p>$question</p>";
                        if (is_array($answer)) {
                                foreach ($answer as $aid => $avalue) {
                                        echo "<input type='radio' name='a$i' value='$avalue'> $avalue<br>";
                                }
                        } else if ($answer == 'text'){
                                echo "<input type='text' name='a$i'";
                        }
                        echo "</li>";
                }
        }
        echo "</ul>";
  }
?>
<input type='submit' value='trimite'>
</form>


      </div>
    </div>
  </div>
</div>
</body>
