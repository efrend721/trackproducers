<?php 

if(isset($_POST["submit"])) {
    
    $uid = $_POST["uid"];
    $pwd = $_POST["pwd"];
    
    include '../classes/dbh.classes.php';
    include '../classes/login.classes.php';
    include '../classes/logincontr.classes.php';
    
    $login = new LoginContr($uid, $pwd);
    $login->loginUser();
    
}
else {
    header("location: ../index.php?error=none");
    
    exit();
}
?>
