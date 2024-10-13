<?php 
echo "<main class='mt-5 pt-3'>
<div class='container-fluid'>
    <div class='row'>
        <div class='col-md-12'>";
            //include_once '../includes/mensages.php';
            if ($devise == 'mobile') {

                include_once '../templates/mobile/carddetailproject.template.php';
            
            }else{
                
                include_once '../templates/carddetailproject.template.php';
            }
            //require_once ('../includes/mensages.php');
            
            /*echo "<div class='card'>
                <div class='card-header'>
                    <span><i class='bi bi-table me-2'></i></span> Project <span id='idJob'>$idjob</span>
                </div>
            ";
            include_once '../queries/projectlist.query.php';
            $stmt1 = $dbh->connect()->prepare($projectlistquery['details']['specificProject']);
            $stmt1->bindParam(1, $idjob , PDO::PARAM_INT);
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
            <br>*/
            echo "<form action='' method='POST'>
                <div class='card'>
                    
                        <div class='card-header'>
                            <span><i class='bi bi-table me-2'></i></span>Add New Commnet
                        </div>
                        <div class='card-body'>
                                                            
                            <div class='form-group'>
                                <label for='comment' id='labelComment'>Comment.</label>";
                                echo "<select name='comment' id='comment' class='form-control' aria-label='Default select example'>
                                        <option></option>";
                                        $stmtNotedesc = $dbh->connect()->prepare('SELECT * FROM note_description ');
                                        $stmtNotedesc->execute();
                                        $RowNotedesc = $stmtNotedesc->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($RowNotedesc as $RowNotedesc) {
                                            echo "<option value = {$RowNotedesc['id_note']}>{$RowNotedesc['des_note']}</option>";
                                        }
                                echo "</select>";
                            echo "</div>
                            <br>
                            <div class='form-group'>
                                <label for='extracomment' id='labelAdditionalComment'>Additional Comment</label>
                                <textarea class='form-control' id='extracomment' name='extracomment' rows='2'></textarea>
                            </div>
                            <br>
                            <div class='form-group'>    
                                <div class='camera'>
                                    <button id='activate' class='btn' data-bs-toggle='tooltip'  data-bs-placement='bottom' title='Activate Camera'>
                                        <i class='bi bi-camera-video'></i>
                                    </button> 
                                    <video id='video' playsinline>Stream de video no disponible.</video>
                                    <button id='startbutton' class='btn'><i class='bi bi-camera'></i>Take a Picture</button>
                                    <canvas id='canvas'></canvas>
                                    <div id='gallery' class='pre_Gallery'>
                                    <!-- Aquí se añadirán las imágenes dinámicamente -->
                                    </div>
                                        <!-- Modal para mostrar imagen ampliada -->
                                        <div id='modal' class='modal' onclick=this.style.display='none'>
                                            <span class='close'>&times;</span>
                                            <img class='modal-content' id='img01'>
                                            <div id='caption'></div>
                                        </div>
                                </div>
                            </div>    
                    
                        
                        </div>
                    
                </div>
                <br>
                <div class='card'>
                    <div class='card-body'> 
                        <div class='d-flex justify-content-end'>
                            <button class='btn btn-primary me-2' name='process' value='$idjob' type='submit'>Back</button>
                            <button class='btn btn-primary ' name='submit' value='$idjob' type='submit'>Save</button>
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