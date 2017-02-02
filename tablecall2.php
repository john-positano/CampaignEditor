<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$stmt = $pdo->query("SELECT ScheduleID, Campaignid, call_date, call_times, contacts, Patches, reps, hrs, location, Start_Time, Stop_Time, Complete, factor FROM PoliTracker..Political_Schedule where call_date = convert(datetime, left(current_timestamp, 11)) OR call_date = null ORDER BY ScheduleID DESC");
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);	

echo json_encode($row, JSON_FORCE_OBJECT);

?>
