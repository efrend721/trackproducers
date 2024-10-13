<?php
require_once 'dbh.classes.php';

class DowntimeMain
{
    public function setNumofdowntime()
    {
        $dbh = new Dbh();

        echo <<<HTML
<main class='mt-5 pt-3'>
    <div class='container-fluid'>
        <div class='row'>
HTML;

        if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
            $mensage = $_SESSION['status'];
            $statusMap = [
                "Priority updated successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                "Goals not updated" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                "No goals selected" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                "Some values ​​are not valid" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
            ];
            list($icono, $color) = $statusMap[$mensage] ?? ["<i class='bi bi-exclamation-triangle-fill'></i>", "alert alert-warning"];

            echo <<<HTML
            <div class='$color alert-dismissible fade show' role='alert'>
                $icono 
                <strong>$mensage</strong>
                <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
            </div>
HTML;

            unset($_SESSION['status']);
        }

        echo <<<HTML
            <form action='../classes/numofdowntimequery.classes.php' method='POST'>
                <div class='row'>
                    <div class='col-md-6'>
                        <div class='card h-100'>
                            <div class='card-header'>
                                <span><i class='bi bi-table me-2'></i></span>Number of Downtime Jobs
                            </div>
                            <div class='row g-3 card-body'>
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='option' id='flexRadioDaily' value='daily' checked onclick='removeDateFields()'>
                                    <label class='form-check-label' for='flexRadioDaily'>
                                    Daily
                                    </label>
                                </div>
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='option' id='flexRadioYesterday' value='yesterday' onclick='removeDateFields()'>
                                    <label class='form-check-label' for='flexRadioYesterday'>
                                    Yesterday
                                    </label>
                                </div>
                                <div class='form-check'>
                                    <input class='form-check-input' type='radio' name='option' id='flexRadioDateselect' value='dateselect' onclick='addDateFields()'>
                                    <label class='form-check-label' for='flexRadioDateselect'>
                                    Date Selection
                                    </label>
                                </div>
                                <div class='col-md-12'>    
                                    <div id='dateFields'></div>
                                    <script>
                                        function addDateFields() {
                                            var dateFieldsDiv = document.getElementById('dateFields');
                                            dateFieldsDiv.innerHTML = `
                                                <label for='startDate' class='form-label'>Start Date</label>
                                                <input type='date' class='form-control mb-3' name='startdate' id='startDate'>
                                                
                                                <label for='endDate' class='form-label'>End Date</label>
                                                <input type='date' class='form-control' name='enddate' id='endDate'>
                                            `;
                                        }
                                        function removeDateFields() {
                                            var dateFieldsDiv = document.getElementById('dateFields');
                                            dateFieldsDiv.innerHTML = '';
                                        }
                                    </script>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class='col-md-6'>
                        <div class='card h-100'>
                            <div class='card-header'>
                                <span><i class='bi bi-table me-2'></i></span>Machines 
                            </div>
                            <div class='row g-3 card-body'>
                                <div class='col-md-12'>
                                    <label for='area' class='form-label'>Area</label>
                                    <select name='area' id='area' class='form-select' aria-label='Default select example'>
                                        <option></option>
HTML;

                            $stmtArea = $dbh->connect()->prepare('SELECT id_area, nm_area FROM area');
                            $stmtArea->execute();
                            $ResultArea = $stmtArea->fetchAll(PDO::FETCH_ASSOC);
                            foreach ($ResultArea as $ResultArea) {
                                echo "<option value='{$ResultArea['id_area']}'>{$ResultArea['nm_area']}</option>";
                            }

        echo <<<HTML
                                    </select>        
                                </div>
                                <div class='col-md-12'>
                                    <div id='machineFields'></div>
                                    <script src='../libraries/getStation.js'></script>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class='col-12 mt-3'>
                        <div class='card'>
                            <div class='card-body text-end'>
                                <button class='btn btn-primary' value='submit' type='submit'>Go</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</main>
HTML;
    }
}
?>