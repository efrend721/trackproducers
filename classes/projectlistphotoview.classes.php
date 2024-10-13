<?php
require_once 'dbh.classes.php';

class ProjectListPhoto {
    public function getProjectListPhoto() {
        $dbh = new Dbh();
        include_once '../includes/serverside.rendering.php';
        include_once '../queries/projectlist.query.php';
        $idjob = $_POST['idjobViewphoto'];
        $photoview = $_POST['photoview'];
        $user_id = $_SESSION['user_id'];
        $stmtKnowDriver = $dbh->connect()->prepare("SELECT user_id FROM assigneddeliveries WHERE user_id = '$user_id'");
        $stmtKnowDriver->execute();
        $rowKnowDriver = $stmtKnowDriver->fetch(PDO::FETCH_ASSOC);
        if ($rowKnowDriver == false) {
            $driver = 0;
        } else {
            $driver = $rowKnowDriver['user_id'];
        }

        ob_start(); // Start output buffering

        echo <<<HTML
        <main class='mt-5 pt-3'>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-md-12'>
        HTML;

        if ($devise == 'mobile') {
            include_once '../templates/mobile/carddetailproject.template.php';
        } else {
            include_once '../templates/carddetailproject.template.php';
        }

        echo <<<HTML
                <br>
                    <form action='../views/projectlistdetailview.php' method='POST'>
                        <div class='card'>
                            <div class='card-header'>
                                <span><i class='bi bi-table me-2'></i></span>Photo View 
                            </div>
                            <div class='card-body'>
                                <img src='$photoview' style='max-width: 100%; height: auto;'> 
                            </div>
                        </div>
                        <br>
                        <div class='card'>
                            <div class='card-body'> 
                                <div class='d-flex justify-content-end'>
                                    <button class='btn btn-primary' name='process' value='$idjob' type='submit'>Back</button>
                                </div>
                            </div>
                        </div>
                        <br>         
                        </form>    
                    </div>
                </div>
            </div>
        </main>
        HTML;

        $output = ob_get_clean(); // Get the output buffer content and clean the buffer
        echo $output; // Echo the final output
    }
}
?>
