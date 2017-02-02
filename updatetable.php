<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$column = $_REQUEST['col'];
$row = $_REQUEST['row'];
$value = $_REQUEST['val'];
$command = $_REQUEST['command'];
$tabl = $_REQUEST['tabl'];

if ($command == 'UPDATE' && isset($column) && isset($row) && isset($value) && isset($command) && isset($tabl)) {

	$tablename = ($tabl == "track") ? "PoliTracker..Political_Track" : "PoliTracker..Political_Schedule";
	$identifyingcolumn = ($tabl == "track") ? "ID" : "ScheduleID";

	$querycaptureprev = "SELECT " . $column . " FROM " . $tablename . " WHERE " . $identifyingcolumn . "=" . $row . ";"; 
	$stmtprev = $pdo->query($querycaptureprev);
	$prev = $stmtprev->fetch();

	echo $prev[$column];

	$query = "UPDATE " . $tablename . " SET " . $column . "='" . $value . "' WHERE " . $identifyingcolumn . "=" . $row .";";

//	echo $query;

	$stmt = $pdo->query($query);
	if ($stmt) {
		echo "1";
	} else {
		var_dump($pdo->errorInfo());
	}

	$undoquery = "UPDATE " . $tablename . " SET " . $column . "='" . $prev[$column] . "' WHERE " . $identifyingcolumn . "=" . $row .";";
	
	$formattedquery = str_replace("'","''", $query);
  $formattedundoquery = str_replace("'", "''", $undoquery);
	$summary = "Replaced " . $prev[$column] . " with " . $value . " in column " . $column . " on " . $tablename;

	$storestmt = $pdo->query("INSERT INTO PoliTracker..Political_Editor_History (change, inverse, summary) VALUES ('" . $formattedquery . "', '" . $formattedundoquery . "', '" . $summary . "');");
	if ($stmt) {
		echo "2";
	} else {
		var_dump($pdo->errorInfo());
	}

}

?>
