<?php
header('Content-Type: application/json');  // Asegura que la salida es de tipo JSON.

require_once '../classes/dbh.classes.php';


// Intento de conexión con PDO
try {
    $data = json_decode(file_get_contents("php://input"));
    if (!$data || !isset($data->image) || !isset($data->idJob) || !isset($data->idUser)) {
        throw new Exception("No se recibieron datos válidos.");
    }

    $image_parts = explode(";base64,", $data->image);
    if (count($image_parts) != 2) {
        throw new Exception("Formato de imagen inválido.");
    }
    $image_type_aux = explode("image/", $image_parts[0]);
    $image_type = $image_type_aux[1];
    if (!in_array($image_type, ['jpeg', 'png', 'gif'])) {
        throw new Exception("Tipo de imagen no soportado.");
    }
    $image_base64 = base64_decode($image_parts[1]);
    if ($image_base64 === false) {
        throw new Exception("Error al decodificar la imagen.");
    }

    $JobId = htmlspecialchars($data->idJob);
    $JobUser = htmlspecialchars($data->idUser);
    $folderPath = "../uploads/";
    if (!file_exists($folderPath)) {
        mkdir($folderPath, 0777, true);
    }
    $uniqueId = uniqid();
    $hashedId = md5($uniqueId);
    $base36Id = base_convert($hashedId, 16, 36);
    $sixChars = substr($base36Id, 0, 6);
    $image_file_name = 'img_' . $JobUser . $JobId . $sixChars . '.jpg';
    $file = $folderPath . $image_file_name;

    file_put_contents($file, $image_base64);

    $dbh = new Dbh();
    $pdo = $dbh->connect();
    $pdo->beginTransaction();
    $sql = "INSERT INTO images (user_id, id_project, image_path) VALUES ('$JobUser', '$JobId', :imagePath)";
    $stmtsaveimage = $pdo->prepare($sql);
    $stmtsaveimage->bindParam(':imagePath', $file);
    $stmtsaveimage->execute();
    $pdo->commit();

    echo json_encode(["success" => true, "message" => "Imagen guardada exitosamente", "por" => $JobUser, "Projecto" => $JobId, "path" => $file]);

} catch (Exception $e) {
    $pdo->rollBack();
    http_response_code(500);
    echo json_encode(["success" => false, "message" => "Error interno del servidor", "error" => $e->getMessage()]);
}
?>
