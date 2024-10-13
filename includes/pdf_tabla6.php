<?php
require('../libraries/fpdf/mc_table.php');



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

// Function to determine shift based on time_start
function determineShift($time_start) {
    $time = strtotime($time_start);
    if ($time >= strtotime('06:00:00') && $time < strtotime('10:00:00')) {
        return 'A';
    } elseif ($time >= strtotime('10:00:01') && $time < strtotime('14:30:00')) {
        return 'B';
    } elseif ($time >= strtotime('14:30:01') && $time < strtotime('18:30:00')) {
        return 'C';
    } elseif ($time >= strtotime('18:30:01') && $time < strtotime('23:00:00')) {
        return 'D';
    } else {
        return 'Unknown Shift';
    }
}
// Function to determine number of passes
function determineNumPass($numPass) {
    return $numPass;
}

// Function to determine number of passes at the end
function determineNumPassEnd($numPassEnd) {
    return $numPassEnd;
}

// Funtion to determine deficiencies
function determineDeficiencies($deficiencies) {
    return $deficiencies;
}

// Function to add a table to the page
function addTable($pdf, $tableTitle, $startDate, $endDate) {
    $pdf->AddPage();
    $pdf->SetFont('Arial', 'B', 16);
    $pdf->Cell(0, 10, $tableTitle, 0, 1, 'C');
    $pdf->SetFont('Arial', '', 16);
    $pdf->Cell(0, 10, 'Prep Date : ' . $startDate . ' / ' . $endDate , 0, 1, 'C');
    $pdf->SetFont('Arial', '', 14);
    $pdf->Cell(0, 10, 'Shift Definitions:', 0, 1, 'C');
    $pdf->SetFont('Arial', '', 12);
    $pdf->Cell(0, 10, 'A: 6:00 - 10:00 am / B: 10:30 am - 2:30 pm / C: 2:30 - 6:30pm / D: 7:00 - 11:00 pm Working Section', 0, 1, 'C');
    $pdf->Ln(5);

    // Set column widths based on the image structure
    $pdf->SetWidths(array(15, 20, 10, 30, 30, 45, 30, 100));

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
}

// Generate the PDF in Landscape orientation
$pdf = new PDF_MC_Table('L');  // 'L' indicates Landscape (horizontal)

// Generate multiple pages with tables

    $tableTitle = "Door & Gable_Edge Bander Tracking " . $nm_station;
    //$nm_station = $resultsMachines['nm_station'];

    $stmtCarts = $dbh->connect()->prepare($consultas['details']['queryCommentSingleMachineRangeDate']);
    $stmtCarts->bindParam(1, $area);
    $stmtCarts->bindParam(2, $machine);
    $stmtCarts->bindParam(3, $startDate);
    $stmtCarts->bindParam(4, $endDate);
    $stmtCarts->execute();

    // Add table header once per machine
    addTable($pdf, $tableTitle, $startDate, $endDate);

    $pdf->SetFont('Arial', '', 8);
    while ($row = $stmtCarts->fetch(PDO::FETCH_ASSOC)) {
        $shift = determineShift($row['time_start']);
        $numPass = determineNumPass('');
        $numPassEnd = determineNumPassEnd('');
        $deficiencies = determineDeficiencies('');
        $pdf->Row(array(
            $row['id_cart'], 
            $row['user_id'], 
            $shift, 
            $numPass, 
            $numPassEnd,
            $deficiencies, 
            $row['total_elapsed_time'],
            $row['nm_comments']
        ));
    }


// Clean the output buffer
ob_clean();

$baseFileName = 'dtr_range_date_single_machines';
$_SESSION["baseFileName"] = $baseFileName;
$fileName = $baseFileName . '_user_' . $user . '.pdf';
$filePath = '../uploads/reports/' . $fileName;

// Output the PDF
$pdf->Output('F', $filePath);
header("location: ../views/reportspdfview.php");
exit();
?>
