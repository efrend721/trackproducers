<?php
$search = $_POST['search'] ?? '';
$reset = isset($_POST['reset']);

if ($reset) {
    $search = '';
}

echo <<<HTML
<main class='mt-5 pt-3'>
    <div class='container-fluid'>
        <div class='row'>
            <div class='col-md-12'>
                <div class='card'>
                    <div class='card-header'>
                        <span><i class='bi bi-table me-2'></i></span> Projects 
                    </div>
                    <div class='card-body'>
                        <div class='shadow row'>
                            <form class='d-flex ms-auto my-3 my-lg-0' method='POST' action=''>
                                <div class='input-group'>
                                    <input
                                        class='form-control'
                                        type='search'
                                        id='search'
                                        name='search'
                                        placeholder='Search'
                                        aria-label='Search'
                                        value='$search'
                                    />
                                    <button class='btn btn-primary' type='submit'>
                                        <i class='bi bi-search'></i>
                                    </button>
                                    <button class='btn btn-secondary' type='submit' name='reset' value='1'>
                                        <i class='bi bi-arrow-counterclockwise'></i> Reset
                                    </button>
                                </div>
                            </form>    
                        </div>
                    </div>
                </div>
                <br>
HTML;

//include('../queries/deliveries.query.php');
$stmt1 = $dbh->connect()->prepare($deliveriesquery['allDeliveries']['allDeliveriesAssignedDriver']);
$stmt1->execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%"]);

echo <<<HTML
                <div class='card'>
                    <div class='card-body'>
                        <div class='shadow row mb-3 p-3 bg-dark border rounded-3 text-white'>
                            <div class='col-3'><span class='strong'>Address</span></div>
                            <div class='col-1'>City</div>
                            <div class='col-2'>Driver</div>
                            <div class='col-2'>Date End</div>
                            <div class='col-2'>Time End</div>
                            <div class='col-2 text-end'>Status</div>
                        </div>
                        
HTML;

$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
    $id_project = htmlspecialchars($result['id_project'], ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($result['address'], ENT_QUOTES, 'UTF-8');
    $cityAbbr = getCityAbbr($result['city']);
    $name_user = htmlspecialchars($result['name_user'], ENT_QUOTES, 'UTF-8');
    $date_end = htmlspecialchars($result['date_finish'] ?: '0000-00-00', ENT_QUOTES, 'UTF-8');
    $time_end = htmlspecialchars($result['time_finish'] ?: '00:00:00', ENT_QUOTES, 'UTF-8');
    $id_status_station = htmlspecialchars($result['id_status_station'], ENT_QUOTES, 'UTF-8');
    
    // Define a map of status icons based on station status ID
    $status_icons_map = [
        '0' => '<i class="bi bi-x-circle-fill"></i>', // Status ID 0 maps to a cross icon
        '1' => '<i class="bi bi-exclamation-triangle-fill"></i>', // Status ID 1 maps to a warning icon
    ];

    // Use null coalescing to get the default value if the status ID is not found in the map
    $status_icon = $status_icons_map[$id_status_station] ?? '<i class="bi bi-check-circle-fill"></i>'; // Default to check icon


    echo <<<HTML
                <div class='shadow row mb-2 p-2 bg-secondary bg-opacity-50 border rounded-3'>
                    <div class='col-3 text-truncate' style='font-size: 0.875rem;'>{$address}</div>
                    <div class='col-1' style='font-size: 0.875rem;'>{$cityAbbr}</div>
                    <div class='col-2' style='font-size: 0.875rem;'>{$name_user}</div>
                    <div class='col-2' style='font-size: 0.875rem;'>{$date_end}</div>
                    <div class='col-2' style='font-size: 0.875rem;'>{$time_end}</div>
                    <div class='col-2 text-end'>{$status_icon}</div> 
                    
                </div>
HTML;
}

echo <<<HTML
                         
                    </div>
                </div>    
            </div>                
        </div>                            
    </div>
</main>
HTML;
?>
