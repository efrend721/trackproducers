<?php

session_start();

// Incluir los archivos necesarios
include_once '../classes/dbh.classes.php';

// Asumiendo que tienes el user_id almacenado en la sesión
$user_id = $_SESSION['user_id']; // Asegúrate de que esta variable existe y es correcta

// Crear instancia de Dbh y realizar el query de actualización
$dbh = new Dbh();
$conn = $dbh->connect(); // Asumiendo que este método existe y devuelve una conexión PDO

$stmtupdate = $conn->prepare("UPDATE user_log SET date_finish = CURDATE(), time_finish = CURTIME() WHERE user_id = '$user_id' AND date_start = CURDATE()");
$stmtupdate->execute();
var_dump($stmtupdate);
// Cerrar la sesión
$_SESSION = array();  // Limpiar las variables de sesión
// Eliminar la cookie de sesión
if (ini_get("session.use_cookies")) {  // Check if session uses cookies
    $params = session_get_cookie_params();  // Get session cookie parameters
    setcookie(session_name(), '', time() - 42000,  // Set the cookie to expire in the past
        $params["path"], 
        $params["domain"],
        $params["secure"], 
        $params["httponly"]
    );
}
session_unset();
session_destroy();

header("Location: ../index.php");

?>