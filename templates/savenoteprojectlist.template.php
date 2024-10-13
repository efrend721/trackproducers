<?php 
echo "<main class='mt-5 pt-3'>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>";
            include_once ('../includes/mensages.php');
            //var_dump($_SESSION);
            //var_dump()
            
            if ($devise == 'mobile') {

                echo "<div class='card'>
                <div class='card-header'>
                    <span><i class='bi bi-table me-2'></i></span> Project <span id='idJob'>$idjobSavenote</span>
                </div>
            ";
            include_once('../queries/projectlist.query.php');
            $stmt1 = $dbh->connect()->prepare($projectlistquery['details']['specificProject']);
            $stmt1->bindParam(1, $idjobSavenote , PDO::PARAM_INT);
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
            <br>";



            
            }else{
                
                       

            echo "<div class='card'>
                <div class='card-header'>
                    <span><i class='bi bi-table me-2'></i></span> Project <span id='idJob'>$idjobSavenote</span>
                </div>
            ";
            include_once('../queries/projectlist.query.php');
            $stmt1 = $dbh->connect()->prepare($projectlistquery['details']['specificProject']);
            $stmt1->bindParam(1, $idjobSavenote , PDO::PARAM_INT);
            $stmt1->execute();
            echo "<div class='card-body'>
                    <div class='shadow row mb-2 p-2 bg-dark border rounded-3 text-white'>
                        <div class='col-6'><span class='strong'>Address</span></div>
                        <div class='col-2'>Date</div>
                        <div class='col-2'>Piece</div>
                        <div class='col-2'>Color</div>
                    </div>
                    <div class='shadow row mb-2 p-3 bg-secondary bg-opacity-50 border rounded-3 '>";
                        $results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                        foreach($results as $result) {
                        echo "<div class='col-6 text-truncate'>$result[address]</div>
                                <div class='col-2'>$result[date]</div>
                                <div class='col-2'>$result[piece]</div>
                                <div class='col-2'>$result[id_color]</div>";
                        }
                
                    echo "</div>
                </div>
            </div> 
            <br>";

            }            

            echo " <form action='' method='POST'>
                <div class='card'>
                    
                        <div class='card-header'>
                            <span><i class='bi bi-table me-2'></i></span>Photo View 
                        </div>
                        <div class='card-body'>";
                        //GUARDAR EN BASE DE DATOS"; 
                        require_once '../classes/savenote.classes.php';                                        
                        echo "</div>
                                                            
                                                                 
                </div>
                <br>
                <div class='card'>
                    <div class='card-body'> 
                        <div class='d-flex justify-content-end'>
                            <button class='btn btn-primary' name='process' value='$idjobSavenote' type='submit'>Back</button>
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