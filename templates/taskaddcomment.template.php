<?php 
$addcomment = filter_input(INPUT_POST, 'addcomment', FILTER_VALIDATE_INT);
$options = [5, 10, 15, 20, 25, 30, 45, 60];

// Generar opciones de tiempo
function generateTimeOptions($options) {
    $html = '';
    foreach ($options as $value) {
        $html .= "<option value='$value'>$value</option>\n";
    }
    return $html;
}

// Obtener opciones de comentarios desde la base de datos
function fetchCommentOptions($dbh) {
    $html = '';
    $stmtComment = $dbh->connect()->prepare('SELECT id_comment, nm_comment FROM comment');
    $stmtComment->execute();
    $RowComment = $stmtComment->fetchAll(PDO::FETCH_ASSOC);
    foreach ($RowComment as $Row) {
        $html .= "<option value='{$Row['id_comment']}'>{$Row['nm_comment']}</option>\n";
    }
    return $html;
}

$timeOptions = generateTimeOptions($options);
$commentOptions = fetchCommentOptions($dbh);

echo <<<HTML
<form action="../classes/addcomment.classes.php" method="POST">
    <div class="card">
        <div class="card-header">
            <span><i class="bi bi-table me-2"></i></span>Project $addcomment
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="shadow row mb-2 p-2 bg-dark border rounded-3 text-white">
                        <label for="elapsedtime">Time</label>
                        <select name="elapsedtime" id="elapsedtime" class="form-select" aria-label="Default select example">
                            <option></option>
                            $timeOptions
                        </select>
                    </div>
                </div>
                <div class="col-md-8 mb-4">
                    <div class="shadow row mb-2 p-2 bg-dark border rounded-3 text-white">
                        <label for="comment">Comment</label>
                        <select name="comment" id="comment" class="form-select" aria-label="Default select example">
                            <option></option>
                            $commentOptions
                        </select>
                    </div>
                </div>
            </div>    
        </div>
    </div>
    <br>
    <div class="card">
        <div class="card-body">
            <div class="row">
                <div class="col-8 d-flex justify-content-end">
                    <a href="../views/operatortaskview.php" class="btn btn-primary">Cancel</a>
                </div>
                <div class="col-4 d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary" name="idproject" value="$addcomment">Add Comment</button>
                </div>
            </div>    
        </div>
    </div>
    <br>
</form>
HTML;
?>
