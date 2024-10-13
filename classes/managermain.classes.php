<?php 
require_once 'dbh.classes.php';


class ManagerMain {
    public function getManagerquery() {
        $dbh = new Dbh();
        $stmtquerygoal = $dbh->connect()->prepare("SELECT job_month, job_week, job_day FROM settings ");
        $stmtquerygoal->execute();
        $rowquerygoal = $stmtquerygoal->fetchAll(PDO::FETCH_ASSOC);
        $jobMonth = $rowquerygoal[0]['job_month'];
        $jobWeek = $rowquerygoal[0]['job_week'];
        $jobDay = $rowquerygoal[0]['job_day'];
        
        echo "<main class='mt-5 pt-3'>
        <div class='container-fluid'>
          <div class='row'>
            <div class='col-md-12'>
              <h4>Dashboard</h4>
            </div>
          </div>";
          $stmtQueryProyection = $dbh->connect()->prepare("SELECT SUM(CASE WHEN YEAR(date_comment) = 2024 THEN 1 ELSE 0 END) AS TotalYear, 
                                                           SUM(CASE WHEN MONTH(date_comment) = MONTH(CURDATE()) AND YEAR(date_comment) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS TotalMonth,   
                                                           SUM(CASE WHEN WEEK(date_comment) = WEEK(CURDATE()) AND YEAR(date_comment) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS TotalWeek,   
                                                           SUM(CASE WHEN DAY(date_comment) = DAY(CURDATE()) AND MONTH(date_comment) = MONTH(CURDATE()) AND YEAR(date_comment) = YEAR(CURDATE()) THEN 1 ELSE 0 END) AS TotalDay 
                                                           FROM state_project 
                                                           WHERE id_status_project IN (1) 
                                                           AND date_comment >= CONCAT(YEAR(CURDATE()), '-01-01') 
                                                           AND date_comment <= CONCAT(YEAR(CURDATE()), '-12-31')");
          $stmtQueryProyection->execute();
          $rowQueryProyection = $stmtQueryProyection->fetchAll(PDO::FETCH_ASSOC);
          $totalYear = $rowQueryProyection[0]['TotalYear'];
          $totalMonth = $rowQueryProyection[0]['TotalMonth'];
          $totalWeek = $rowQueryProyection[0]['TotalWeek'];
          $totalDay = $rowQueryProyection[0]['TotalDay'];
          echo "<div class='row'>";
          $periods = [
            ['total' => $totalYear, 'goal' => 100, 'time' => 'Yearly'],
            ['total' => $totalMonth, 'goal' => $jobMonth, 'time' => 'Monthly'],
            ['total' => $totalWeek, 'goal' => $jobWeek, 'time' => 'Weekly'],
            ['total' => $totalDay, 'goal' => $jobDay, 'time' => 'Daily'],
          ];
          foreach ($periods as $period) {
            $total = $period['total'];
            $goal = $period['goal'];
            $time = $period['time'];
            $percentage = ($total / $goal) * 100;
            $percentage = !is_int($percentage) ? round($percentage) : $percentage;
            $percentage = $percentage < 0 ? 0 : $percentage;
            echo "<div class='col-sm-3 col-md-3 mb-3'>
              <div class='card bg-primary text-white h-100'>
                <script>
                  document.addEventListener('DOMContentLoaded', function() {
                    var idCirculeValue = 0.$percentage; ;
                    var myProgressbar = '#myProgressbar$time';
                    console.log(myProgressbar);  
                    var myProgressBar = new CustomProgressBar(myProgressbar, idCirculeValue );
                  });
                </script>
                  <div class='card-body py-2'>
                    $time
                    <div id='myProgressbar$time' class='progress-circle'></div>
                  </div>
                </div>
              </div>";
          }
          echo "</div>";
          echo "<div class='row'>";
          $stmtQueryDept = $dbh->connect()->prepare("SELECT id_dept, nm_dept FROM dept ");
          $stmtQueryDept->execute();
          $rowQueryDept = $stmtQueryDept->fetchAll(PDO::FETCH_ASSOC);
          foreach ($rowQueryDept as $row) {
              $idDept = $row['id_dept'];
              $nmDept = $row['nm_dept'];    
              $stmtquerynum = $dbh->connect()->prepare("SELECT DISTINCT t.id_project  FROM task t 
                                                        JOIN area ON t.id_area = area.id_area 
                                                        JOIN dept ON area.id_dept = dept.id_dept 
                                                        WHERE dept.id_dept = $idDept 
                                                        AND NOT EXISTS (SELECT 1 FROM task t2  WHERE t2.id_project = t.id_project   
                                                        AND t2.id_status_station = 1) 
                                                        AND EXISTS (SELECT 1  FROM task t3  WHERE t3.id_project = t.id_project  
                                                        AND t3.id_status_station = 2)
                                                        ");
              $stmtquerynum->execute();
              $rowquerynum = $stmtquerynum->rowCount();
              echo "<div class='col-md-12 mb-3'>
                      <div class='card h-100'>
                        <div class='card-header'>
                          <span class='me-2'><i class='bi bi-bar-chart-fill'></i></span>
                          $nmDept Total Jobs $rowquerynum
                        </div>";
              $stmtQueryArea = $dbh->connect()->prepare("SELECT id_area, nm_area FROM area where id_dept = $idDept");
              $stmtQueryArea->execute();
              $rowsQueryArea = $stmtQueryArea->fetchAll(PDO::FETCH_ASSOC);
              // Initialize an empty array to store area names
              $areaNamesArray = [];
              $areaNumArray = [];
              // Loop through each row and add the area name to the array
              foreach ($rowsQueryArea as $row) {
                  $idArea = $row['id_area'];
                  $areaNamesArray[] = $row['nm_area'];
                  $stmtQueryAreaNum = $dbh->connect()->prepare("SELECT id_project FROM task 
                                                                WHERE id_area = $idArea and id_status_station = 2
                                                                ");
                  $stmtQueryAreaNum->execute();
                  $areaNumArray[] = $stmtQueryAreaNum->rowCount();
                  
              }
              // Convert the array to a JSON string
              $jsonAreaNames = json_encode($areaNamesArray);
              $jsonAreaNum = json_encode($areaNumArray);
              echo "<script>
                        document.addEventListener('DOMContentLoaded', function() {
                        var areaNames = $jsonAreaNames;
                        var areaNum = $jsonAreaNum;
                        var numJobsDone = $rowquerynum;
                        var idCanvas = $idDept;
                        let chartTable = new ChartManager('.chart', '.data-table', numJobsDone, idCanvas, areaNames, areaNum);
                        chartTable.initCharts();
                    });  
              </script>";
              
              echo "<div class='card-body'>
                    <canvas id='$idDept' data-num-jobs-done='$rowquerynum' data-area-names='$jsonAreaNames' data-area-num='$jsonAreaNum' class='chart' width='400' height='200'></canvas>
                  </div>
                </div>
              </div>
              ";

            }
                      
          echo "</div>";
          echo "</div>
          </main>\n
          ";
  
    }
    

}
?>


