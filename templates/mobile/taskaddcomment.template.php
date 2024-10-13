<?php 
$addcomment = filter_input(INPUT_POST, 'addcomment', FILTER_VALIDATE_INT);
echo "<form action='../classes/addcomment.classes.php' method='POST'>";
echo "<div class='card'>
        <div class='card-header'>
            <span><i class='bi bi-table me-2'></i></span>Project $addcomment
        </div>
        <div class='card-body'>
            <div class='row'>
                <div class='col-md-4 mb-4'>
                    <div class='shadow row mb-2 p-2 bg-dark border rounded-3 text-white'>
                        <label name='elapsedtime' id='elapsedtime' for='elapsedtime'>Time</label>
                        <select name='elapsedtime' id='elapsedtime' class='form-select' aria-label='Default select example'>
                            <option></option>
                            <option value='5'>5</option>
                            <option value='10'>10</option>
                            <option value='15'>15</option>
                            <option value='20'>20</option>
                            <option value='25'>25</option>
                            <option value='30'>30</option>
                            <option value='45'>45</option>
                            <option value='60'>60</option>
                        </select>
                    </div>
                </div>
                <div class='col-md-8 mb-4'>
                    <div class='shadow row mb-2 p-2 bg-dark border rounded-3 text-white'>
                        <label name='commnet' id='comment' for='comment'>Comment</label>
                        <select name='comment' id='comment' class='form-select' aria-label='Default select example'>
                            <option></option>";
                            $stmtComment = $dbh->connect()->prepare('SELECT id_comment, nm_comment FROM comment');
                            $stmtComment->execute();
                            $RowComment = $stmtComment->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($RowComment as $RowComment) {
                                echo "<option value='{$RowComment['id_comment']}'>{$RowComment['nm_comment']}</option>";
                            }
                        echo "</select>
                    </div>
                </div>
            </div>    
        </div>
    </div><br>";
echo "<div class='card'>
        <div class='card-body'>
            <div class='row'>
                <div class='col-8 d-flex justify-content-end'>
                    <a href='../views/operatortaskview.php' class='btn btn-primary'>Cancel</a>
                </div>
                <div class='col-4 d-flex justify-content-end'>
                    <button type='submit' class='btn btn-primary' name='idproject' value='$addcomment'>Add Comment</button>
                </div>
            </div>    
        </div>
    </div><br>
</form>"; 
?>