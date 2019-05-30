<?php

//siame faile surasytas kodas suveike visiskai be priekaistu


include "simple_html_dom.php";

date_default_timezone_set('UTC');

$websiteUrl = "http://www.tolijauta.lt";

$html = file_get_html($websiteUrl);


//viso puslapio visas kodas issisaugojo faile
$html->save('result.txt');

/*plain text of all web
echo file_get_html($websiteUrl)->plaintext; */


$urls = array();

$name = "links";


/* all div with id
$ret = $html->find('div[id]');
echo implode($ret, ", ");
echo"<br>";*/

foreach($html->find('.works') as $work){
	
	
	foreach($work->find('a') as $a){
			
		
		
		/*if(isset($a->href)){ 
		$a->href = 'my link';
        echo 'href exist!  ' . $a->href . "<br>";}*/
		
		//graziai atspausdina href`us
		echo $a->attr['href'] . "<br>";
		
		//atspausdina tago pavadinima
		echo $a->tag . "<br>";
		
		//idedu i array	
		array_push($urls, $a->attr['href']);
						
	}
		
}

//print array
echo '<pre>';
print_r($urls);
echo '</pre>';
echo '<br>';

print_r($urls[0]);

//writting data to file
		$data = implode("|", $urls);
		$atidaryti=fopen("$name.txt","w");
		fwrite($atidaryti,$data);
		fclose($atidaryti);
		




//get file from website and save it with data
//$file = "kksd_file";

$data = file_get_contents("http://www.tolijauta.lt/big_data/diamonds.csv");

file_put_contents("diamonds" . ".csv", $data, FILE_APPEND | LOCK_EX);


//connecting to DB

define("DB_SERVER", "localhost");
define ("DB_USER", "");
define ("DB_PASS", "");
define ("DB_NAME", "");

//sukuriame prisijungimo objekta ir issaugom ji kaip kintamaji $db

$db = new mysqli(DB_SERVER, DB_USER, DB_PASS, DB_NAME); 

//for errors in connection:

if($db->connect_error){	echo "$db->connect_error";
						exit; 
						}
else {"<h6>Prisijungeme prie DB</h6>";}

//tikslinti faila
  $db1 = "LOAD DATA LOCAL 
    INFILE 'diamonds.csv'  
    INTO TABLE diamonds 
	
	COLUMNS TERMINATED BY ','
	
	LINES TERMINATED BY '\n'
	
	IGNORE 2 LINES";
	
	//kodas klaidoms su db
	if (!mysqli_query($db, $db1)) {
    printf("Errormessage: %s\n", mysqli_error($db));
}


?>
		
