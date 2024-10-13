<?php
require_once 'dbh.classes.php';
//include_once 'userstate.classes.php';
//session_start();

class LanguageMain {
    public function setLanguage() {
        
        //var_dump(session_name());
        //var_dump($userid);
        $dbh = new Dbh();
        //$userid = null;
        $userid = $_SESSION['user_id'];
        $language = null;
                     
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            if (isset($_POST['language'])) {
                $language = $_POST['language'];
                $stmtUpdateLang = $dbh->connect()->prepare("UPDATE user SET language = '$language' WHERE user_id  = '$userid'");
                $stmtUpdateLang->execute();
                $stmtUpdateLang = null;
                $_SESSION['status'] = "Language saved successfully";
              
            }
        }    
        echo "<main class='mt-5 pt-3'>
                <div class='container-fluid'>";
                if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    $mensage = $_SESSION['status'];
                    $statusMap = [
                        "Language saved successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
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
                                <span><i class='bi bi-table me-2'></i></span>Language 
                            </div>
                            <div class='row g-3 card-body'>
                                <div class='col-md-2'>
                                    <label for='language' class='form-label'>Language</label>
                                    <div class='d-flex justify-content-between align-items-center'>";
                                        echo "<select name='language' id='language' class='form-select w-100'>";
                                        $stmtlanguage = $dbh->connect()->prepare("SELECT language FROM user where user_id = '$userid'");
                                        $stmtlanguage->execute();
                                        $Resultlanguage = $stmtlanguage->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($Resultlanguage as $Resultlanguage) {
                                            $otherLang = ($Resultlanguage['language'] == 'en') ? 'Mandarin' : 'English';
                                            $valueotherLang = ($Resultlanguage['language'] == 'en') ? 'zh' : 'en';
                                            $lang = ($Resultlanguage['language'] == 'en') ? 'English' : 'Mandarin';
                                            $valueLang = ($Resultlanguage['language'] == 'en') ? 'en' : 'zh';
                                            echo "<option value = '$valueLang' size='10'>$lang</option>
                                            <option value = '$valueotherLang'>$otherLang</option>";
                                        }
                                        echo "</select></div>
                                </div>
                                                               
                                <div class='col-md-'>
                                    <button class='btn btn-primary' name='action' value='save' type='submit'>Save</button>
                                </div>
                            </div>    
                        </div>";
                    echo "</form>";
            echo "</div>
        </main>\n";
    }
}

