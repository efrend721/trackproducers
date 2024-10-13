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
                    header("location: ../views/deliveryredispatchview.php");
                    exit();
                } else {
                    if(!empty($_POST["check_list"])){
                       $id_project = $_POST["check_list"];
                        foreach($_POST["check_list"] as $id_project){
                            $sqlupdategroup = ("UPDATE assigneddeliveries SET user_id = '$driver' where id_project = '$id_project'");
                            $stmtupdategroup = $dbh->connect()->prepare($sqlupdategroup);
                            $stmtupdategroup->execute();
                        }
                        if($stmtupdategroup){
                            $_SESSION['status'] = "Deliveries Assigned Successfully";
                            $stmtupdategroup = null;
                            header("location: ../views/deliveryredispatchview.php");
                            exit();     
                        }
                        else{
                            $_SESSION['status'] = "Error: Deliveries Not Assigned";
                            $stmtupdategroup = null;
                            header("location: ../views/deliveryredispatchview.php");
                            exit(); 
                        }
                    }                                           
                    else {
                        $_SESSION['status'] = "Select at least one project.";
                        header("location: ../views/deliveryredispatchview.php");
                    }    
                        
                }

                }  

            }
        }

$update = new PriorityUpdate;
$update->setPrioritySingle();

?>