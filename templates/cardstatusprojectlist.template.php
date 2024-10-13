<?php 
$stmt2 = $dbh->connect()->prepare($projectlistquery['allProjects']['deptQuery']);
$stmt2->execute();
echo <<<HTML
    <div class='card'>
        <div class='card-header bg-success-subtle'>
            <span><i class='bi bi-table me-2'></i></span>Status
        </div> 
        <div class='card-body'>
    HTML;
    $results2 = $stmt2->fetchAll(PDO::FETCH_ASSOC);
    foreach($results2 as $result1) {
        echo <<<HTML
            <div class='row mb-3'> 
                <div class='col-6'>
                    <div class='shadow p-3 bg-light border rounded-3 mx-1'> 
                        $result1[nm_dept]
                    </div>
                </div>
                <div class='col-6'>
            HTML;
            //saber cuantas areas tiene un departamento 
            $stmt6 = $dbh->connect()->prepare($projectlistquery['details']['countAreaquery']);
            $stmt6->bindParam(1, $result1['id_dept'], PDO::PARAM_INT);
            $stmt6->execute();
            $results6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
            $num_area = $results6[0]['COUNT(id_area)'];
            //saber cuantas tareas tiene un departamento fin
            //saber si el projecto ya existe en task
            $stmt5 = $dbh->connect()->prepare($projectlistquery['details']['taskQuery']);
            $stmt5->bindParam(1, $idjob, PDO::PARAM_INT);
            $stmt5->bindParam(2, $result1['id_dept'], PDO::PARAM_INT);
            $stmt5->execute();
            $results5 = $stmt5->fetchAll(PDO::FETCH_ASSOC);
            //si hay por lo menos un registro en task diga : se esta procesando
            if ($results5[0]['count1'] == 1) {
                echo <<<HTML
                    <div class="shadow p-3 bg-warning rounded-2 mx-1 text-end">
                        <form method="post" action="../views/projectlistdetailareaview.php" style="dIsplay: inline;">
                            <button type="submit" name="id_dept" value="{$result1['id_dept']}" style="background: transparent; border: none; color: inherit;">Processing</button>
                        </form>
                    </div>
                HTML;
            }
            //si hay mas de un registro de ese projecto en task averigua cuantas areas estan trabajando en ese proyecto
            elseif ($results5[0]['count1'] > 1 ) {
                $stmt7 = $dbh->connect()->prepare($projectlistquery['details']['taskAreaquery']);
                $stmt7->bindParam(1, $idjob, PDO::PARAM_INT);
                $stmt7->bindParam(2, $result1['id_dept'], PDO::PARAM_INT);
                $stmt7->execute();
                $results7 = $stmt7->fetchAll(PDO::FETCH_ASSOC);
                $task_area = $results7[0]['COUNT(task.id_area)'];
                //compara si el numero de areas trabajando en el proyecto es igual al numero de areas que tiene el departamento
                //si son iguales verifica cuantos tipos de estatus de estacion hay en el proyecto
                if ($task_area == $num_area) {
                    $stmt3 = $dbh->connect()->prepare($projectlistquery['details']['taskStatusquery']);
                    $stmt3->bindParam(1, $idjob, PDO::PARAM_INT);
                    $stmt3->bindParam(2, $result1['id_dept'], PDO::PARAM_INT);
                    $stmt3->execute();
                    $results4 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                    //si hay un tipo , verifica si todas son 1 (procesando) o 2 (terminado)
                    if ($results4[0]['count'] == 1) {
                        $stmt6 = $dbh->connect()->prepare($projectlistquery['details']['taskStatusquery2']);
                        $binmParam(1, $idjob, PDO::PARAM_INT);
                        $binmParam(2, $result1['id_dept'], PDO::PARAM_INT);
                        $stmt6->execute();
                        $results6 = $stmt6->fetchAll(PDO::FETCH_ASSOC);
                        if ($results6[0]['id_status_station'] == 1) {
                            echo <<<HTML
                                <div class="shadow p-3 bg-warning rounded-2 mx-1 text-end">
                                    <form method="post" action="../views/projectlistdetailareaview.php" style="dIsplay: inline;">
                                        <button type="submit" name="id_dept" value="{$result1['id_dept']}" style="background: transparent; border: none; color: inherit;">Processing</button>
                                    </form>
                                </div>
                            HTML;
                        }
                        else {
                            echo "<div class='shadow p-3 bg-success rounded-2 mx-1 text-end'> 
                                Done
                            </div>";
                        }
                    }
                    else {
                        echo <<<HTML
                            <div class="shadow p-3 bg-warning rounded-2 mx-1 text-end">
                                <form method="post" action="../views/projectlistdetailareaview.php" style="dIsplay: inline;">
                                    <button type="submit" name="id_dept" value="{$result1['id_dept']}" style="background: transparent; border: none; color: inherit;">Processing</button>
                                </form>
                            </div>
                        HTML;
                    }
                    echo "<div class='shadow p-3 bg-success rounded-2 mx-1 text-end'> 
                        Done
                    </div>";
                }
                else {
                    echo <<<HTML
                        <div class="shadow p-3 bg-warning rounded-2 mx-1 text-end">
                            <form method="post" action="../views/projectlistdetailareaview.php" style="dIsplay: inline;">
                                <button type="submit" name="id_dept" value="{$result1['id_dept']}" style="background: transparent; border: none; color: inherit;">Processing</button>
                            </form>
                        </div>
                    HTML;
                }
            }
            else {
                echo "<div class='shadow p-3 bg-danger rounded-2 mx-1 text-end'> 
                    No Started
                </div>";
            }                                                        
            echo <<<HTML
            </div>
        </div>
        HTML;
        }
        echo <<<HTML
    </div>
</div>
<br>
HTML;
?>