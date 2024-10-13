<?php 
require_once 'dbh.classes.php';
include_once '../includes/abbr.php';

class deliveriesListMain {
    public function getDeliveriesList() {
        $dbh = new Dbh();
             
        
        include_once '../includes/serverside.rendering.php';
        include_once '../queries/deliveries.query.php';
           
        
        if ($devise == 'mobile') {

            include_once '../templates/mobile/maindeliverieslist.template.php';
        
        }else{
            
            include_once '../templates/maindeliverieslist.template.php';
        }

        
    }
}
?>


