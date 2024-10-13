<?php
function renderMobileDeliveryAssignment($dbh, $stmt1, $deliveriesquery) {
    ob_start(); // Iniciar el almacenamiento en búfer de la salida

    echo <<<HTML
    <form method='POST' action='../classes/deliveryreassignment.classes.php'>    
    <div class='card'>
        <div class='card-header'>
            <span><i class='bi bi-table me-2'></i></span>Delivery Assignment
        </div>
        <div class='card-body'>
            <div class='table-responsive'>
                <table class='table table-striped'>
                        <thead>
                            <tr>
                                <th>Select</th>
                                <th>Address</th>
                                <th>City</th>
                                <th>Driver</th>
                            </tr>
                        </thead>
                        <tbody>
    HTML;

    $results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
    foreach ($results as $result) {
        $id_project = htmlspecialchars($result['id_project'], ENT_QUOTES, 'UTF-8');
        $address = htmlspecialchars($result['address'], ENT_QUOTES, 'UTF-8');
        $city = htmlspecialchars($result['city'], ENT_QUOTES, 'UTF-8');
        $city = getCityAbbr($city);
        $nm_driver = htmlspecialchars($result['name_user'], ENT_QUOTES, 'UTF-8');
        echo <<<HTML
                <tr>
                    <td>
                        <div class='form-check'>
                            <input name='check_list[]' class='form-check-input' type='checkbox' value='{$id_project}'>
                        </div>
                    </td>
                    <td>{$address}</td>
                    <td>{$city}</td>
                    <td>{$nm_driver}</td>
                </tr>
        HTML;
    }

    echo <<<HTML
                </tbody>
            </table>
        </div>
    </div>
    HTML;

    echo <<<HTML
            <div class='card-body d-flex justify-content-between align-items-center'>
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
            <div class='card-body text-end'>
                <button 
                    type="button" 
                    name="back" 
                    class="btn btn-primary" 
                    onclick="location.href='../views/deliveryassignments.php'">
                    Back
                </button>
                <button 
                    type='submit' 
                    name='assignment' 
                    class='btn btn-primary'>
                    Assign
                </button>
            </div> 
        </div>
    </div>
    </div>
    </form>
    HTML;

    return ob_get_clean(); // Obtener el contenido del búfer y limpiarlo
}
?>
