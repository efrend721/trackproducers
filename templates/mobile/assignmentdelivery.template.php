<?php
function renderAssignmentDeliveryMobile($stmt1, $dbh, $deliveriesquery) {
ob_start() ;

echo <<<HTML
<div class='card'>
    <form method='POST' action='../views/deliveryredispatchview.php'>
        <div class='card-header'>
            <span><i class='bi bi-table me-2'></i></span>Delivery Assignment
            
                <button 
                    type='submit' 
                    name='assignment' 
                    class='btn btn-primary btn-sm float-end'>
                    Reassing
                </button>
            
        </div>
    </form>
    <div class='card-body'>
        <div class='table-responsive'>
            <form method='POST' action='../classes/deliverydispatch.classes.php'>    
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Select</th>
                            <th>Address</th>
                            <th>City</th>
                            <th>Date</th>
                            <th>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
HTML;

$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
    $id_project = htmlspecialchars($result['id_project'], ENT_QUOTES, 'UTF-8');
    $address = htmlspecialchars($result['address'], ENT_QUOTES, 'UTF-8');
    $city = htmlspecialchars($result['city'], ENT_QUOTES, 'UTF-8');
    $cityAbbr = getCityAbbr($city);
    $date = htmlspecialchars($result['date'], ENT_QUOTES, 'UTF-8');
    $date = formatDate($date);
    $nm_priority = htmlspecialchars($result['nm_priority'], ENT_QUOTES, 'UTF-8');
    $nm_priority = getAbbr($nm_priority);
    echo <<<HTML
                <tr>
                    <td>
                        <div class='form-check'>
                            <input name='check_list[]' class='form-check-input' type='checkbox' value='{$id_project}'>
                        </div>
                    </td>
                    <td>{$address}</td>
                    <td>{$cityAbbr}</td>
                    <td>{$date}</td>
                    <td>{$nm_priority}</td>
                </tr>
    HTML;
}

echo <<<HTML
            </tbody>
        </table>
        <br>
        <div class='d-flex justify-content-between align-items-center'>
            <select name='driver' id='driver' class='form-select w-100' aria-label='Default select example'>
                <option></option>
    HTML;
                $stmt3 = $dbh->connect()->prepare($deliveriesquery['details']['drivers']);
                $stmt3->execute();
                $ResultProject1 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                foreach ($ResultProject1 as $assignment) {
                    $id_user = htmlspecialchars($assignment['user_id'], ENT_QUOTES, 'UTF-8');
                    $nm_user = htmlspecialchars($assignment['name_user'], ENT_QUOTES, 'UTF-8');
                    echo <<<HTML
                                <option value='{$id_user}'>{$nm_user}</option>
                    HTML;
                }
echo <<<HTML
            </select>
                </div>
                <br>
                    <div class='d-flex justify-content-end'>
                    <button 
                        type='submit' 
                        name='assignment' 
                        class='btn btn-primary'>
                        Assing
                    </button>
                </div>
            </form> 
        </div>
    </div>
</div>
HTML;
return ob_get_clean();
}
?>