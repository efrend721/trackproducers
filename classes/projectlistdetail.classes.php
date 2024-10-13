<?php 
require_once 'dbh.classes.php';
class ProjectListDetail
{
    public function getProjectListDetail()
    {
        $dbh = new Dbh();
        include_once '../includes/serverside.rendering.php';
        include_once '../queries/projectlist.query.php';
        
        if (isset($_POST['process'])) {
            $idjob = $_POST['process'];
            $_SESSION['process'] = $idjob;
            

        }
        else {
             if (isset($_SESSION['idjobFromSaveNote'])) {
                 $idjob = $_SESSION['idjobFromSaveNote'];
             }
        }
                       
        $user_id = $_SESSION['user_id'];
        $stmtKnowDriver = $dbh->connect()->prepare("SELECT user_id FROM assigneddeliveries WHERE user_id = '$user_id'");
        $stmtKnowDriver->execute();
        $rowKnowDriver = $stmtKnowDriver->fetch(PDO::FETCH_ASSOC);
        if ($rowKnowDriver == false) {
            $driver = 0;
        } else {
        $driver = $rowKnowDriver['user_id']; 
        }

        $calloutinfo = "border-left: 5px solid #17a2b8; background-color: #e9ecef; padding: 10px;  margin: 10px 0;";
        $calloutwarnig = "border-left: 5px solid #ffc107; background-color: #e9ecef; padding: 10px; margin: 10px 0;  color: #856404;";
        $calloutsuccess = "border-left: 5px solid #28a745; background-color: #e9ecef; padding: 10px;  margin: 10px 0; color: #155724;";
        $stylelogh5 = "font-size: 12px; line-height: 0.8; font-weight: 400; color: #17a2b8; ";
        $stylelog = "font-size: 12px; line-height: 0.8; font-weight: 400; color: #495057;";
        $stylelogphoto = "font-size: 12px; line-height: 0.8; font-weight: 400; color: #495057; text-decoration: none; ";
        echo "<main class='mt-5 pt-3'>
                    <div class='container-fluid'>
                        <div class='row'>
                            <div class='col-md-12'>";
                                                               

                                require_once ('../includes/mensages.php');
                                
                                if ($devise == 'mobile') {

                                    include_once '../templates/mobile/carddetailproject.template.php';
                                
                                }else{
                                    
                                    include_once '../templates/carddetailproject.template.php';
                                }
                                                                
                                include_once '../templates/cardstatusprojectlist.template.php';
                                
                                include_once '../templates/cardlogsprojectlist.template.php';
                                
                            echo "                            
                            </div>
                            </div>
                        </div>
                    </div> 
            </main>\n";
           
            
    }
}

?>