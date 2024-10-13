<?php
function renderMobileTaskDetails($dbh, $user_id, $area, $idstation, $sqlTask, $contenedorStyle, $calloutinfo) {
    ob_start(); // Iniciar el almacenamiento en búfer de la salida

    echo "<div class='row'>
            <div class='col-md-12'>";

    // Conocer el driver asignado
    $stmtKnowDriver = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlTaskNowDriver']);
    $stmtKnowDriver->bindParam(1, $user_id, PDO::PARAM_STR);
    $stmtKnowDriver->execute();
    $rowKnowDriver = $stmtKnowDriver->fetch(PDO::FETCH_ASSOC);
    $driver = $rowKnowDriver !== false ? $rowKnowDriver['user_id'] : 0;

    // Conocer el área previa de la estación
    $stmtKnowPreStation = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlTaskPreStation']);
    $stmtKnowPreStation->bindParam(1, $user_id, PDO::PARAM_STR);
    $stmtKnowPreStation->execute();
    $rowKnowPreStation = $stmtKnowPreStation->fetch(PDO::FETCH_ASSOC);
    $prevarea = $rowKnowPreStation !== false ? $rowKnowPreStation['id_previus_area'] : 0;

    // Contar las tareas
    $stmtcounttask = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlCountTask']);
    $stmtcounttask->bindParam(1, $idstation, PDO::PARAM_INT);
    $stmtcounttask->execute();
    $rowcounttask = $stmtcounttask->fetch(PDO::FETCH_ASSOC);
    $counttask = $rowcounttask['counttask'];
                       
    if ($counttask == 0) {
        echo "<div class='card'>
                <div class='card-header'>
                    <span><i class='bi bi-table me-2'></i></span>User : {$user_id}, Area : {$area}, Station : {$idstation}
                </div>
                <div class='card-body'>
                    <div class='shadow row mb-3 p-3 bg-dark border rounded-3 text-white'>
                        <div class='col-7'><span>Address</span></div>
                        <div class='col-3'><span>Priority</span></div>
                        <div class='col-2'><span class='float-end'>Process</span></div>
                    </div>
                </div>
            </div>
            <br>";
    } else {
        $stmt2 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlProjectOne']);
        $stmt2->bindParam(1, $idstation, PDO::PARAM_INT);
        $stmt2->execute(); 
        echo "<div class='card'>
                    <div class='card-header'>
                        <span><i class='bi bi-table me-2'></i></span>User : {$user_id}, Area : {$area}, Station : {$idstation}
                    </div>
                    <div class='card-body'>
                        <div class='shadow row mb-3 p-3 bg-dark border rounded-3 text-white'>
                            <div class='col-7'><span>Address</span></div>
                            <div class='col-3'><span>Priority</span></div>
                            <div class='col-2'><span class='float-end'>Process</span></div>
                        </div>
                    </div>
                </div>
                <br>";

        $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results2 as $result2) {
            $address = $result2['address'];
            $priority = $result2['nm_priority'];
            $priority = getAbbr($priority);

            $stmtFecha = $dbh->connect()->prepare("SELECT date_start, time_start FROM task WHERE id_project = :id_project AND id_station = :id_station");
            $stmtFecha->bindParam(':id_project', $result2['id_project'], PDO::PARAM_STR);
            $stmtFecha->bindParam(':id_station', $idstation, PDO::PARAM_INT);
            $stmtFecha->execute();
            $rowFecha = $stmtFecha->fetchAll(PDO::FETCH_ASSOC);

            $fecha_start = $rowFecha[0]['date_start'];
            $hora_start = $rowFecha[0]['time_start'];
            $fechaHoraRegistro = $fecha_start . " " . $hora_start;
            $formatoEsperado = 'Y-m-d H:i:s';
            $fechaHoraObjeto = DateTime::createFromFormat($formatoEsperado, $fechaHoraRegistro);
            $fechaFormateada = ($fechaHoraObjeto && $fechaHoraObjeto->format($formatoEsperado) == $fechaHoraRegistro) ? $fechaHoraRegistro : null;

            $stmtSettingGoal = $dbh->connect()->prepare("SELECT job_time FROM settings");
            $stmtSettingGoal->execute();
            $rowSettingGoal = $stmtSettingGoal->fetchAll(PDO::FETCH_ASSOC);
            $limitTime = $rowSettingGoal[0]['job_time'];
            $divIdProyecto = $result2['id_project'];

            echo "<script>
                document.addEventListener('DOMContentLoaded', function() {
                    var script = document.createElement('script');
                    script.src = '../libraries/setTimer.js';
                    script.onload = function() {
                        var idProyecto = " . json_encode($result2['id_project']) . ";
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
                        <form action='../classes/taskexecute.classes.php' method='POST'>     
                            <div class='shadow row mb-3 p-3 border rounded-3 text-black' style='$contenedorStyle'>
                                <div class='col-7 text-truncate'><span>$address</span></div>
                                <div class='col-3 text-truncate'><span class='badge' style='background-color: #c2593f;'>$priority</span></div>
                                <div class='col-2'><button type='submit' name='process' value='$result2[id_project]' class='btn btn-primary btn-sm float-end' style='background-color: #567ebb;'>Finish</button></div>
                            </div>
                        </form>";
            echo "<div class='row'>
                    <div class='col-md-7 mb-4'>
                        <div class='shadow rounded-3 bg-light text-black h-100'>
                            <div class='card-body py-4'>
                                <div class='row' style='$calloutinfo'>
                                    <span>Date Start: $fechaFormateada</span>
                                </div>
                                <div class='row' style='$calloutinfo'>
                                    <span>Color: $result2[id_color]</span>
                                </div>
                                <div class='row' style='$calloutinfo'>
                                    <span>Piece: $result2[piece]</span>
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
                                            value='$result2[id_project]'>
                                            Add Comment
                                        </button>
                                    </div>
                                </form>";
                                } else {
                                    echo "<form action='' method='POST'> 
                                    <div class='row'>
                                        <button type='submit' class='btn btn-primary' style='background-color: #567ebb;' 
                                            name='addcomment'
                                            value='$result2[id_project]'>
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
                </div>"; // End card-body
        }
    }

    //echo "<br>"; // End card
    
    /*if ($driver == $user_id) {
        $stmt1 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlDeliveryPreGeneral']);
        $stmt1->bindParam(1, $prevarea, PDO::PARAM_INT);
        $stmt1->bindParam(2, $idstation, PDO::PARAM_INT);
        $stmt1->bindParam(3, $user_id, PDO::PARAM_STR);
        $stmt1->execute();   
    } else {
        
        $stmt1 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlProjectZero']);
        $stmt1->bindParam(1, $prevarea, PDO::PARAM_INT);
        $stmt1->bindParam(2, $idstation, PDO::PARAM_INT);
        $stmt1->execute();          
    }*/
    $stmt1 = $dbh->connect()->prepare($sqlTask['allSqltask']['sqlProjectZero']);
    $stmt1->execute();
    echo "<div class='card'>
            <div class='card-body'>
                <form action='../classes/taskexecute.classes.php' method='POST'>";
                $results = $stmt1->fetchAll(PDO::FETCH_ASSOC);
                foreach ($results as $result) {
                    $address = $result['address'];
                    $priority = $result['nm_priority'];
                    $priority = getAbbr($priority);
                    echo "<div class='shadow row mb-2 p-2 bg-secondary border rounded-3 text-white'>
                            <div class='row g-2'>
                                <div class='col-7'><span>$address</span></div>
                                <div class='col-3'><span class='badge text-bg-danger'>{$priority}</span></div>
                                <div class='col-2'><button type='submit' name='process' value='$result[id_project]' class='btn btn-primary float-end' style='background-color: #567ebb;'>Start</button></div>
                            </div>
                        </div>";
                    }
                echo "
                </form> 
            </div>
        </div>
    </div>
</div>
</div>
</main>\n";

    return ob_get_clean(); // Obtener el contenido del búfer y limpiarlo
}
?>
