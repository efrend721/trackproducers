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

include('../queries/projectlist.query.php');
$stmt1 = $dbh->connect()->prepare($projectlistquery['allProjects']['searchQuery']);
$stmt1->execute(["%$search%", "%$search%", "%$search%", "%$search%", "%$search%", "%$search%"]);

echo <<<HTML
                <div class='card'>
                    <div class='card-body'>
                        <div class='shadow row mb-3 p-3 bg-dark border rounded-3 text-white'>
                            <div class='col-5'><span class='strong'>Address</span></div>
                            <div class='col-1'>City</div>
                            <div class='col-2'>Priority</div>
                            <div class='col-2'>Date</div>
                            <div class='col-2 text-end'>Process</div>
                        </div>
                        <form action='projectlistdetailview.php' method='POST'>
HTML;

$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
    $cityAbbr = getCityAbbr($result['city']);
    $address = htmlspecialchars($result['address'], ENT_QUOTES, 'UTF-8');
    $nm_priority = htmlspecialchars($result['nm_priority'], ENT_QUOTES, 'UTF-8');
    $date = htmlspecialchars($result['date'], ENT_QUOTES, 'UTF-8');
    $id_project = htmlspecialchars($result['id_project'], ENT_QUOTES, 'UTF-8');
    echo <<<HTML
                <div class='shadow row mb-2 p-2 bg-secondary bg-opacity-50 border rounded-3'>
                    <div class='col-5 text-truncate' style='font-size: 0.875rem;'>{$address}</div>
                    <div class='col-1' style='font-size: 0.875rem;'>{$cityAbbr}</div>
                    <div class='col-2' style='font-size: 0.875rem;'>{$nm_priority}</div>
                    <div class='col-2' style='font-size: 0.875rem;'>{$date}</div>
                    <div class='col-2'><button type='submit' name='process' value='{$id_project}' class='btn btn-light btn-sm float-end'>Details</button></div> 
                </div>
HTML;
}

echo <<<HTML
                        </form> 
                    </div>
                </div>    
            </div>                
        </div>                            
    </div>
</main>
HTML;
?>
