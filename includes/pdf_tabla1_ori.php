<?php
require('../libraries/fpdf/mc_table.php');

//$currentDate = date('Y-m-d');
$currentDate = '2021-08-18';

$user = $_SESSION["name_user"];

$stmtNumMachine = $dbh->connect()->prepare($consultas['basic']['countMachines']);
$stmtNumMachine->bindParam(1, $area);
$stmtNumMachine->execute();
$ResultNunMachine = $stmtNumMachine->fetchAll();
$machineCount = $ResultNunMachine[0]['countmachines'];

$stmtMachine = $dbh->connect()->prepare($consultas['basic']['stationName']);
$stmtMachine->bindParam(1, $area);
$stmtMachine->execute();
$resultsMachine = $stmtMachine->fetchAll(PDO::FETCH_ASSOC);
ob_start();

// Function to adjust text within a cell
function CellFitSpace($pdf, $w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false) {
    $str_width = $pdf->GetStringWidth($txt);
    if ($w == 0) {
        $w = $pdf->w - $pdf->rMargin - $pdf->x;
    }
    if ($str_width > $w) {
        $txt = substr($txt, 0, floor($w / $pdf->GetStringWidth(' ')));
    }
    $pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill);
}

// Function to add a table to the page
//function addTable($pdf, $tableTitle, $currentDate, $rasonTimesAM, $rasonTimesPM, $userNameAM, $userNamePM) {
    function addTable($pdf, $tableTitle, $currentDate) {
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, $tableTitle, 0, 1, 'C');
    $pdf->SetFont('Arial', '', 16);
    $pdf->Cell(0, 10, 'Prep Date : ' . $currentDate , 0, 1, 'C');
    $pdf->SetFont('Arial', '', 14);
    $pdf->Cell(0, 10, 'Shift Definitions:', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'A: 6:00 - 10:00 am / B: 10:30 am - 2:30 pm / C: 2:30 - 6:30pm / D: 7:00 - 11:00 pm Working Section', 0, 1, 'C');
    $pdf->Ln(5);

    // Set column widths based on the image structure
    $pdf->SetWidths(array(15, 20, 10, 30, 30, 45, 30, 90));

    // Table header
    $pdf->SetFont('Arial', 'B', 10);
    $pdf->Row(array(
        'Cart #', 
        'Operator', 
        'Shift', 
        '# of Pass_Start', 
        '# of Pass_End', 
        'Deficiencies (# of Edge)', 
        'Downtime (min)', 
        'Note (Downtime Mins/ Reason)'
    ));

    // AM row
    /*$pdf->SetFont('Arial', '', 8);
    $downtimeReasonAM = implode(', ', $rasonTimesAM);
    $pdf->Row(array(
        '', 
        'AM', 
        $userNameAM, 
        'A', 
        '1', 
        '100', 
        '', 
        '', 
        '', 
        $downtimeReasonAM
    ));

    // PM row
    $downtimeReasonPM = implode(', ', $rasonTimesPM);
    $pdf->Row(array(
        '', 
        'PM', 
        $userNamePM, 
        '', 
        '', 
        '', 
        '', 
        '', 
        '', 
        $downtimeReasonPM
    ));*/
}

// Generate the PDF in Landscape orientation
$pdf = new PDF_MC_Table('L');  // 'L' indicates Landscape (horizontal)

// Generate multiple pages with tables
foreach ($resultsMachine as $resultsMachines) {
    $tableTitle = "Door & Gable_Edge Bander Tracking " . $resultsMachines['nm_station'];
    $nm_station = $resultsMachines['nm_station'];

    $stmtCarts = $dbh->connect()->prepare($consultas['details']['queryComments']);
    $stmtCarts->bindParam(':area', $area);
    $stmtCarts->execute();

    echo $area ;

    $pdf->SetFont('Arial', '', 8);
while ($row = $stmtCarts->fetch(PDO::FETCH_ASSOC)) {
    $pdf->Row(array(
        $row['id_cart'], 
        $row['user_id'], 
        $row['id_station'], 
        $row['time_start'], 
        $row['time_finish'], 
        $row['id_comment']
    ));
}
    /*$userIdAM = null;
    $userNameAM = null;
    $userIdPM = null;
    $userNamePM = null;

    /*while ($row = $stmtOperators->fetch(PDO::FETCH_ASSOC)) {
        if ($row['turno_periodo'] == 'AM') {
            $userIdAM = $row['user_id'];
            $userNameAM = $row['name_user'];
        } elseif ($row['turno_periodo'] == 'PM') {
            $userIdPM = $row['user_id'];
            $userNamePM = $row['name_user'];
        }
    }

    $stmtTimes = $dbh->connect()->prepare($consultas['details']['queryTimes']);
    $stmtTimes->bindParam(':nm_station', $resultsMachines['nm_station']);
    $stmtTimes->bindParam(':currentDate', $currentDate);
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
    }*/

    //addTable($pdf, $tableTitle, $currentDate, $rasonTimesAM, $rasonTimesPM, $userNameAM, $userNamePM);
    addTable($pdf, $tableTitle, $currentDate);
}

// Clean the output buffer
ob_clean();

$baseFileName = 'dtr_all_machines';
$_SESSION["baseFileName"] = $baseFileName;
$fileName = $baseFileName . '_user_' . $user . '.pdf';
$filePath = '../uploads/reports/' . $fileName;

// Output the PDF
$pdf->Output('F', $filePath);
header("location: ../views/reportspdfview.php");
?>
