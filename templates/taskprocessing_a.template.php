<?php 
function renderTask($dbh, $user_id, $sqlTask, $area, $idstation, $contenedorStyle, $calloutinfo ) {
    ob_start();
    
$stmtKnowDriver = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlTaskNowDriver']);
$stmtKnowDriver->bindParam(1, $user_id, PDO::PARAM_STR);
$stmtKnowDriver->execute();
$rowKnowDriver = $stmtKnowDriver->fetch(PDO::FETCH_ASSOC);

$driver = $rowKnowDriver !== false ? $rowKnowDriver['user_id'] : 0;


$stmtKnowPreStation = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlTaskPreStation']);
$stmtKnowPreStation->bindParam(1, $user_id, PDO::PARAM_STR);
$stmtKnowPreStation->execute();
$rowKnowPreStation = $stmtKnowPreStation->fetch(PDO::FETCH_ASSOC);

$prevarea = $rowKnowPreStation !== false ? $rowKnowPreStation['id_previus_area'] : 0;


$stmtcounttask = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlCountTask']);
$stmtcounttask->bindParam(1, $idstation);
$stmtcounttask->execute();
$rowcounttask = $stmtcounttask->fetch(PDO::FETCH_ASSOC);

$counttask = $rowcounttask !== false ? $rowcounttask['counttask'] : 0;

echo "<div class='row'>
        <div class='col-md-12'>";
            if ($counttask == 0) {
                if ($driver == $user_id) {
                    
                    echo "<div class='card'>
                    <div class='card-header'>
                        <span><i class='bi bi-table me-2'></i></span>User : {$user_id}, Area : {$area}, Station : {$idstation}, Previous Area : {$prevarea}
                    </div>
                    <div class='card-body'>
                        <div class='shadow row mb-2 p-1 bg-dark border rounded-3 text-white'>
                            <div class='row g-2'>
                                <div class='col-6'><span>Address</span></div>
                                <div class='col-2'><span>Priority</span></div>
                                <div class='col-2'><span>Date</span></div>
                                <div class='col-2'><span class='float-end'>Proces</span></div>
                            </div>
                        </div>
                    </div> 
                </div>";
                }
                else {
                    echo "<div class='card'>
                    <div class='card-header'>
                        <span><i class='bi bi-table me-2'></i></span>User : {$user_id}, Area : {$area}, Station : {$idstation}, Previous Area : {$prevarea}
                    </div>
                    <div class='card-body'>
                        <div class='shadow row mb-2 p-1 bg-dark border rounded-3 text-white'>
                            <div class='row g-2'>
                                <div class='col-2'><span>Cart</span></div>
                                <div class='col-4'><span>Address</span></div>
                                <div class='col-2'><span>Priority</span></div>
                                <div class='col-2'><span>Date</span></div>
                                <div class='col-2'><span class='float-end'>Proces</span></div>
                            </div>
                        </div>
                    </div> 
                </div>";

                }
            } 
            else {
                echo "<div class='card p-1'>
                        <div class='card-header'>
                            <span><i class='bi bi-table me-2'></i></span>User : {$user_id}, Area : {$area}, Station : {$idstation}, Previous Area : {$prevarea}
                        </div>
                        <div class='card-body'>    
                            <div class='shadow row mb-2 p-1 bg-dark border rounded-3 text-white'>
                                <div class='row g-2'>
                                    <div class='col-2'><span>Cart</span></div>
                                    <div class='col-4'><span>Address</span></div>
                                    <div class='col-2'><span>Priority</span></div>
                                    <div class='col-2'><span>Date</span></div>
                                    <div class='col-2'><span class='float-end'>Proces</span></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <br>";
                if ($driver == $user_id){
                    $stmtprevarea1 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlDeliveryTaskPre']);
                    $stmtprevarea1->bindParam(1, $idstation);
                
                } else{
                    $stmtprevarea1 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlTaskPre']);
                    $stmtprevarea1->bindParam(1, $idstation);
                    $stmtprevarea1->bindParam(2, $idstation);
                }
                
                $stmtprevarea1->execute();            
                echo "";
                    $results1 = $stmtprevarea1->fetchAll(PDO::FETCH_ASSOC);
                    foreach ($results1 as $result1) {
                        $cart = $result1['id_cart'];
                        $address = $result1['address'];
                        $priority = $result1['nm_priority'];
                        $priority = getAbbr($priority);
                        $date = $result1['date'];
                        
                        $stmtFecha = $dbh->connect()->prepare("SELECT date_start, time_start FROM task WHERE id_project = '$result1[id_project]' AND id_station = '$idstation'");
                        $stmtFecha->execute();
                        $rowFecha = $stmtFecha->fetchAll(PDO::FETCH_ASSOC);
                        $fecha_start = $rowFecha[0]['date_start'];
                        $hora_start = $rowFecha[0]['time_start'];
                        $fechaHoraRegistro = $fecha_start . " " . $hora_start;
                        $formatoEsperado = 'Y-m-d H:i:s'; // Ajusta este formato según sea necesario
                        $fechaHoraObjeto = DateTime::createFromFormat($formatoEsperado, $fechaHoraRegistro);
                        if ($fechaHoraObjeto && $fechaHoraObjeto->format($formatoEsperado) == $fechaHoraRegistro) {
                            $fechaFormateada = $fechaHoraRegistro;
                        }   
                        $stmtSettingGoal = $dbh->connect()->prepare("SELECT job_time FROM settings");
                        $stmtSettingGoal->execute();
                        $rowSettingGoal = $stmtSettingGoal->fetchAll(PDO::FETCH_ASSOC);
                        $limitTime = $rowSettingGoal[0]['job_time'];
                        $divIdProyecto = $result1['id_project'];
                        echo "<script>
                            document.addEventListener('DOMContentLoaded', function() {
                                var script = document.createElement('script');
                                script.src = '../libraries/setTimer.js';
                                script.onload = function() {
                                    var idProyecto = " . json_encode($result1['id_project']) . ";
                                    var fechaHoraRegistro = '$fechaFormateada';
                                    var lTime = " . json_encode($limitTime) . ";

                                    let cronometroProyecto = new ProyectoCronometro(idProyecto, fechaHoraRegistro, lTime);
                                    cronometroProyecto.actualizarCronometro();
                                    cronometroProyecto.alterarContenidoDiv();
                                    setInterval(function() {
                                        cronometroProyecto.actualizarCronometro();
                                        cronometroProyecto.alterarContenidoDiv();
                                    }, 1000);
                                };
                                document.body.appendChild(script);
                            });
                        </script>";
                        echo "<div class='card'>
                                <div class='card-body'>
                                    <div class='row mb-1 p-1 border rounded-3 text-black' style='$contenedorStyle'>
                                        <form action='../classes/taskexecute.classes.php' method='POST'>
                                        <div class='row g-2'>
                                            <div class='col-2'><span>$cart</span></div>
                                            <div class='col-4'><span>$address</span></div>
                                            <div class='col-2'><span class='badge' style='background-color: #c2593f;'>$priority</span></div>
                                            <div class='col-2'><span>$date</span></div>
                                            <div class='col-2'><button type='submit' name='process' value='$result1[id_project]' class='btn btn-primary btn-sm float-end' style='background-color: #567ebb;'>Finish</button></div>
                                        </div>
                                        </form>
                                    </div>";
                        echo "<div class='row'>
                                <div class='col-md-7 mb-4'>
                                    <div class='shadow rounded-3 bg-light text-black h-100'>
                                        <div class='card-body py-4'>
                                            <div class='row' style='$calloutinfo'>
                                                <span>Date Start: $fechaFormateada</span>
                                            </div>
                                            <div class='row' style='$calloutinfo'>
                                                <span>Color: $result1[id_color]</span>
                                            </div>
                                            <div class='row' style='$calloutinfo'>
                                                <span>Piece: $result1[piece]</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class='col-md-5 mb-4'>
                                    <div class='shadow rounded-3 bg-light text-dark h-100'>
                                        <div class='card-body py-4'>
                                            <div class='row rounded-3 p-1 mb-2 bg-info'>
                                                <span>Time Processing</span>
                                                <div id='cronometro$divIdProyecto'><span></span></div>
                                            </div>
                                            <div id='miDivId$divIdProyecto'></div>";
                                            if ($driver == $user_id) {
                                            echo "<form action='../views/projectlistaddlogview.php' method='POST'> 
                                            <div class='row'>
                                                <button type='submit' class='btn btn-primary' style='background-color: #567ebb;' 
                                                    name='newnote'
                                                    value='$result1[id_project]'>
                                                    Add Comment
                                                </button>
                                            </div>
                                        </form>";
                                        }
                                        else {
                                            echo "<form action='' method='POST'> 
                                            <div class='row'>
                                                <button type='submit' class='btn btn-primary' style='background-color: #567ebb;' 
                                                    name='addcomment'
                                                    value='$result1[id_project]'>
                                                    Add Comment
                                                </button>
                                            </div>
                                        </form>";      
                                        }
                                        echo "</div>
                                    </div>
                                </div>
                            </div>";
                    echo "</div>
                        </div>";
                    }
                    echo "
                </form>";
            }
            echo "<br>";
            
                     
            
            if ($driver == $user_id) {
                
                    $stmt1 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlDeliveryPreGeneral']);
                    $stmt1->bindParam(1, $prevarea);
                    $stmt1->bindParam(2, $idstation);
                    $stmt1->bindParam(3, $user_id);
                    $stmt1->execute();
                    echo "<div class='card'>
                    <div class='card-body'>
                        <form action='../classes/taskexecute.classes.php' method='POST'>";
                            $results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($results as $result) {
                            $address = $result['address'];
                            $priority = $result['nm_priority'];
                            $priority = getAbbr($priority);
                            $date = $result['date'];    
                            echo "<div class='shadow row mb-2 p-1 border rounded-3 text-black' style='$contenedorStyle'>
                                    <div class='row g-2'>
                                        <div class='col-sm-4'><span>$address</span></div>
                                        <div class='col-sm-2'><span class='badge' style='background-color: #c2593f;'>$result[nm_priority]</span></div>
                                        <div class='col-sm-2'><span>$date</span></div>
                                        <div class='col-sm-2'><button type='submit' name='process' value='$result[id_project]' class='btn float-end' style='background-color: #92b35a;'>Start</button></div>    
                                    </div>
                                </div>";
                            }
                            echo "
                        </form> 
                    </div>
                </div>";   
            }
            else {
                echo "<br>";
                    
                    $stmt1 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlTaskPreGeneral']);
                    $stmt1->bindParam(1, $prevarea);
                    $stmt1->bindParam(2, $idstation);
                    $stmt1->bindParam(3, $idstation);
                    $stmt1->execute();          
            
            
            
            echo "<div class='card'>
                    <div class='card-body'>
                        <form action='../classes/taskexecute.classes.php' method='POST'>";
                            $results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($results as $result) {
                            $cart = $result['id_cart'];
                            $address = $result['address'];
                            $priority = $result['nm_priority'];
                            $priority = getAbbr($priority);
                            $date = $result['date'];    
                            echo "<div class='shadow row mb-2 p-1 border rounded-3 text-black' style='$contenedorStyle'>
                                    <div class='row g-2'>
                                        <div class='col-2'><span>$cart</span></div>                                    
                                        <div class='col-sm-4'><span>$address</span></div>
                                        <div class='col-sm-2'><span class='badge' style='background-color: #c2593f;'>$result[nm_priority]</span></div>
                                        <div class='col-sm-2'><span>$date</span></div>
                                        <div class='col-sm-2'><button type='submit' name='process' value='$result[id_project]' class='btn float-end' style='background-color: #92b35a;'>Start</button></div>    
                                    </div>
                                </div>";
                            }
                            echo "
                        </form> 
                    </div>
                </div>";
                }

            echo "</div>
        </div>
    </div>
</main>\n"; 
return ob_get_clean();
}
?>