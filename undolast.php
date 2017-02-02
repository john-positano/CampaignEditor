<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$query = "SELECT TOP 1 id, CAST(inverse as TEXT) FROM PoliTracker..Political_Editor_History ORDER BY submitted DESC";

$stmt = $pdo->query($query);
$row = $stmt->fetch();

$time = $row["id"];
$inversequery = $row["computed1"];

var_dump($row);

$stmt2 = $pdo->query($inversequery);
$query3 = "DELETE FROM PoliTracker..Political_Editor_History WHERE id='" . $time . "';";
$stmt3 = $pdo->query($query3);
if ($stmt3) {
	echo "success";
} else {
	$pdo->errorInfo();
}
if ($stmt2) {

} else {
	var_dump($pdo->errorInfo());
}

?>
