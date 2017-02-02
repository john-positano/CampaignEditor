<?php

try {
	$pdo = new PDO("dblib:host=172.16.80.24", "sa", "k!p@ny52");
} catch (PDOException $e) {
	echo $e->getMessage();
}

$today = date("Y-m-d");
$query = "SELECT * FROM PoliTracker..Political_Track_test ORDER BY ID DESC";
/*$query = "USE PoliTracker; SELECT upper(Political_Track_test.CampaignID) as CampaignID, Political_Track_test.CampaignName, Political_Schedule_test.call_date, Political_Track_test.State, Political_Schedule_test.Complete, Political_Track_test.Client_Name, RIGHT('0' + LTRIM(RIGHT(CONVERT(VARCHAR, CAST(start_time AS DATETIME), 100), 7)), 7) AS start_time, RIGHT('0' + LTRIM(RIGHT(CONVERT(VARCHAR, CAST(stop_time AS DATETIME), 100), 7)), 7) AS stop_time, CAST(dbo.Political_Schedule_test.factor * .01 * Political_Schedule_test.contacts AS INTEGER) AS contacts, CAST(dbo.Political_Schedule_test.factor * .01 * Political_Schedule_test.Patches AS INTEGER) AS Patches, Political_Track_test.Targets, Political_Track_test.Cph, Political_Track_test.PPH, dbo.Political_Schedule_test.reps, CAST(dbo.Political_Schedule_test.factor * .01 * Political_Schedule_test.hrs AS INTEGER) AS hrs, Political_Schedule_test.location, Political_Track_test.Special_Instructions, dbo.Political_Schedule_test.Complete FROM Political_Track_test INNER JOIN Political_Schedule_test ON Political_Track_test.CampaignID = Political_Schedule_test.Campaignid WHERE call_date = '2016-10-11' AND dbo.Political_Schedule_test.location LIKE 'SAN%' ORDER BY Political_Track_test.client_name, Political_Track_test.CampaignID";
//$query = "SELECT * FROM PoliTracker..Political_Track_test";*/
$stmt = $pdo->query($query);								
$row = $stmt->fetchAll(PDO::FETCH_ASSOC);

/*$finalrow = [];

for ($i = 0; $row[$i]["CampaignID"]; $i++) {
	$campaignid = $row[$i]["CampaignID"];
	$stmt2 = $pdo->query("SELECT * FROM PoliTracker..Political_Track_test WHERE CampaignID = '$campaignid'");
	$row2 = $stmt2->fetch(PDO::FETCH_ASSOC);
	array_push($finalrow, $row2);
}*/

echo json_encode($row, JSON_FORCE_OBJECT);

?>
