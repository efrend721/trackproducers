<?php
   require('../libraries/fpdf/mc_table.php');
   
   
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
   function CellFitSpace($pdf, $w, $h=0, $txt='', $border=0, $ln=0, $align='', $fill=false)
   {
       // Get the width of the text
       $str_width = $pdf->GetStringWidth($txt);
   
       // Calculate the necessary spacing
       if($w == 0) {
           $w = $pdf->w - $pdf->rMargin - $pdf->x;
       }
   
       if($str_width > $w) {
           $txt = substr($txt, 0, floor($w / $pdf->GetStringWidth(' ')));
       }
   
       // Print the cell
       $pdf->Cell($w, $h, $txt, $border, $ln, $align, $fill);
   }
   // Function to add a table to the page
   function addTable($pdf, $tableTitle, $startDate, $endDate, $rasonTimesAM, $rasonTimesPM, $userNameAM, $userNamePM) {
       // Page header
       $pdf->AddPage();
       $pdf->SetFont('Arial','B',16);
       $pdf->Cell(0,10,$tableTitle,0,1,'C');
       $pdf->Ln(10);
       
       // Set column widths
       $pdf->SetWidths(array(30, 20, 60, 25, 25, 110));
   
       // Table header
       $pdf->SetFont('Arial','B',10);
       $pdf->Row(array('DATE', 'SHIFT', 'OPERATOR', 'PASSES', 'MINS', 'DOWNTIME MINS / REASON'));
   
       // AM row
       $pdf->SetFont('Arial','',10);
       $downtimeReasonAM = implode(', ', $rasonTimesAM);
       $pdf->Row(array($startDate . ' - ' . $endDate, 'AM', $userNameAM, '', '', $downtimeReasonAM));
   
       // PM row
       $downtimeReasonPM = implode(', ', $rasonTimesPM);
       $pdf->Row(array($startDate . ' - ' . $endDate, 'PM', $userNamePM, '', '', $downtimeReasonPM));
   }
   // Generate the PDF in Landscape orientation
   $pdf = new PDF_MC_Table('L');  // 'L' indicates Landscape (horizontal)
   // Generate multiple pages with tables
   foreach($resultsMachine as $resultsMachines) {
       $tableTitle = "Number of Downtime for Machine " . $resultsMachines['nm_station'];
       // Get the operators for the current machine
       $nm_station = $resultsMachines['nm_station'];
       $stmtOperators = $dbh->connect()->prepare($consultas['details']['queryOperatorsRangeDates']);
       $stmtOperators->bindParam(':nm_station', $nm_station);
       $stmtOperators->bindParam(':startDate', $startDate);
       $stmtOperators->bindParam(':endDate', $endDate);
       $stmtOperators->execute();
   
       // Variables to store results
       $userIdAM = null;
       $userNameAM = null;
       $userIdPM = null;
       $userNamePM = null;
   
       // Fetch inside the while loop
       while ($row = $stmtOperators->fetch(PDO::FETCH_ASSOC)) {
           if ($row['turno_periodo'] == 'AM') {
               $userIdAM = $row['user_id'];
               $userNameAM = $row['name_user'];
           } elseif ($row['turno_periodo'] == 'PM') {
               $userIdPM = $row['user_id'];
               $userNamePM = $row['name_user'];
           }
       }
       // Get the activity times for the current machine and specified date
       $stmtTimes = $dbh->connect()->prepare($consultas['details']['queryTimesRangeDates']);
       $stmtTimes->bindParam(':nm_station', $resultsMachines['nm_station']);
       $stmtTimes->bindParam(':startDate', $startDate);
       $stmtTimes->bindParam(':endDate', $endDate);
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
   
       addTable($pdf, $tableTitle, $startDate, $endDate, $rasonTimesAM, $rasonTimesPM, $userNameAM, $userNamePM);
   }
// Clean the output buffer
ob_clean();
   
$baseFileName = 'dtr_all_range_date_machines'; //Abbreviation for "downtime_report_daylyall_machine"
$_SESSION["baseFileName"] = $baseFileName;

// Generate the file name by concatenating the base name with the user ID
$fileName = $baseFileName . '_user_' . $user . '.pdf';

// Define the full path for the file
$filePath = '../uploads/reports/' . $fileName;

// Now you can use ob_clean or other functions with the generated file path

// Output the PDF
$pdf->Output('F', $filePath);
header ("location: ../views/reportspdfview.php") // Guarda el PDF en el servidor
   
?>

    



    


