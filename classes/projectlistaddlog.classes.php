<?php 
    require_once 'dbh.classes.php';
    
    class  ProjectListAddLog    {
        public function getProjectListAddLog()
        {
            $dbh = new Dbh();
            include_once '../includes/serverside.rendering.php';
            include_once '../queries/projectlist.query.php';
            
            $idjob = $_POST['newnote'];
            $user_id = $_SESSION['user_id'];
            
            $stmtKnowDriver = $dbh->connect()->prepare("SELECT user_id FROM assigneddeliveries WHERE user_id = '$user_id'");
            $stmtKnowDriver->execute();
            $rowKnowDriver = $stmtKnowDriver->fetch(PDO::FETCH_ASSOC);
            if ($rowKnowDriver == false) {
                $driver = 0;
            } else {
            $driver = $rowKnowDriver['user_id']; 
            }


            $stmtDeleteImgTmp = $dbh->connect()->prepare($projectlistquery['details']['deleteImages']);
            $stmtDeleteImgTmp->bindParam(1, $user_id , PDO::PARAM_STR);
            $stmtDeleteImgTmp->bindParam(2, $idjob , PDO::PARAM_INT);
            $stmtDeleteImgTmp->execute();
            $stmtDeleteImgTmp = null;

            echo "<main class='mt-5 pt-3'>
                <div class='container-fluid'>
                    <div class='row'>
                        <div class='col-md-12'>";
                            include_once ('../includes/mensages.php');
                            if ($devise == 'mobile') {

                                include_once '../templates/mobile/carddetailproject.template.php';
                            
                            }else{
                                
                                include_once '../templates/carddetailproject.template.php';
                            }
                            
                            echo "<form action='../classes/savenote.classes.php' method='POST'>
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
                                                    <button id='activate' class='btn' data-bs-toggle='tooltip' data-bs-placement='bottom' title='Activate Camera'>
                                                        <i class='bi bi-camera-video'></i>
                                                    </button> 

                                                    <!-- Envuelve el video en un div con la nueva clase -->
                                                    <div class='video-wrapper-custom'>
                                                        <!-- Agrega la nueva clase al video -->
                                                        <video id='video' class='video-responsive-custom' playsinline>
                                                            Stream de video no disponible.
                                                        </video>
                                                    </div>

                                                    <button id='startbutton' class='btn'>
                                                        <i class='bi bi-camera'></i>Take a Picture
                                                    </button>
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
                                            <button class='btn btn-primary  me-2' name='submit' value='$idjob' type='submit'>Save</button>
                                            </form>";
                                            if ($driver == $user_id) {
                                                echo "<a href='../views/mydeliveries.php' class='btn btn-primary'>Back</a>";
                                            }
                                            else {
                                            echo "<form action = '../views/projectlistdetailview.php' method='POST'>             
                                                <button class='btn btn-primary' name='process' value='$idjob' type='submit'>Back</button>
                                            </form>";
                                            }

                                        echo "</div>

                                    </div>
                                </div>
                                <br>         
                                
                        </div>
                    </div>
                </div>
            </main>";
        }
    }
?>