<?php
require_once 'dbh.classes.php';
require_once '../templates/deliveriesassigned.template.php';
require_once '../includes/abbr.php';

class ProjectDeliveryMain
{
    public function getProjectDeliveryQuery()
    {
        $dbh = new Dbh();
        include_once '../includes/serverside.rendering.php';
        include '../queries/deliveries.query.php';
        
        echo <<<HTML
            <main class='mt-5 pt-3'>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
        HTML;

        require_once '../includes/mensages.php';
        //$id_user = $_SESSION['id_user'];    
        

        $stmt1 = $dbh->connect()->prepare($deliveriesquery['allDeliveries']['allProjects']);
        $stmt1->execute();
        
        if ($devise == 'mobile') {
            
            
            include_once '../templates/mobile/assignmentdelivery.template.php';
            echo renderAssignmentDeliveryMobile($stmt1, $dbh, $deliveriesquery);

            
            
            $stmtDriver = $dbh->connect()->prepare($deliveriesquery['details']['driverAssigned']);
            $stmtDriver->execute();
            $ResultDriver = $stmtDriver->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($ResultDriver as $assignment) {
                
                $id_user = htmlspecialchars($assignment['user_id'], ENT_QUOTES, 'UTF-8');
                $nm_user = htmlspecialchars($assignment['name_user'], ENT_QUOTES, 'UTF-8');
                
                $stmtStation = $dbh->connect()->prepare($deliveriesquery['details']['driversArea']);
                $stmtStation->bindParam(1, $id_user, PDO::PARAM_INT);
                $stmtStation->execute();
                $ResultStation = $stmtStation->fetch(PDO::FETCH_ASSOC);
                $ResultStation = $ResultStation['id_station'];

                dispAssgnDelivMbl($dbh, $deliveriesquery, $id_user, $nm_user, $ResultStation, 'getCityAbbr', 'getAbbr', 'formatDate');  
                   
                
            }
        
        } else {
            
            include_once '../templates/assignmentdelivery.template.php';
            
            echo renderAssignmentDelivery($stmt1, $dbh, $deliveriesquery);

            $stmtDriver = $dbh->connect()->prepare($deliveriesquery['details']['driverAssigned']);
            $stmtDriver->execute();
            $ResultDriver = $stmtDriver->fetchAll(PDO::FETCH_ASSOC);
    
            foreach ($ResultDriver as $assignment) {
                
                $id_user = htmlspecialchars($assignment['user_id'], ENT_QUOTES, 'UTF-8');
                $nm_user = htmlspecialchars($assignment['name_user'], ENT_QUOTES, 'UTF-8');

                $stmtStation = $dbh->connect()->prepare($deliveriesquery['details']['driversArea']);
                $stmtStation->bindParam(1, $id_user, PDO::PARAM_INT);
                $stmtStation->execute();
                $ResultStation = $stmtStation->fetch(PDO::FETCH_ASSOC);
                $ResultStation = $ResultStation['id_station'];
                
                displayAssignedDeliveries($dbh, $deliveriesquery, $id_user, $nm_user, $ResultStation);  
                   
                
            }
        }
        echo <<<HTML
                    </div>
                </div>
            </div>
        </main>
        <br>
        HTML;
    }
}
?>
