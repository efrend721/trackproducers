<?php

echo <<<HTML
<div class='card'>
    <div class='card-header'>
        <span><i class='bi bi-table me-2'></i></span>Status Area
    </div> 
    <div class='card-body'>
HTML;

$stmtArea = $dbh->connect()->prepare($projectlistquery['details']['areaDept']);  
$stmtArea->bindParam(1, $id_dept, PDO::PARAM_INT);
$stmtArea->execute();
$resultsArea = $stmtArea->fetchAll(PDO::FETCH_ASSOC);

foreach ($resultsArea as $resoultArea) {
echo <<<HTML
<div class='row mb-3'>
    <div class='col-6'>
        <div class='shadow p-3 bg-light border rounded-3 mx-1'>
            {$resoultArea['nm_area']}
        </div>
    </div>
    <div class='col-6'>
        <div class='shadow p-1 bg-light border rounded-3 mx-1'>
HTML;

$stmtStationArea = $dbh->connect()->prepare($projectlistquery['details']['stationArea']);
$stmtStationArea->bindParam(1, $resoultArea['id_area'], PDO::PARAM_INT);
$stmtStationArea->bindParam(2, $idjob, PDO::PARAM_INT);
$stmtStationArea->execute();
$results = $stmtStationArea->fetchAll(PDO::FETCH_ASSOC);

if (empty($results)) {
    $results[] = ['nm_station' => '', 'id_status_station' => 0]; // Asigna id_status_station a 0 si no hay resultados
}

// Definir el array de mapeo de estados
$status_map = [
    2 => ['message' => 'Done', 'icon' => '<i class="bi bi-check-circle-fill"></i>', 'class' => 'bg-success text-white'],
    1 => ['message' => 'In Progress', 'icon' => '<i class="bi bi-exclamation-triangle-fill"></i>', 'class' => 'bg-warning text-dark'],
    0 => ['message' => 'Not Started', 'icon' => '<i class="bi bi-x-circle-fill"></i>', 'class' => 'bg-danger text-white'],
];

foreach ($results as $resoult) {
    $status = $status_map[$resoult['id_status_station']] ?? $status_map[0]; // Usa el mapeo o el valor por defecto

    echo <<<HTML
        <div class='d-flex justify-content-between mb-2 shadow p-2 border {$status['class']} rounded-2 mx-1'>
            <span>{$resoult['nm_station']}</span>
            <span>{$status['message']} {$status['icon']}</span>
        </div>
HTML;
}

echo <<<HTML
        </div>
    </div>
</div>
HTML;
}

echo <<<HTML
    </div>
</div>
<br>
HTML;
?>
