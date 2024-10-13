<?php 
$idProjectUpdate = filter_input(INPUT_POST, 'updatesingleproject', FILTER_VALIDATE_INT);

echo <<<HTML
<form action='../classes/priorityupdatesingle.classes.php' method='POST'>
    <div class='card'>
        <div class='card-header'>
            <span><i class='bi bi-table me-2'></i></span> Project $idProjectUpdate   $devise
        </div>
        <div class='card-body'>
            <div class='shadow row mb-2 p-2 bg-dark border rounded-3 text-white'>
                <div class='col-6'><span class='strong'>Address</span></div>
                <div class='col-2'><span class='strong'>Date</span></div>
                <div class='col-2'><span class='strong'>Priority</span></div>
                <div class='col-2 d-flex justify-content-end'><span class='strong'>Process</span></div>
            </div>
HTML;

$stmt1 = $dbh->connect()->prepare($consultaAll['allprojects']['sqlSingleproject']);
$stmt1->bindParam(1, $idProjectUpdate);
$stmt1->execute();
$results = $stmt1->fetch(PDO::FETCH_ASSOC);

echo <<<HTML
            <div class='shadow row mb-2 p-2 bg-secondary bg-opacity-50 border rounded-3'>
                <div class='col-6'><span class='strong'>{$results['address']}</span></div>
                <div class='col-2'><span class='strong'>{$results['date']}</span></div>
                <div class='col-2'><span class='strong'>{$results['nm_priority']}</span></div>
                <div class='col-2 d-flex justify-content-end'>
                    <span>
                        <select name='priority' id='priority' class='form-select' aria-label='Default select example'>
                            <option></option>
HTML;

$stmt3 = $dbh->connect()->prepare('SELECT id_priority, nm_priority FROM priority');
$stmt3->execute();
$ResultProject1 = $stmt3->fetchAll(PDO::FETCH_ASSOC);

foreach ($ResultProject1 as $ResultProject1) {
    echo <<<HTML
                            <option value='{$ResultProject1['id_priority']}'>{$ResultProject1['nm_priority']}</option>
HTML;
}

echo <<<HTML
                        </select>    
                    </span>
                </div>
            </div>
        </div>
    </div><br>
    <div class='card'>
        <div class='card-body'>
            <div class='row'>
                <div class='col-8 d-flex justify-content-end'>
                    <a href='../views/priorityview.php' class='btn btn-primary'>Cancel</a>
                </div>
                <div class='col-4 d-flex justify-content-end'>
                    <button type='submit' class='btn btn-primary' name='idproject' value='$idProjectUpdate'>Update</button>
                </div>
            </div>    
        </div>
    </div><br>
</form>
HTML;
?>
