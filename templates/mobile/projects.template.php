<?php 
echo <<<HTML
<form action='' method='POST'>
    <div class='card'>
        <div class='card-header'>
            <span><i class='bi bi-table me-2'></i></span> Projects version $devise
        </div>
        <div class='card-body'>
            <div class='table-responsive'>
                <table class='table table-striped'>
                    <thead>
                        <tr>
                            <th>Address</th>    
                            <th>Priority</th>
                            <th>Process</th>
                        </tr>
                    </thead>
                    <tbody>
HTML;

$stmt1 = $dbh->connect()->prepare($consultaAll['allprojects']['sqlAllProjects']);
$stmt1->execute();
$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);

foreach($results as $result) {
    echo <<<HTML
        <tr>
            <td>{$result['address']}</td>
            <td>{$result['nm_priority']}</td>
            <td>
                <button type='submit' class='btn btn-primary float-end' name='updatesingleproject' value='{$result['id_project']}'>Update</button>
            </td>    
        </tr>
HTML;
}

echo <<<HTML
                    </tbody>
                </table> 
            </div>
        </div>
    </div>
</form>
HTML;
?>
