<?php 
require_once 'dbh.classes.php';
session_start();


class TaskExecute    {
    
     
    public $idproject;
         
    Public function setTaskStart() {
        $dbh = new Dbh(); 
        $user_id = $_SESSION['user_id'];
        $stmtKnowDriver = $dbh->connect()->prepare("SELECT user_id FROM assigneddeliveries WHERE user_id = '$user_id'");
        $stmtKnowDriver->execute();
        $rowKnowDriver = $stmtKnowDriver->fetch(PDO::FETCH_ASSOC);
        if ($rowKnowDriver == false) {
            $driver = 0;
        } else {
        $driver = $rowKnowDriver['user_id']; 
        }

        if(isset($_POST["process"])) {
            $idproject = $_POST["process"];
            if ($idproject != NULL ) {
                echo $idproject;
                echo "<br>";
                echo $user_id;
                $sqlnumstation = ("SELECT station.id_station, station.id_area
                                    FROM station
                                    JOIN user_station ON station.id_station = user_station.id_station
                                    WHERE user_station.user_id = '$user_id'");
                $sqlnumstation = $dbh->connect()->prepare($sqlnumstation);
                $sqlnumstation->execute();    
                $rowstation = $sqlnumstation->fetchAll(PDO::FETCH_ASSOC);            
                $station = $rowstation[0]['id_station'];
                $taskarea = $rowstation[0]['id_area'];
                               
                $sqltaskini = ("SELECT id_project FROM task WHERE id_station = '$station' AND id_project = '$idproject'");
                $sqltaskini = $dbh->connect()->prepare($sqltaskini);
                $sqltaskini->execute();
                if($sqltaskini->rowCount() > 0) {
                    echo "tarea se esta procesando ya en esta estacion" ;
                    $sqltask = ("UPDATE task SET date_finish = CURDATE(), time_finish = CURTIME(),  id_status_station = 2  WHERE id_project = '$idproject' AND id_station = '$station'");
                    $sqltask = $dbh->connect()->prepare($sqltask);
                    $sqltask->execute();
                    if($sqltask){
                        $sqltask = null;
                        if ($driver == $user_id) {
                            
                            header("location: ../views/mydeliveries.php");    
                        }
                        else {
                            header("location: ../views/operatortaskview.php");   
                        }
                        exit();     
                    }
                }
                else {
                     if($taskarea == 1){
                        $sqltaskstate = ("SELECT id_status_project FROM state_project WHERE id_project = '$idproject' GROUP BY id_status_project");
                        $sqltaskstate = $dbh->connect()->prepare($sqltaskstate);
                        $sqltaskstate->execute();
                        $rowtaskstate = $sqltaskstate->fetchAll(PDO::FETCH_ASSOC);
                        $projectstate = $rowtaskstate[0]['id_status_project'];
                        if ($projectstate == 0){
                            $sqlprojectstate = ("UPDATE state_project SET id_status_project = 1, user_id = '$user_id', id_station = '$station'   WHERE id_project = '$idproject'");
                            $sqlprojectstate = $dbh->connect()->prepare($sqlprojectstate);
                            $sqlprojectstate->execute();
                            $sqltask = ("INSERT INTO task (id_project, date_start, time_start, date_finish, time_finish, id_station, id_area, id_status_station, no_workers, no_machines, id_unit, id_activity)
                            VALUES ('$idproject', CURDATE(), CURTIME(), CURDATE(), CURTIME(), '$station', '$taskarea', 1, 1, 1, 1, 'c1')");
                            $sqltask = $dbh->connect()->prepare($sqltask);
                            $sqltask->execute();
                            if($sqltask){
                                echo "tarea inicializada" ;
                                
                                $sqltask = null;
                                if ($driver == $user_id) {
                                    header("location: ../views/mydeliveries.php");    
                                }
                                else {
                                    header("location: ../views/operatortaskview.php");   
                                }
                                exit();     

                        }    
                     }
                     }
                     else {
                            $sqltask = ("INSERT INTO task (id_project, date_start, time_start, date_finish, time_finish, id_station, id_area, id_status_station, no_workers, no_machines, id_unit, id_activity)
                                        VALUES ('$idproject', CURDATE(), CURTIME(), CURDATE(), CURTIME(), '$station', '$taskarea', 1, 1, 1, 1, 'c1')");
                            $sqltask = $dbh->connect()->prepare($sqltask);
                            $sqltask->execute();
                            if($sqltask){
                                echo "tarea inicializada" ;
                                $sqltask = null;
                                if ($driver == $user_id) {
                                    header("location: ../views/mydeliveries.php");    
                                }
                                else {
                                    header("location: ../views/operatortaskview.php");   
                                }
                                exit();     
                            }
                    }

                }
            }
        }
    
    }
    
}
$update = new TaskExecute;
$update->setTaskStart();

?>