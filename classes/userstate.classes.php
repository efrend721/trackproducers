<?php 
    class UserState {
    public function getState($user_state, $level_access, $name_user, $user, $user_id) {
            if ($user_state == 0) {
                $stmt = null;
                header("location: ../index.php?error=usernotactive");
                exit();
            } else {
                if ($level_access == 1) {
                    session_start();
                    $_SESSION["user_id"] = $user[0]['user_id'];
                    $_SESSION["name_user"] = $user[0]['name_user'];
                    $_SESSION["id_level_access"] = $user[0]['id_level_access'];
                    $_SESSION["state"] = $user[0]['state'];
                    header("location: ../views/adminview.php");
                }
                elseif ($level_access == 2) {
                    session_start();
                    $_SESSION["user_id"] = $user[0]['user_id'];
                    $_SESSION["name_user"] = $user[0]['name_user'];
                    $_SESSION["id_level_access"] = $user[0]['id_level_access'];
                    $_SESSION["state"] = $user[0]['state'];
                    header("location: ../views/managerview.php");
                }
                elseif ($level_access == 3) {
                    session_start();
                    $_SESSION["user_id"] = $user[0]['user_id'];
                    $_SESSION["name_user"] = $user[0]['name_user'];
                    $_SESSION["id_level_access"] = $user[0]['id_level_access'];
                    $_SESSION["state"] = $user[0]['state'];
                    header("location: ../views/operatorview.php");
                }
        }
    }
}