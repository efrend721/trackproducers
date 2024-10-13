<?php
require_once 'dbh.classes.php';
require_once '../includes/abbr.php';
class ProjectRedispatchMain
{
    public function getProjectRedispatchQuery()
    {
        $dbh = new Dbh();
        include_once '../includes/serverside.rendering.php';
        require '../queries/deliveries.query.php';
                
        echo <<<HTML
            <main class='mt-5 pt-3'>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>
        HTML;

        require_once '../includes/mensages.php';
        
        $stmt1 = $dbh->connect()->prepare($deliveriesquery['allDeliveries']['allDeliveriesAssigned']);
        $stmt1->execute();
        
        
        if ($devise == 'mobile') {
            
            include_once '../templates/mobile/redispatch.template.php';
            echo renderMobileDeliveryAssignment($dbh, $stmt1, $deliveriesquery);
        
        } else {
            
            include_once '../templates/redispatch.template.php';
            echo renderDeliveryAssignment($dbh, $stmt1, $deliveriesquery);
       
        }
        echo <<<HTML
                    </div>
                </div>
            </div>
        </main>
        HTML;
    }
}
?>
