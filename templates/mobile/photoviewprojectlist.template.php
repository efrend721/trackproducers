<?php
echo "<main class='mt-5 pt-3'>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>";
            //require_once ('../includes/mensages.php');
            echo "<div class='card'>
                <div class='card-header'>
                    <span><i class='bi bi-table me-2'></i></span> Project <span id='idJob'>$idjobTmp</span>
                </div>
            ";
            include_once '../queries/projectlist.query.php'; 
            $stmt1 = $dbh->connect()->prepare($projectlistquery['details']['specificProject']);
            $stmt1->bindParam(1, $idjobTmp , PDO::PARAM_INT);
            $stmt1->execute();
            echo "<div class='card-body'>
                    <div class='shadow row mb-2 p-2 bg-dark border rounded-3 text-white'>
                        <div class='col-8'><span class='strong'>Address</span></div>
                        <div class='col-4'>Date</div>
                        
                    </div>
                    <div class='shadow row mb-2 p-3 bg-secondary bg-opacity-50 border rounded-3 '>";
                        $results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($results as $result) {
                        echo "<div class='col-8 text-truncate'>$result[address]</div>
                              <div class='col-4'>$result[date]</div>";
                        }
                
                    echo "</div>
                </div>
            </div> 
            <br>
            <form action='' method='POST'>
                <div class='card'>
                    
                        <div class='card-header'>
                            <span><i class='bi bi-table me-2'></i></span>Photo View 
                        </div>
                        <div class='card-body'>
                            <img src='$photoview' style='max-width: 100%; height: auto;'> 
                        </div>
                                                            
                                                                 
                </div>
                <br>
                <div class='card'>
                    <div class='card-body'> 
                        <div class='d-flex justify-content-end'>
                            <button class='btn btn-primary' name='process' value='$idjobTmp' type='submit'>Back</button>
                        </div>
                    </div>
                </div>
                <br>         
            </form>    
        </div>
    </div>
</div>
</main>";
?>