<?php 
require_once 'dbh.classes.php';
require_once '../includes/abbr.php';
class TaskMain {
    public function getTaskquery() {
        $user_id = $_SESSION['user_id'];
        $dbh = new Dbh();
        
        include_once '../includes/serverside.rendering.php';
        $contenedorStyle = "background-color: #b0b0b0; color: #333; font-size: 1.0rem; font-weight: 300; display: flex; justify-content: flex-end";
        $calloutinfo = "border-left: 5px solid #17a2b8; background-color: #e9ecef; padding: 15px;  margin: 10px 0; border-radius: 5px;";
        
        echo <<<HTML
            <main class='mt-5 pt-3'>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12 p-1'>
                            <h4>Jobs</h4>
                        </div>
                    </div>
                
            HTML;

            include_once '../includes/mensages.php';

            if ($_SERVER["REQUEST_METHOD"] == "POST") {
                if ($devise == 'mobile') {

                    include_once '../templates/mobile/taskaddcomment.template.php';
                
                }else{
                    
                    include_once '../templates/taskaddcomment.template.php';
                }
            }
            else { 
            require '../queries/task.query.php';
            $stmtarea = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlIdStation']);
            $stmtarea->bindParam(1, $user_id);
            $stmtarea->execute();
            $rowarea = $stmtarea->fetch(PDO::FETCH_ASSOC);            
            $area = $rowarea['id_area'];
            $idstation = $rowarea['id_station'];
            if ($area == 1) {
                if ($devise == 'mobile') {

                   include_once '../templates/mobile/taskprocessing.template.php';
                   echo renderMobileTaskDetails($dbh, $user_id, $area, $idstation, $sqlTask, $contenedorStyle, $calloutinfo);
 
                }else{
                                    
                    include_once '../templates/taskprocessing.template.php';
                    echo renderTaskDetails($dbh, $user_id, $area, $idstation, $sqlTask, $contenedorStyle, $calloutinfo);
                    
                }
    
            } else {
                if ($devise == 'mobile') {

                    include_once '../templates/mobile/taskprocessing_a.template.php';
                    echo renderTaskMobile($dbh, $user_id, $sqlTask, $area, $idstation, $contenedorStyle, $calloutinfo);
                
                }else{
                    
                    include_once '../templates/taskprocessing_a.template.php';
                    echo renderTask($dbh, $user_id, $sqlTask, $area, $idstation, $contenedorStyle, $calloutinfo);
                }
            }       
        }
    }
}
?>
