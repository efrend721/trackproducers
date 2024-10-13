<?php


echo <<<HTML
<div class='card'>
 <div class='card-header'>
     <span><i class='bi bi-table me-2'></i></span> Project <span id='idJob'>$idjob</span>
HTML ;
//necessary to configure the Back button
include_once '../includes/page_redirection.php';

/*if ($driver != $user_id) {
    echo $buttonAttributes;
}

else {
    echo <<<HTML
        <button 
            type="button" 
            name="back" 
            class="btn btn-primary float-end " 
            onclick="location.href='../views/projectview.php'">
            Back
        </button>
HTML;
}*/
echo <<<HTML
 </div>
HTML;

$stmt1 = $dbh->connect()->prepare($projectlistquery['details']['specificProject']);
$stmt1->bindParam(1, $idjob , PDO::PARAM_INT) ;
$stmt1->execute();

echo <<<HTML
<div class='card-body'>
     <div class='shadow row mb-2 p-2 bg-dark border rounded-3 text-white'>
         <div class='col-8'><span class='strong'>Address</span></div>
         <div class='col-4'>Date</div>
         
     </div>
     <div class='shadow row mb-2 p-3 bg-secondary bg-opacity-50 border rounded-3 '>
HTML;

$results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
foreach($results as $result) {
    echo <<<HTML
<div class='col-8 text-truncate'>$result[address]</div>
<div class='col-4'>$result[date]</div>
HTML;
}

echo <<<HTML
     </div>
 </div>
</div>
<br>
HTML;

?>