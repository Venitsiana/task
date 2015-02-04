<?php
function __autoload($class_name)
{
	include $class_name. '.php';
}

$connection = DBConnection::getDBConnection();

if(isset($_POST['comment'])){
	
	$statement1 = 'INSERT INTO comment( NAME, COMMENT)
					   VALUES (:NAME, :COMMENT)';
	
	$stmt1 = $connection->prepare($statement1);
	$stmt1->bindValue(":NAME", strip_tags($_POST["name"]), PDO::PARAM_STR);
	$stmt1->bindValue(":COMMENT", strip_tags($_POST["comment"]), PDO::PARAM_STR);
	$stmt1->execute();
	
	echo json_encode(true);
	
}
if(isset($_POST['task'])){

	$statement = "SELECT name, comment
				  FROM comment
				  WHERE 1=1
				  ORDER BY name"; 

	$stmt = $connection->prepare($statement);
	$stmt->execute();

	$i = 0;
	while($row = $stmt->fetch())
	{
		$i++;
		$result['name'.$i] = strip_tags($row['name']);
		$result['comment'.$i] = strip_tags($row['comment']);
	} 
		
	echo json_encode($result);
	 
} 

?>
