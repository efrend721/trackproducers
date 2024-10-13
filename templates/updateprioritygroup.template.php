<?php
echo <<<HTML
<div class='card'>
    <div class='card-header'>
        <span><i class='bi bi-table me-2'></i></span> Projects
    </div>
    <div class='card-body'>
        <div class='table-responsive'>
        <form method='POST' action='../classes/priorityupdategroup.classes.php'>    
        <table class='table table-striped'>
                <thead>
                    <tr>
                        <th>Select</th>
                        <th>Id</th>
                        <th>Priority</th>
                        <th>Date</th>
                        <th>Address</th>
                        <th>Piece</th>
                        <th>Status</th>
                    </tr>
                </thead>
            <tbody>
HTML;

$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
echo <<<HTML
            <tr>
            <td>
                <div class='form-check'>
                        <input name='check_list[]' class='form-check-input' type='checkbox' value='{$result['id_project']}' >
                </div>
            </td> 
            <td>{$result['id_project']}</td>
            <td>{$result['nm_priority']}</td>
            <td>{$result['date']}</td>
            <td>{$result['address']}</td>
            <td>{$result['piece']}</td>
            <td>{$result['nm_status_project']}</td>
            </tr>
HTML;
}

echo <<<HTML
            </tbody>
            <tfoot>
                <tr>
                    <td>
                        <div class='d-flex justify-content-between align-items-center'>
                            <select name='priority' id='priority' class='form-select w-100' aria-label='Default select example'>
                                <option></option>
HTML;

$stmt3 = $dbh->connect()->prepare('SELECT id_priority, nm_priority FROM priority');
$stmt3->execute();
$ResultProject1 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
foreach ($ResultProject1 as $ResultProject1) {
echo <<<HTML
                                <option value="{$ResultProject1['id_priority']}">{$ResultProject1['nm_priority']}</option>
HTML;
}

echo <<<HTML
                            </select>
                        </div>
                    </td>
                    <td><button type='submit' name='update' class='btn btn-primary'>Update</button></td>
                </tr>
            </tfoot>
        </table>
        </form> 
        </div>
    </div>
</div>
HTML;

?>
