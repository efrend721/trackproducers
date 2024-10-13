<?php 
require_once 'dbh.classes.php';
session_start();


class PriorityUpdate    {
 
 
    Public function setPrioritySingle() {
        $dbh = new Dbh(); 
        
        if(isset($_POST["driver"])) {
            $driver = $_POST["driver"];
                if($driver == NULL) {
                    $_SESSION['status'] = "A driver has not been selected";
                    header("location: ../views/deliveryassignments.php");
                    exit();
                } else {
                    if(!empty($_POST["check_list"])){
                       $id_project = $_POST["check_list"];
                        foreach($_POST["check_list"] as $id_project){
                            $sqlinsertgroup = "INSERT INTO assigneddeliveries (user_id, id_project) VALUES ('$driver', '$id_project' )";
                            $stmtinsertgroup = $dbh->connect()->prepare($sqlinsertgroup);
                            $stmtinsertgroup->execute();
                            echo $driver;
                            echo "<br>";
                            echo $id_project;
                            var_dump($id_project);
                            echo "<br>";
                            var_dump($driver);
                            echo "<br>";
                            var_dump($sqlinsertgroup);
                        }
                        if($sqlinsertgroup){
                            $_SESSION['status'] = "Deliveries Assigned Successfully";
                            $stmtinsertgroup = null;
                            header("location: ../views/deliveryassignments.php");
                            exit();     
                        }
                        else{
                            $_SESSION['status'] = "Error: Deliveries Not Assigned";
                            $sqlinsertgroup = null;
                            var_dump($id_project);
                            echo "<br>";
                            var_dump($driver);
                            //header("location: ../views/deliveryassignments.php");
                            exit(); 
                        }
                    }                                           
                    else {
                        $_SESSION['status'] = "Select at least one project.";
                        header("location: ../views/deliveryassignments.php");
                    }    
                        
                }

                }  

            }
        }

$update = new PriorityUpdate;
$update->setPrioritySingle();

?>