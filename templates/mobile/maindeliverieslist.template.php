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

//include('../queries/projectlist.query.php');
$stmt1 = $dbh->connect()->prepare($deliveriesquery['allDeliveries']['allDeliveriesAssignedDriver']);
$stmt1->execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%"]);

echo <<<HTML
                <div class='card'>
                    <div class='card-body'>
                        <div class='shadow row mb-3 p-3 bg-dark border rounded-3 text-white'>
                            <div class='col-7'><span class='strong'>Address</span></div>
                            <div class='col-2'>City</div>                           
                            <div class='col-3 text-end'>Status</div>
                        </div>
                        
HTML;

$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
    $address = htmlspecialchars($result['address'] ?: 'N/A', ENT_QUOTES, 'UTF-8');
    $cityAbbr = getCityAbbr($result['city'] ?: 'N/A');
    $id_status_station = htmlspecialchars($result['id_status_station'], ENT_QUOTES, 'UTF-8');
    
    $status_icon = '';
    if ($id_status_station == '') {
        $status_icon = '<i class="bi bi-exclamation-triangle-fill text-warning"></i> Not Started';
    } elseif ($id_status_station == '2') {
        $status_icon = '<i class="bi bi-check-circle-fill text-success"></i>';
    } else {
        $status_icon = $id_status_station;
    }

    echo <<<HTML
                            <div class='shadow row mb-2 p-2 bg-secondary bg-opacity-50 border rounded-3'>
                                <div class='col-7 text-truncate'>{$address}</div>
                                <div class='col-2'>{$cityAbbr}</div>
                                <div class='col-3 text-end'>{$status_icon}</div>
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
