<?php

function displayAssignedDeliveries($dbh, $deliveriesquery, $id_user, $nm_user, $ResultStation) {

    echo <<<HTML
        <br>
        <div class='card'>
            <div class='card-header'>
                <span><i class='bi bi-table me-2'></i></span>{$nm_user}
            </div>
            <div class='card-body'>
                <div class='shadow row'>
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>Address</th>
                                <th scope='col'>City</th>
                                <th scope='col'>Date</th>
                                <th scope='col'>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
    HTML;

    $stmtDeliveriesAssigned = $dbh->connect()->prepare($deliveriesquery['details']['deliveriesAssigned']);
    $stmtDeliveriesAssigned->bindParam(1, $id_user, PDO::PARAM_INT);
    //$stmtDeliveriesAssigned->bindParam(2, $ResultStation, PDO::PARAM_INT);
    $stmtDeliveriesAssigned->execute();
    $ResultDeliveriesAssigned = $stmtDeliveriesAssigned->fetchAll(PDO::FETCH_ASSOC);
    
    if (empty($ResultDeliveriesAssigned)) {
        echo "<tr><td colspan='4'>There are no orders assigned to this driver.</td></tr>";
    } else {
        foreach ($ResultDeliveriesAssigned as $assignment) {
            $id_project = htmlspecialchars($assignment['id_project'], ENT_QUOTES, 'UTF-8');
            $address = htmlspecialchars($assignment['address'], ENT_QUOTES, 'UTF-8');
            $city = htmlspecialchars($assignment['city'], ENT_QUOTES, 'UTF-8');
            $date = htmlspecialchars($assignment['date'], ENT_QUOTES, 'UTF-8');
            $nm_priority = htmlspecialchars($assignment['nm_priority'], ENT_QUOTES, 'UTF-8');
            echo <<<HTML
                                <tr>
                                    <td>{$address}</td>
                                    <td>{$city}</td>
                                    <td>{$date}</td>
                                    <td>{$nm_priority}</td>
                                </tr>
            HTML;
        }
    }

    echo <<<HTML
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    HTML;
}

function dispAssgnDelivMbl($dbh, $deliveriesquery, $id_user, $nm_user, $ResultStation, $getCityAbbr, $getAbbr, $formatDate) {
    
    echo <<<HTML
        <br>
        <div class='card'>
            <div class='card-header'>
                <span><i class='bi bi-table me-2'></i></span>{$nm_user}
            </div>
            <div class='card-body'>
                <div class='shadow row'>
                    <table class='table table-striped table-hover'>
                        <thead>
                            <tr>
                                <th scope='col'>Address</th>
                                <th scope='col'>City</th>
                                <th scope='col'>Date</th>
                                <th scope='col'>Priority</th>
                            </tr>
                        </thead>
                        <tbody>
    HTML;

    $stmtDeliveriesAssigned = $dbh->connect()->prepare($deliveriesquery['details']['deliveriesAssigned']);
    $stmtDeliveriesAssigned->bindParam(1, $id_user, PDO::PARAM_INT);
    //$stmtDeliveriesAssigned->bindParam(2, $ResultStation, PDO::PARAM_INT);
    $stmtDeliveriesAssigned->execute();
    $ResultDeliveriesAssigned = $stmtDeliveriesAssigned->fetchAll(PDO::FETCH_ASSOC);

    if (empty($ResultDeliveriesAssigned)) {
        echo "<tr><td colspan='4'>There are no orders assigned to this driver.</td></tr>";
    } else {
        foreach ($ResultDeliveriesAssigned as $assignment) {
            $id_project = htmlspecialchars($assignment['id_project'], ENT_QUOTES, 'UTF-8');
            $address = htmlspecialchars($assignment['address'], ENT_QUOTES, 'UTF-8');
            $city = htmlspecialchars($assignment['city'], ENT_QUOTES, 'UTF-8');
            $cityAbbr = $getCityAbbr($city);
            $date = htmlspecialchars($assignment['date'], ENT_QUOTES, 'UTF-8');
            $date = $formatDate($date);
            $nm_priority = htmlspecialchars($assignment['nm_priority'], ENT_QUOTES, 'UTF-8');
            $nm_priority = $getAbbr($nm_priority);
            echo <<<HTML
                                <tr>
                                    <td>{$address}</td>
                                    <td>{$cityAbbr}</td>
                                    <td>{$date}</td>
                                    <td>{$nm_priority}</td>
                                </tr>
            HTML;
        }
    }

    echo <<<HTML
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    HTML;
}
?>
