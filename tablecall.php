<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52", array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
} catch (PDOException $e) {
	echo $e->getMessage();
}

$stmt = $pdo->query("SELECT TOP 300 * FROM PoliTracker..Political_Track ORDER BY ID DESC");
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

//$row = filter_var_array($row);
echo json_encode($row, JSON_FORCE_OBJECT);
//var_dump($row);
?>
