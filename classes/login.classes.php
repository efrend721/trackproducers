<?php 

    class Login extends Dbh {
        public $user_state;
        public $level_access;
        public $user;
                
        public function getUser($uid, $pwd) {
            $stmt = $this->connect()->prepare('SELECT user_id FROM user WHERE user_id = ?;')  ;
            if(!$stmt->execute(array($uid))) {
                $stmt = null ;
                header("location: ../index.php?error=stmtfailed");
                exit();
            }
            elseif ($stmt->rowCount() == 0) {
                $stmt = null ; 
                header("location: ../index.php?error=usernotfound");
                exit();
            }
            else {
                if ($stmt->rowCount() > 0) {
                   $stmt = $this->connect()->prepare('SELECT password FROM user WHERE user_id = ?;') ;
                    if(!$stmt->execute(array($pwd))) {
                        $stmt = null ;
                        header("location: ../index.php?error=stmtfailed");
                        exit();
                    }
                    else {
                    $row = $stmt->fetchAll(PDO::FETCH_ASSOC);            
                    $pwd1 = $row[0]['password'];
                        if($pwd1 != $pwd){
                            $stmt = null ; 
                            header("location: ../index.php?error=wrongpassword");
                            exit();
                        }
                        elseif($pwd1 == $pwd){
                            $stmt = $this->connect()->prepare('SELECT user_id, name_user, id_level_access, state FROM user WHERE user_id = ? AND password = ?;');
                            if(!$stmt->execute(array($uid, $pwd))) {
                                $stmt = null ;
                                $error1 = "erorrr" ;   
                                header("location: ../index.php?error=stmtfailed");
                                exit();
                            }
                            else {        
                                $user = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($user as $user) {
                                    
                                    $this->user_state = $user['state'];
                                    $this->level_access = $user['id_level_access'];
                                    $this->user = $user['name_user'];
                                    session_start();
                                    $_SESSION["user_id"] = $user['user_id'];
                                    $_SESSION["name_user"] = $user['name_user'];
                                    $_SESSION["id_level_access"] = $user['id_level_access'];
                                    $_SESSION["state"] = $user['state'];
                                    
                                }
                                if ($_SESSION["id_level_access"] == 1) {
                                    header("location: ../views/adminview.php");
                                }
                                elseif ($_SESSION["id_level_access"] == 2) {
                                     header("location: ../views/managerview.php");
                                }
                                elseif ($_SESSION["id_level_access"] >= 3) {
                                     $stmtinsert = $this->connect()->prepare("INSERT INTO user_log (user_id, date_start, time_start, date_finish, time_finish ) VALUES ({$user['user_id']}, CURDATE(), CURTIME(), CURDATE(), CURTIME());");
                                     $stmtinsert->execute();
                                     header("location: ../views/operatorview.php");
                                } 
                            }
                        }
                    }        

                }
        
            }    
        $stmt = null ;
    }
}
?>       
    