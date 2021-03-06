<?php

require_once "../db/DB.php";
require_once "../models/Hall.php";

function getHalls($connection) {
	$sql = "SELECT * FROM `halls`";
	$query = $connection->prepare($sql);
	$query->execute([]);

  $halls = array();
	while ($row = $query->fetch()) {
    $hall = new Hall($row['id'], $row['number'], $row['floor'], $row['type']);
    array_push($halls, $hall);
	}
	return $halls;
}

try {
  $database = new DB();
  $connection = $database->getConnection();
}
catch (PDOException $e) {
	echo json_encode([
		'success' => false,
    'message' => "Неуспешно свързване с базата данни",
    'value' => null
  ]);
  exit();
}

$halls = getHalls($connection);

$response = json_encode([
  'success' => true,
  'message' => "Списък от всички зали",
  'value' => $halls
]);

echo $response;

?>