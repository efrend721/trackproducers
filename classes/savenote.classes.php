<?php 
require_once 'dbh.classes.php';
session_start();

class saveNote {

    public function setSaveNote () {
        $dbh = new Dbh(); 
        $user_id = $_SESSION['user_id'];
        $idnote = $_POST["comment"];
        $extra = $_POST["extracomment"];
        $idjob = $_POST["submit"];
        
        $stmtKnowDriver = $dbh->connect()->prepare("SELECT user_id FROM assigneddeliveries WHERE user_id = '$user_id'");
        $stmtKnowDriver->execute();
        $rowKnowDriver = $stmtKnowDriver->fetch(PDO::FETCH_ASSOC);
        $driver = $rowKnowDriver['user_id']; 


        $_SESSION['idjobFromSaveNote'] = $idjob;
       

        if (empty($idnote)  && empty($extra)) {
            $sql = "DELETE FROM images WHERE user_id = '$user_id' AND id_project = '$idjob'";
            $stmtDeleteImgTmp = $dbh->connect()->prepare($sql);
            $stmtDeleteImgTmp->execute();
            $stmtDeleteImgTmp = null;
            $_SESSION['status'] = "Note and Extra comment not set";
            if ($driver == $user_id) {
                header ("location: ../views/mydeliveries.php");
                exit();
            }
            else {
                header ("location: ../views/projectlistdetailview.php");
                exit();
            }
            

        }
        elseif (empty($idnote) && !empty($extra)) {
                
                $stmtFile = $dbh->connect()->prepare("SELECT image_path FROM images WHERE user_id = '$user_id' AND id_project = '$idjob' ");
                $stmtFile->execute();
                $files = $stmtFile->fetchAll(PDO::FETCH_ASSOC);
                
                if (empty($files)){
                    $fileDir = "";
                    $sqlAddnote = ("INSERT INTO notes (id_project, user_id, id_note, additional_note, photo, date_note)
                                    VALUES ('$idjob', '$user_id', '99', '$extra', '$fileDir', CURDATE())");
                    $stmtAddnote = $dbh->connect()->prepare($sqlAddnote);
                    $stmtAddnote->execute();
                    $stmtAddnote = null;
                    $_SESSION['status'] = "Note saved successfully";
                    if ($driver == $user_id) {
                        header ("location: ../views/mydeliveries.php");
                        exit();
                    }
                    else {
                        header ("location: ../views/projectlistdetailview.php");
                        exit();
                    }
                    
                }
                else {
                    foreach ($files as $file) {
                        $fileDir = $file['image_path'];
                        $sqlAddnote = ("INSERT INTO notes (id_project, user_id, id_note, additional_note, photo, date_note)
                                        VALUES ('$idjob', '$user_id', '99', '$extra', '$fileDir', CURDATE())");
                        $stmtAddnote = $dbh->connect()->prepare($sqlAddnote);
                        $stmtAddnote->execute();
                        $stmtAddnote = null;
    
                    }
                    $sql = "DELETE FROM images WHERE user_id = '$user_id' AND id_project = '$idjob'";
                    $stmtDeleteImgTmp = $dbh->connect()->prepare($sql);
                    $stmtDeleteImgTmp->execute();
                    $stmtDeleteImgTmp = null;
                    $_SESSION['status'] = "Note saved successfully";
                    if ($driver == $user_id) {
                        header ("location: ../views/mydeliveries.php");
                        exit();
                    }
                    else {
                        header ("location: ../views/projectlistdetailview.php");
                        exit();
                    }
                    
                }    
        }    
        else {
            
            $stmtFile = $dbh->connect()->prepare("SELECT image_path FROM images WHERE user_id = '$user_id' AND id_project = '$idjob' ");
            $stmtFile->execute();
            $files = $stmtFile->fetchAll(PDO::FETCH_ASSOC);
            if (empty($files)){
                $fileDir = "";
                $sqlAddnote = ("INSERT INTO notes (id_project, user_id, id_note, additional_note, photo, date_note)
                                VALUES ('$idjob', '$user_id', '$idnote', '$extra', '$fileDir', CURDATE())");
                $stmtAddnote = $dbh->connect()->prepare($sqlAddnote);
                $stmtAddnote->execute();
                $stmtAddnote = null;
                $_SESSION['status'] = "Note saved successfully";
                if ($driver == $user_id) {
                    header ("location: ../views/mydeliveries.php");
                    exit();
                }
                else {
                    header ("location: ../views/projectlistdetailview.php");
                    exit();
                }
            }
            else {
                foreach ($files as $file) {
                    $fileDir = $file['image_path'];
                    $sqlAddnote = ("INSERT INTO notes (id_project, user_id, id_note, additional_note, photo, date_note)
                                    VALUES ('$idjob', '$user_id', '$idnote', '$extra', '$fileDir', CURDATE())");
                    $stmtAddnote = $dbh->connect()->prepare($sqlAddnote);
                    $stmtAddnote->execute();
                    $stmtAddnote = null;

                }
                $sql = "DELETE FROM images WHERE user_id = '$user_id' AND id_project = '$idjob'";
                $stmtDeleteImgTmp = $dbh->connect()->prepare($sql);
                $stmtDeleteImgTmp->execute();
                $stmtDeleteImgTmp = null;
                $_SESSION['status'] = "Note saved successfully";
                if ($driver == $user_id) {
                    header ("location: ../views/mydeliveries.php");
                    exit();
                }
                else {
                    header ("location: ../views/projectlistdetailview.php");
                    exit();
                }
            }    
        }
    }
}
$savenote = new saveNote();
$savenote->setSaveNote();
?>