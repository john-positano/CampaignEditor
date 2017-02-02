<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$tabl = $_REQUEST['tabl'];
$tablename = ($tabl == "track") ? "PoliTracker..Political_Track" : "PoliTracker..Political_Schedule";
$identifier = ($tabl == "track") ? "ID" : "ScheduleID";

$insertquerychunk = ($tabl == "track") ? "(CampaignID, Campaign_Name, Client_Name, State, Special_Instructions) VALUES ('POL12345', 'NewCamp', 'NewClient', 'ST', 'Special Instructions');" : "(Campaignid, call_date, call_times, contacts, Patches, reps, hrs, location, Start_Time, Stop_Time, Return_Data_Due, Complete, Changed, Processed, live_messages, auto_messages, ProcessNotes, Processor, factor) VALUES ('POL09999', null, null, null, null, null, null, 'SANCL5', null, null, null, '0', null, null, null, null, null, null, '100')";

$insertquery = "INSERT INTO " . $tablename . " " . $insertquerychunk;

$formattedinsertquery = str_replace("'","''", $insertquery);

$stmt = $pdo->query($insertquery);

if ($stmt) {

	echo "success";

} else {

	echo var_dump($pdo->errorInfo());

}

$query2 = "SELECT TOP 1 " . $identifier . " FROM " . $tablename . " ORDER BY " . $identifier . " DESC";

$stmt2 = $pdo->query($query2);
$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
$id = $row2[$identifier];

$deletequery = "DELETE FROM " . $tablename . " WHERE " . $identifier . "='" . $id . "'";
$formatteddeletequery = str_replace("'","''", $deletequery);

$summary = "Inserted Row #" . $id . " into " . $tablename;

if ($stmt) {
	$storestmt = $pdo->query("INSERT INTO PoliTracker..Political_Editor_History (change, inverse, summary) VALUES ('" . $formattedinsertquery . "', '" . $formatteddeletequery . "', '" . $summary . "');");
	if ($storestmt) {
		echo "success";
	}
} else {
	var_dump($pdo->errorInfo());
}

?>

