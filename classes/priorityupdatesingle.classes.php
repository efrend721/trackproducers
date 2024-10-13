<?php 
require_once 'dbh.classes.php';
session_start();


class PriorityUpdate    {
    
   
    
    public $idproject;
    public $priority ;
    
     
    Public function setPrioritySingle() {
        $dbh = new Dbh(); 
        
        if(isset($_POST["idproject"]) && isset($_POST["priority"])) {
            $idproject = $_POST["idproject"];
            $priority = $_POST["priority"];
            if ($priority != NULL ) {
                echo $idproject;
                echo "<br>";
                echo $priority;
            
            //var_dump($priority) ;
            $sqlupdate = ("UPDATE project SET id_priority = '$priority' WHERE id_project = $idproject");
            $stmtupdate = $dbh->connect()->prepare($sqlupdate);
            $stmtupdate->execute();
            if($stmtupdate){
                $_SESSION['status'] = "Priority updated successfully";
                $stmtupdate = null;
                header("location: ../views/priorityview.php");
                exit();     
                
            }
            else{
                $_SESSION['status'] = "Priority not updated";
                $stmtupdate = null;
                header("location: ../views/priorityview.php");
                exit(); 
            }

            $stmtupdate = null;
            header("location: ../views/priorityview.php");
            exit(); 
            }
            else {
                $_SESSION['status'] = "No priority selected";
                header("location: ../views/priorityview.php");
                exit();

            }
        }
    
    }
    
}
$update = new PriorityUpdate;
$update->setPrioritySingle();

?>