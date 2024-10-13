<?php
require_once 'dbh.classes.php';


class ColorsMain {
    public function setColors()
    {
        $dbh = new Dbh();
        $idcolor = null;
        $nmcolor = null;
     
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['action'])) {
                $action = $_POST['action'];
                $idcolor = $_POST['id_color'];
                $nmcolor = $_POST['nm_color'];
                if ($action != 'save') {
                    $stmtColor = $dbh->connect()->prepare("DELETE FROM color WHERE id_color = ?");
                    $stmtColor->execute([$action]);
                    $_SESSION['status'] = "Color deleted successfully";
                }
                else  {
                    if(isset($idcolor) && isset($nmcolor) ) {
                        // Function to validate if a value is a positive integer
                        function isPositiveInteger($value) {
                            return isset($value) && is_numeric($value) && (int)$value > 0 && (int)$value == $value;
                        }
                        
                        function isStringOnly($value) {
                            return isset($value) && is_string($value) && !preg_match('/\d/', $value);
                        }
                        
                        $areAllValid = true; // Assume all values are valid initially
                        
                        // Directly use $idcolor and $nmcolor instead of looping through them.
                        if (!isPositiveInteger($idcolor)) {
                            $_SESSION['status'] = "The value of Id is not a positive integer.";
                            $areAllValid = false;
                        } elseif (!isStringOnly($nmcolor)) {
                            $_SESSION['status'] = "The value of Color is not a valid string.";
                            $areAllValid = false;
                        }
                        else {
                            $stmtColor = $dbh->connect()->prepare("INSERT INTO color (id_color, nm_color) VALUES (?, ?)");
                            $stmtColor->execute([$idcolor, $nmcolor]);
                            $_SESSION['status'] = "Color saved successfully";
                        }
                    }
                    else {
                        $_SESSION['status'] = "Any field can not be empty.";
                    }
                }
            }
        }    
        echo "<main class='mt-5 pt-3'>
                <div class='container-fluid'>";
                if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    $mensage = $_SESSION['status'];
                    $statusMap = [
                        "Color saved successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                        "Color deleted successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                        "Any field can not be empty." => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                        "The value of Id is not a positive integer." => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                        "TThe value of Color is not a valid string." => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"]
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
                                <span><i class='bi bi-table me-2'></i></span>Colors 
                            </div>
                            <div class='row g-3 card-body'>
                                <div class='col-md-2'>
                                    <label for='jobmonth' class='form-label'>Id</label>
                                    <input type='text' class='form-control'  name='id_color' id='id_color' value=''>
                                    <div class='valid-feedback'>
                                    Looks good!
                                    </div>
                                </div>
                                <div class='col-md-10'>
                                    <label for='jobweek' class='form-label'>Color</label>
                                    <input type='text' class='form-control' name='nm_color' id='nm_color' value=''>
                                    <div class='valid-feedback'>
                                    Looks good!
                                    </div>
                                </div>
                            </div>
                            <div class='row card-body'>
                                <div class='col-md-4'>
                                    <button class='btn btn-primary' name='action' value='save' type='submit'>Save</button>
                                </div>
                            </div>
                        </div>
                    
                <br>";
                $stmtColor = $dbh->connect()->prepare("SELECT * FROM color");
                $stmtColor->execute();
                $resultColor = $stmtColor->fetchAll();
                echo " <div class='card'>
                            <div class='card-header'>
                                <span><i class='bi bi-table me-2'></i></span>Colors 
                            </div>
                            <div class='card-body'>
                            ";
                                foreach($resultColor as $rowColor) {
                                    echo "<div class='shadow row mb-2 p-3 bg-secondary bg-opacity-50 border rounded-3'>
                                            <div class='col-2'><span>{$rowColor['id_color']}</span></div>
                                            <div class='col-6'><span>{$rowColor['nm_color']}</span></div>
                                            <div class='col-4 '><span class='float-end'>
                                                <button type='submit'
                                                        name='action'
                                                        value = '{$rowColor['id_color']}'   
                                                        class='btn btn-danger btn-sm'>Delete
                                                </button>
                                                </span></div>
                                        </div>";
                                }
                            echo "</div>
                        </div>
                    </form>";
            echo "</div>
        </main>\n";
    }
}

