<?php 
require_once 'dbh.classes.php';
include_once '../includes/abbr.php';

class ProjectListMain {
    public function getProjectList() {
        $dbh = new Dbh();
             
        
        include_once '../includes/serverside.rendering.php';
        include_once '../queries/projectlist.query.php';
           
        
        if ($devise == 'mobile') {

            include_once '../templates/mobile/mainprojectlist.template.php';
        
        }else{
            
            include_once '../templates/mainprojectlist.template.php';
        }

        
    }
}
?>


