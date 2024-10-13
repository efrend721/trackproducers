<?php
$svg_icon = <<<SVG
<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-person-video3" viewBox="0 0 16 16">
  <path d="M14 9.5a2 2 0 1 1-4 0 2 2 0 0 1 4 0m-6 5.7c0 .8.8.8.8.8h6.4s.8 0 .8-.8-.8-3.2-4-3.2-4 2.4-4 3.2"/>
  <path d="M2 2a2 2 0 0 0-2 2v8a2 2 0 0 0 2 2h5.243c.122-.326.295-.668.526-1H2a1 1 0 0 1-1-1V4a1 1 0 0 1 1-1h12a1 1 0 0 1 1 1v7.81c.353.23.656.496.91.783Q16 12.312 16 12V4a2 2 0 0 0-2-2z"/>
</svg>
SVG;

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
    $results[] = ['nm_station' => '', 'id_status_station' => 0]; 
}

$status_map = [
    2 => ['message' => 'Done', 'icon' => '<i class="bi bi-check-circle-fill"></i>', 'class' => 'bg-success text-white'],
    1 => ['message' => 'In Progress', 'icon' => '<i class="bi bi-exclamation-triangle-fill"></i>', 'class' => 'bg-warning text-dark'],
    0 => ['message' => 'Not Started', 'icon' => '<i class="bi bi-x-circle-fill"></i>', 'class' => 'bg-danger text-white'],
];

foreach ($results as $resoult) {
    $status = $status_map[$resoult['id_status_station']] ?? $status_map[0]; // Usa el mapeo o el valor por defecto

    
    preg_match('/#(\d+)$/', $resoult['nm_station'], $matches);
    $machine_number = $matches[1] ?? '';

    $icon = ($resoult['id_status_station'] != 0) ? $svg_icon : '';

    echo <<<HTML
        <div class='d-flex justify-content-between mb-2 shadow p-2 border {$status['class']} rounded-2 mx-1'>
            <span>{$icon} {$machine_number}</span>
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
