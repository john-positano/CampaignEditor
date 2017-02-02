<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

//$column = $_REQUEST['col'];
$row = $_REQUEST['row'];
//$value = $_REQUEST['val'];
//$command = $_REQUEST['command'];
$tabl = $_REQUEST['tabl'];

if (isset($row) && isset($tabl)) {

	$tablename = ($tabl == "track") ? "PoliTracker..Political_Track" : "PoliTracker..Political_Schedule";
	$identifyingcolumn = ($tabl == "track") ? "ID" : "ScheduleID";

	$querycaptureprev = "SELECT * FROM " . $tablename . " WHERE " . $identifyingcolumn . "=" . $row . ";"; 
	$stmtprev = $pdo->query($querycaptureprev);
	$prev = $stmtprev->fetch();

	$columns = "";

	$length = count($_REQUEST);
	$i = 0;

	foreach($_REQUEST as $key => $value) {
		
		if ($key != "row" && $key != "tabl" && $key != "ID" && $key != "ScheduleID") {
			if ($value != "null") {
				$columns .= $key . "='" . $value . "'";
			} else {
				$columns .= $key . "=" . $value;
			}
			if ($i < $length - 1) {
				$columns .= ",";
			}
		}
		$i++;
	}

	$query = "UPDATE " . $tablename . " SET " . $columns . " WHERE " . $identifyingcolumn . "=" . $row .";";

//	echo $query;

	$stmt = $pdo->query($query);
	if ($stmt) {
		echo "1";
	} else {
		var_dump($pdo->errorInfo());
	}

	$columns2 = "";
	$j = 0;

	foreach($_REQUEST as $key => $value) {
		
		if ($key != "row" && $key != "tabl" && $key != "ID" && $key != "ScheduleID") {
			if ($value != "null") {
				$columns2 .= $key . "='" . $value . "'";
			} else {
				$columns2 .= $key . "=" . $value;
			}
			if ($j < $length - 1) {
				$columns2 .= ",";
			}
		}
		$j++;
	}

	$undoquery = "UPDATE " . $tablename . " SET " . $columns2 . " WHERE " . $identifyingcolumn . "=" . $row .";";
	
	$formattedquery = str_replace("'","''", $query);
  $formattedundoquery = str_replace("'", "''", $undoquery);
	$summary = "Updated Row#" . $row . " on " . $tablename;

	$storestmt = $pdo->query("INSERT INTO PoliTracker..Political_Editor_History (change, inverse, summary) VALUES ('" . $formattedquery . "', '" . $formattedundoquery . "', '" . $summary . "');");
	if ($stmt) {
		echo "2";
	} else {
		var_dump($pdo->errorInfo());
	}

}

?>
