
<?php 
//connect to your database

    $driver = 'mysql';
    $host = 'localhost';
    $username = 'root';
    $password = 'root';
    $dbname = 'contrat_assurance2';

    $dsn = "$driver:host=$host;dbname=$dbname";
    $db = new PDO($dsn, $username, $password);
    //$dbLink = mysql_connect($host,$username,$password);
    $db -> exec('SET NAMES utf8');//accents can be returned and not 'null'


    $returnArray = array();
	 $q =  $_GET["musicianName"];
    $tableName="articlepublicitaire";
    $select = "descriptif, id_article";
    $headSelect = "descriptif";
    $category = "Musicians";
    $id = "id_article";


    $sql = "SELECT ".$select." from ".$tableName." ";
    $sql.=" where ".$headSelect." like \"".$q."%\"";
    $sql.=" order by ".$headSelect."";


    $requete = $db->query($sql); 
    $resultat = $requete->fetchAll(PDO::FETCH_ASSOC);

    foreach ($resultat as $index => $musician) {
     			
		$results[] = array('label' => $musician[$headSelect],
			'id' =>$musician[$id], 'category'=> $category);
     } 

   //petit bug si je veux faire
   //appraitre noResults dans autocomplete
   if(count($resultat) == 0){
   	echo (json_encode($resultat));
   }
   else{
   	echo (json_encode($results));
   }
     
    $dbLink= null;



?>