<?php
require('../libraries/fpdf/mc_table.php');

$currentDateOriginal = new DateTime();
$currentDateOriginal->modify('-1 day');
$currentDate = $currentDateOriginal->format('Y-m-d');

$user = $_SESSION["name_user"];

$stmtNumMachine = $dbh->connect()->prepare($consultas['basic']['countMachines']);
$stmtNumMachine->bindParam(1, $area);
$stmtNumMachine->execute();
$ResultNunMachine = $stmtNumMachine->fetch(PDO::FETCH_ASSOC);
$machineCount = $ResultNunMachine['countmachines'];

$stmtMachine = $dbh->connect()->prepare($consultas['basic']['singleMachine']);
$stmtMachine->bindParam(1, $area);
$stmtMachine->bindParam(2, $machine);
$stmtMachine->execute();
$resultsMachine = $stmtMachine->fetch(PDO::FETCH_ASSOC);
$nm_station = $resultsMachine['nm_station'];


ob_start();

function CellFitSpace($pdf, $w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false) {
    $str_width = $pdf->GetStringWidth($txt);
    if($w == 0) {
        $w = $pdf->w - $pdf->rMargin - $pdf->x;
    }
    if($str_width > $w) {
        $txt = substr($txt, 0, floor($w / $pdf->GetStringWidth(' ')));
    }
    $pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill);
}

function addTable($pdf, $tableTitle, $currentDate, $rasonTimesAM, $rasonTimesPM, $userNameAM, $userNamePM) {
    $pdf->AddPage();
    $pdf->SetFont('Arial','B',16);
    $pdf->Cell(0,10,$tableTitle,0,1,'C');
    $pdf->Ln(10);
    $pdf->SetWidths(array(30, 20, 60, 25, 25, 110));
    $pdf->SetFont('Arial','B',10);
    $pdf->Row(array('DATE', 'SHIFT', 'OPERATOR', 'PASSES', 'MINS', 'DOWNTIME MINS / REASON'));
    $pdf->SetFont('Arial','',10);
    $downtimeReasonAM = implode(', ', $rasonTimesAM);
    $pdf->Row(array($currentDate, 'AM', $userNameAM, '', '', $downtimeReasonAM));
    $downtimeReasonPM = implode(', ', $rasonTimesPM);
    $pdf->Row(array($currentDate, 'PM', $userNamePM, '', '', $downtimeReasonPM));
}

$pdf = new PDF_MC_Table('L');

$tableTitle = "Number of Downtime for Machine " . $nm_station;

$stmtOperators = $dbh->connect()->prepare($consultas['details']['queryOperators']);
$stmtOperators->bindParam(':nm_station', $nm_station, PDO::PARAM_STR);
$stmtOperators->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);


$stmtOperators->execute();

$userIdAM = null;
$userNameAM = null;
$userIdPM = null;
$userNamePM = null;

while ($row = $stmtOperators->fetch(PDO::FETCH_ASSOC)) {
    if ($row['turno_periodo'] == 'AM') {
        $userIdAM = $row['user_id'];
        $userNameAM = $row['name_user'];
    } elseif ($row['turno_periodo'] == 'PM') {
        $userIdPM = $row['user_id'];
        $userNamePM = $row['name_user'];
    }
}

$stmtTimes = $dbh->connect()->prepare($consultas['details']['queryTimes']);
$stmtTimes->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
$stmtTimes->bindParam(':nm_station', $nm_station, PDO::PARAM_STR);
$stmtTimes->execute();

$timeResults = $stmtTimes->fetchAll(PDO::FETCH_ASSOC);
$rasonTimesAM = [];
$rasonTimesPM = [];

foreach ($timeResults as $row) {
    if ($row['shift'] == 'AM') {
        $rasonTimesAM[] = $row['nm_comment'] . ' ' . $row['total_elapsed_time'];
    } else {
        $rasonTimesPM[] = $row['nm_comment'] . ' ' . $row['total_elapsed_time'];
    }
}

addTable($pdf, $tableTitle, $currentDate, $rasonTimesAM, $rasonTimesPM, $userNameAM, $userNamePM);

ob_clean();

$baseFileName = 'dtr_yest_single_machines'; // Abbreviation for "downtime_report_daylyall_machine"
$_SESSION["baseFileName"] = $baseFileName;

// Generate the file name by concatenating the base name with the user ID
$fileName = $baseFileName . '_user_' . $user . '.pdf';

// Define the full path for the file
$filePath = '../uploads/reports/' . $fileName;

// Output the PDF
$pdf->Output('F', $filePath);
header("Location: ../views/reportspdfview.php");
exit();
?>
