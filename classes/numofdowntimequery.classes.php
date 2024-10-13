<?php 
require_once 'dbh.classes.php';

session_start();

class numdowntimeQuery {

    public function queryDowntime() {
        $dbh = new Dbh();
        require('../queries/downtime.query.php');
        // Retrieve and sanitize input from POST
        $option = filter_input(INPUT_POST, 'option', FILTER_UNSAFE_RAW);
        $area = filter_input(INPUT_POST, 'area', FILTER_VALIDATE_INT);
        $machine = filter_input(INPUT_POST, 'machine', FILTER_VALIDATE_INT);

        var_dump($_POST);
        echo "<br>";
        echo "- - - - - - - - - - - - - - - - - - - - ";
        echo "<br>";
        

        // Error messages array
        $errors = [];

        // Validate options
        if ($option === 'daily') {

            if ($machine == 0) {
                echo "Daily date and all machines." . "<br>";
                echo "Area: " . $area . "<br>";
                include_once '../includes/pdf_tabla1.php';
            } else {
                echo "Daily date and selected machine.  tabla 2" . "<br>";
                echo $option . "<br>";
                echo $area . "<br>";
                echo $machine . "<br>";
                include_once '../includes/pdf_tabla2.php';

            }

        } elseif ($option === 'yesterday') {
            if ($machine == 0) {
                echo "Yesterday's date and all machines.";
                include_once '../includes/pdf_tabla3.php';
            } else {
                echo "Yesterday's date and selected machine.";
                include_once '../includes/pdf_tabla4.php';
            }
        } else {
            $startDate = filter_input(INPUT_POST, 'startdate', FILTER_UNSAFE_RAW);
            $endDate = filter_input(INPUT_POST, 'enddate', FILTER_UNSAFE_RAW);

            // Check that both dates are provided and not empty
            if (empty($startDate) || empty($endDate)) {
                $_SESSION['status'] = "Both 'startdate' and 'enddate' must be set.";
                header("location: ../views/numofdowntimeview.php");
                exit();
            }

            // Validate the date format
            if (!$this->isDateValid($startDate)) {
                $_SESSION['status'] = "'startdate' has an invalid format or value.";
                header("location: ../views/numofdowntimeview.php");
                exit();
            }

            if (!$this->isDateValid($endDate)) {
                $_SESSION['status'] = "'enddate' has an invalid format or value.";
                header("location: ../views/numofdowntimeview.php");
                exit();
            }

            try {
                $startDateObj = new DateTime($startDate);
                $endDateObj = new DateTime($endDate);
                $currentDate = new DateTime();

                if ($startDateObj > $currentDate) {
                    $_SESSION['status'] = "'startdate' cannot be a future date.";
                    header("location: ../views/numofdowntimeview.php");
                    exit();
                }

                if ($endDateObj < $startDateObj) {
                    $_SESSION['status'] = "'enddate' cannot be earlier than 'startdate'.";
                    header("location: ../views/numofdowntimeview.php");
                    exit();
                }

            } catch (Exception $e) {
                $_SESSION['status'] = "Error parsing dates: " . $e->getMessage();
                header("location: ../views/numofdowntimeview.php");
                exit();
            }

            //$_SESSION['status'] = "Both dates are set, valid, and meet the specified conditions.";

            if ($machine == 0) {
                echo "Date range and all machines.";
                echo $startDate . "<br>";
                echo $endDate . "<br>";
                include_once '../includes/pdf_tabla5.php';
            } else {
                echo $startDate . "<br>";
                echo $endDate . "<br>";
                echo "Date range and selected machine.";
                include_once '../includes/pdf_tabla6.php';
            }
        }
    }

    private function isDateValid($date) {
        $regex = '/^\d{4}-\d{2}-\d{2}$/';
        if (!preg_match($regex, $date)) {
            return false;
        }
        [$year, $month, $day] = explode('-', $date);
        return checkdate((int)$month, (int)$day, (int)$year);
    }
}

$getDowntimeCount = new numdowntimeQuery;
$getDowntimeCount->queryDowntime();
?>
