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
                            <th width='30%'>Select</th>
                            <th width='50%'>Address</th>
                            <th width='20%'>Priority</th>
                        </tr>
                    </thead>
                    <tbody>
HTML;

$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
foreach ($results as $result) {
    echo <<<HTML
                        <tr>
                            <td width='30%'>
                                <div class='form-check'>
                                    <input name='check_list[]' class='form-check-input' type='checkbox' value='$result[id_project]' >
                                </div>
                            </td> 
                            <td width='50%'>$result[address]</td>
                            <td width='20%'>$result[nm_priority]</td>
                        </tr>
HTML;
}

echo <<<HTML
                    </tbody>
                    <tfoot>
                        <tr>
                            <td>
                                <div class='d-flex justify-content-between align-items-center'>
HTML;

echo "<select name='priority' id='priority' class='form-select w-100' aria-label='Default select example'>
        <option></option>";
$stmt3 = $dbh->connect()->prepare('SELECT id_priority, nm_priority FROM priority ');
$stmt3->execute();
$ResultProject1 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
foreach ($ResultProject1 as $ResultProject1) {
    echo "<option value = {$ResultProject1['id_priority']}>{$ResultProject1['nm_priority']}</option>";
}
echo "</select></div></td>";

echo <<<HTML
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
