<?php 
require_once 'dbh.classes.php';
session_start();


class TaskExecute    {
    
     
    public $idproject;
         
    Public function setTaskStart() {
        $dbh = new Dbh(); 
        
        if(isset($_POST["process"])) {
            $idproject = $_POST["process"];
            if ($idproject != NULL ) {
                echo $idproject;
                echo "<br>";
                
                /*$sqlnumstation = ("SELECT station.id_station, station.id_area
                                    FROM station
                                    JOIN user_station ON station.id_station = user_station.id_station
                                    WHERE user_station.user_id = '$user_id'");
                $sqlnumstation = $dbh->connect()->prepare($sqlnumstation);
                $sqlnumstation->execute();    
                $rowstation = $sqlnumstation->fetchAll(PDO::FETCH_ASSOC);            
                $station = $rowstation[0]['id_station'];
                $taskarea = $rowstation[0]['id_area'];*/
                               
                $sqltaskini = ("SELECT id_project FROM project WHERE  id_project = '$idproject'");
                $sqltaskini = $dbh->connect()->prepare($sqltaskini);
                $sqltaskini->execute();
                $rowtaskini = $sqltaskini->fetchAll(PDO::FETCH_ASSOC);
                $taskini = $rowtaskini[0]['id_project'];
                if ($taskini != null) { 
                    echo $taskini;
                    $_SESSION['status'] = $taskini;
                }
               
            
            }
        }
    
    }
    
}
$update = new TaskExecute;
$update->setTaskStart();

?>