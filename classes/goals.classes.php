<?php
require_once 'dbh.classes.php';


class GoalsMain
{
    public function setGoals()
    {
        $dbh = new Dbh();
        $jm = null;
        $jw = null;
        $jd = null;
        $jt = null;
        
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $jm = $_POST['jobmonth'];
            $jw = $_POST['jobweek'];
            $jd = $_POST['jobday'];
            $jt = $_POST['jobtime'];
            
            if(isset($jm) && isset($jw) && isset($jd) && isset($jt)) {
                // Function to validate if a value is a positive integer
                function esEnteroPositivoYMenorQue($valor, $max) {
                    return is_numeric($valor) && filter_var($valor, FILTER_VALIDATE_INT) !== false && $valor >= 0 && $valor <= $max;
                }
                // Definir los valores máximos permitidos para cada variable
                $valoresMaximos = [
                    'jobmonth' => 9999,
                    'jobweek' => 999,
                    'jobday' => 99,
                    'jobtime' => 99,
                ];
                // Place all variables in an array to iterate over them
                $variables = [
                   'jobmonth' => $jm,
                   'jobweek' => $jw,
                   'jobday' => $jd,
                   'jobtime' => $jt,
                ];
                // Variable to store if all values ​​are valid
                $sonTodosValidos = true;
                // Iterate over each variable and validate
                foreach ($variables as $nombre => $valor) {
                $maximo = $valoresMaximos[$nombre]; // Get the maximum value allowed
                    if (!esEnteroPositivoYMenorQue($valor, $maximo)) {
                        $_SESSION['status'] = "The value of '{$nombre}' is not a positive integer or exceeds the maximum allowed of {$maximo}."; 
                        //echo "The value of '{$name}' is not a positive integer or exceeds the maximum allowed of {$max}.";
                        $sonTodosValidos = false;
                    }
                }
                // If all values ​​are valid
                if ($sonTodosValidos) {
                    $stmt = $dbh->connect()->prepare("UPDATE settings SET job_month = :job_month, job_week = :job_week, job_day = :job_day, job_time = :job_time");
                    $stmt->bindParam(':job_month', $jm, PDO::PARAM_INT);
                    $stmt->bindParam(':job_week', $jw, PDO::PARAM_INT);
                    $stmt->bindParam(':job_day', $jd, PDO::PARAM_INT);
                    $stmt->bindParam(':job_time', $jt, PDO::PARAM_INT);
                    $stmt->execute();
                    if($stmt){
                        $_SESSION['status'] = "Goals updated successfully";
                        $stmt = null;
                    }
                    else{
                        $_SESSION['status'] = "Goals not updated";
                        $stmt = null;
                    }
                } 
                else {
                    $_SESSION['status'] = "Some values ​​are not valid.";
                }
            }
            else {
                $_SESSION['status'] = "No goals selected";
            }
        }
        $stmt = $dbh->connect()->prepare("SELECT * FROM settings");
        $stmt->execute();
        $result = $stmt->fetchAll();
        $jobMonth = $result[0]['job_month'];
        $jobWeek = $result[0]['job_week'];
        $jobDay = $result[0]['job_day'];
        $jobTime = $result[0]['job_time'];
        
        echo "<main class='mt-5 pt-3'>
                <div class='container-fluid'> ";
                if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    $mensage = $_SESSION['status'];
                    $statusMap = [
                        "Priority updated successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                        "Goals not updated" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                        "No goals selected" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                        "Some values ​​are not valid" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                        "The value of '{$nombre}' is not a positive integer." => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                        "The value of '{$nombre}' is not a positive integer or exceeds the maximum allowed of {$maximo}." => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"]
                    ];
                    list($icono, $color) = $statusMap[$mensage] ?? ["<i class='bi bi-exclamation-triangle-fill'></i>", "alert alert-warning"];
                    echo "<div class='$color alert-dismissible fade show' role='alert'>
                            $icono 
                            <strong>$mensage</strong>
                            <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                          </div>";
                    unset($_SESSION['status']);
                    
                }  
                echo "<form action='' method='POST'>";
                    echo "<div class='card'>
                            <div class='card-header'>
                                <span><i class='bi bi-table me-2'></i></span>Goal of Jobs 
                            </div>
                            <div class='row g-3 card-body'>
                                <div class='col-md-4'>
                                    <label for='jobmonth' class='form-label'>By Month</label>
                                    <input type='text' class='form-control' name='jobmonth' id='jobmonth' value='$jobMonth' required>
                                    <div class='valid-feedback'>
                                    Looks good!
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <label for='jobweek' class='form-label'>By Week</label>
                                    <input type='text' class='form-control' name='jobweek' id='jobweek' value='$jobWeek' required>
                                    <div class='valid-feedback'>
                                    Looks good!
                                    </div>
                                </div>
                                <div class='col-md-4'>
                                    <label for='jobday' class='form-label'>Per Day</label>
                                    <div class='input-group has-validation'>
                                    <input type='text' class='form-control' name='jobday' id='jobday' value='$jobDay' required>
                                    <div class='invalid-feedback'>
                                    Please choose a username.
                                    </div>
                                </div>
                            </div>
                        </div>
                        </div><br>";
                        echo "<div class='card'>
                            <div class='card-header'>
                                <span><i class='bi bi-table me-2'></i></span>Time for Jobs
                            </div>
                            <div class='row g-3 card-body'>
                                
                                    <div class='col-md-4'>
                                        <label for='jobtime' class='form-label'>Minutes</label>
                                        <input type='text' class='form-control'  name='jobtime' id='jobtime' value='$jobTime' required>
                                        <div class='valid-feedback'>
                                        Looks good!
                                        </div>
                                    </div>
                                    <div class='col-12'>
                                        <button class='btn btn-primary' value='submit' type='submit'>Save</button>
                                    </div>
                                </form>
                            </div>
                        </div>";
                echo "</div>
            </main>\n";
    }

}
