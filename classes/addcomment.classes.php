<?php 
require_once 'dbh.classes.php';
session_start();

/*foreach ($_POST as $key => $value) {
    echo "<strong>$key</strong>: ";
    var_dump($value);
    echo "<br>";
    echo "<br>";
}*/


class AddComment    {
    
   
    
    public $idproject;
    public $comment ;
    public $elapsedtime;
    
     
    Public function setComment() {
        $user_id = $_SESSION['user_id'];
        $dbh = new Dbh();
        $stmtarea = $dbh->connect()->prepare("SELECT user_station.id_station  
                                              FROM user
                                              INNER JOIN user_station ON user.user_id = user_station.user_id
                                              INNER JOIN station ON station.id_station = user_station.id_station
                                              WHERE user_station.user_id = '$user_id'");
        $stmtarea->execute();
        $rowarea = $stmtarea->fetchAll(PDO::FETCH_ASSOC);            
        $idstation = $rowarea[0]['id_station'];

        if(isset($_POST["idproject"]) && isset($_POST["comment"]) && isset($_POST["elapsedtime"])) {
            $idproject = $_POST["idproject"];
            $id_comment = $_POST["comment"];
            $elapsedtime = $_POST["elapsedtime"];
            if ($elapsedtime == NULL && $id_comment == NULL) {
                $_SESSION['status'] = "Invalid input";
                header("location: ../views/operatortaskview.php");
                exit();
            }
            elseif($id_comment == NULL) {
                $_SESSION['status'] = "No comment selected";
                header("location: ../views/operatortaskview.php");
                exit(); 
            }
            elseif ($elapsedtime == NULL){
                $_SESSION['status'] = "No elapsed time selected";
                header("location: ../views/operatortaskview.php");
                exit();
            }
            else {
                $stmtQueryStateProject = $dbh->connect()->prepare("SELECT id_status_project 
                                                                   FROM state_project 
                                                                   WHERE id_project = $idproject group by id_status_project");    
                $stmtQueryStateProject->execute();
                $rowQueryStateProject = $stmtQueryStateProject->fetchAll(PDO::FETCH_ASSOC);
                $idStatusProject = $rowQueryStateProject[0]['id_status_project'];
                if ($idStatusProject == 0) {
                    $idStatusProject = 1;
                    $stmtAddComment = $dbh->connect()->prepare("UPDATE state_project SET id_status_project = '$idStatusProject', user_id = '$user_id', id_station = '$idstation',  id_comment = '$id_comment', date_comment = CURDATE(), time_comment = CURTIME(), elapsed_time  = '$elapsedtime' 
                                                                WHERE id_project = '$idproject'"); 
                                                          
                    $stmtAddComment->execute();
                                      

                    if($stmtAddComment){
                        $_SESSION['status'] = "Comment added successfully";
                        $stmtAddComment = null;
                        header("location: ../views/operatortaskview.php");
                        exit();     
                    }
                    else{
                        $_SESSION['status'] = "Comment not added";
                        $stmtAddComment = null;
                        header("location: ../views/operatortaskview.php");
                        exit(); 
                    }

                }
                else {
                    $stmtQueryStateProject = $dbh->connect()->prepare("SELECT COUNT(*) AS num FROM `state_project` WHERE id_comment = '0' and id_project = $idproject"); 
                    $stmtQueryStateProject->execute();
                    $rowQueryStateProject = $stmtQueryStateProject->fetchAll(PDO::FETCH_ASSOC);
                    $Num = $rowQueryStateProject[0]['num'];
                    //echo $Num;    
                    if ($Num == 1){
                        $stmtAddComment = $dbh->connect()->prepare("UPDATE state_project SET id_status_project = '$idStatusProject', user_id = '$user_id', id_station = '$idstation',  id_comment = '$id_comment', date_comment = CURDATE(), time_comment = CURTIME(), elapsed_time  = '$elapsedtime' 
                                                                WHERE id_project = '$idproject'"); 
                        $stmtAddComment->execute();
                        if($stmtAddComment){
                            $_SESSION['status'] = "Comment added successfully";
                            $stmtAddComment = null;
                            header("location: ../views/operatortaskview.php");
                            exit();     
                        }
                        else{
                            $_SESSION['status'] = "Comment not added";
                            $stmtAddComment = null;
                            header("location: ../views/operatortaskview.php");
                            exit(); 
                        }

                    }
                    else{
                       $stmtAddComment = $dbh->connect()->prepare("INSERT INTO state_project (id_project, id_status_project, user_id, id_station,  id_comment, date_comment, time_comment, elapsed_time) 
                                                                VALUES ('$idproject', '$idStatusProject', '$user_id', '$idstation', '$id_comment', CURDATE(), CURTIME(), '$elapsedtime')");
                        $stmtAddComment->execute();
                        if($stmtAddComment){
                            $_SESSION['status'] = "Comment added successfully";
                            $stmtAddComment = null;
                            header("location: ../views/operatortaskview.php");
                            exit();     
                        }
                        else{
                            $_SESSION['status'] = "Comment not added";
                            $stmtAddComment = null;
                            header("location: ../views/operatortaskview.php");
                            exit(); 
                        }    
                    }
                  
                }
            }
        } 
        else {
            $_SESSION['status'] = "Invalid input";
            header("location: ../views/operatortaskview.php");
            exit();
        }
    }
    
}
    

$addcomment = new AddComment;
$addcomment->setComment();

?>