<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$tabl = $_REQUEST['tabl'];
$rowid = $_REQUEST['rowid'];
$tablename = ($tabl == "track") ? "PoliTracker..Political_Track" : "PoliTracker..Political_Schedule";
$identifier = ($tabl == "track") ? "ID" : "ScheduleID";

$query = "SELECT * FROM " . $tablename . " WHERE " . $identifier . "='" . $rowid . "';";
$stmt = $pdo->query($query);
$row = $stmt->fetch(PDO::FETCH_ASSOC);

$reinsertquery = "INSERT INTO " . $tablename . " (";
$reinsertquery2 = ") VALUES (";

$len = count($row);
$i = 0;

foreach ($row as $key => $value) {
	if ($key != $identifier) {
		$i++;
		$reinsertquery .= $key;
		if ($value) {
			$reinsertquery2 .= "'" . $value . "'";
		} else {
			$reinsertquery2 .= "null";
		}
		if ($i != $len - 1) {
			$reinsertquery .= ", ";
			$reinsertquery2 .= ", ";
		}
	}
}

$fullreinsertquery = $reinsertquery . $reinsertquery2 . ");";

$formattedinsertquery = str_replace("'","''", $fullreinsertquery);

$deletequery = "DELETE FROM " . $tablename . " WHERE " . $identifier . "='" . $rowid . "';";

$formatteddeletequery = str_replace("'","''", $deletequery);

$summary = "Deleted Row #" . $rowid . " from " . $tablename;

$deletestmt = $pdo->query($deletequery);
if ($deletestmt) {
	$storestmt = $pdo->query("INSERT INTO PoliTracker..Political_Editor_History (change, inverse, summary) VALUES ('" . $formatteddeletequery . "', '" . $formattedinsertquery . "', '" . $summary . "');");
	if ($storestmt) {
		echo "success";
	}
} else {
	var_dump($pdo->errorInfo());
}


?>




