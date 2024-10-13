<?php 
require_once 'dbh.classes.php';

class ProjectMain {
    public function getProjectquery() {
        $dbh = new Dbh();
        include_once '../includes/serverside.rendering.php';
        include_once '../queries/allprojects.query.php';

        echo <<<HTML
        <main class='mt-5 pt-3'>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-md-12'>
                        <h4>Update Single Priority</h4>
                    </div>
                </div>
                <div class='row'>
                    <div class='col-md-12'>
HTML;
                        
        include_once '../includes/mensages.php';
                
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
                    
            if ($devise == 'mobile') {
                include_once '../templates/mobile/updatepriority.template.php';
            } else {
                include_once '../templates/updatepriority.template.php';
            }
                    
        } else {
            if ($devise == 'mobile') {
                include_once '../templates/mobile/projects.template.php';
            } else {
                include_once '../templates/projects.template.php';
            }
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
