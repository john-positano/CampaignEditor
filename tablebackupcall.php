<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$stmt2 = $pdo->query("SELECT * FROM PoliTracker..Political_Editor_History ORDER BY submitted DESC");
$row2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);

echo json_encode($row2, JSON_FORCE_OBJECT);

?>
