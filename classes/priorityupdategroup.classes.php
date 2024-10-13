<?php 
require_once 'dbh.classes.php';
session_start();

 

class PriorityUpdate    {

    public $idproject;
    public $priority ;
 
    Public function setPrioritySingle() {
        $dbh = new Dbh(); 
        
        if(isset($_POST["priority"])) {
            $priority = $_POST["priority"];
                if($priority == NULL) {
                    $_SESSION['status'] = "No priority has been selected";
                    header("location: ../views/prioritygroupview.php");
                } else {
                    if(!empty($_POST["check_list"])){
                        //$checked_count = count($_POST["check_list"]);
                        $id_project = $_POST["check_list"];
                        foreach($_POST["check_list"] as $id_project){
                            $sqlupdategroup = ("UPDATE project SET id_priority = '$priority' WHERE id_project = $id_project");
                            $stmtupdategroup = $dbh->connect()->prepare($sqlupdategroup);
                            $stmtupdategroup->execute();
                        }
                        if($stmtupdategroup){
                            $_SESSION['status'] = "Priority updated successfully";
                            $stmtupdategroup = null;
                            header("location: ../views/prioritygroupview.php");
                            exit();     
                        }
                        else{
                            $_SESSION['status'] = "Priority not updated";
                            $stmtupdategroup = null;
                            header("location: ../views/prioritygroupview.php");
                            exit(); 
                        }
                    }                                           
                    else {
                        $_SESSION['status'] = "Select at least one project";
                        header("location: ../views/prioritygroupview.php");
                    }    
                        
                }

                }  

            }
        }

$update = new PriorityUpdate;
$update->setPrioritySingle();

?>