<?php
require_once '../classes/dbh.classes.php';
$dbh = new Dbh();
// Include the database connection class

$id_area = intval($_GET['id_area']);

// Query the database
$stmtArea = $dbh->connect()->prepare('SELECT `id_station`, `nm_station` FROM `station` WHERE `id_area` = ?');
$stmtArea->execute([$id_area]);

$stations = array();

// Fetch the results
while ($row = $stmtArea->fetch(PDO::FETCH_ASSOC)) {
    $stations[] = $row;
}

// Close the connection
$stmtArea = null;
$dbh = null;

// Return the results as JSON
echo json_encode($stations);
?>


