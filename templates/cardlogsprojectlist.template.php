<?php 
echo "
<div class='card'>
    <form action='../views/projectlistaddlogview.php' method='POST'>

        <div class='card-header'>
            <span><i class='bi bi-table me-2'></i></span>Logs
            <button type='submit' 
                    name='newnote'
                    value = '$result[id_project]'   
                    class='btn btn-light btn-sm float-end'>
                    New Log
            </button>
        </div>
    </form>       
    <form action='../views/projectlistphotoview.php' method='POST'>
    <div class='card-body'> 
        <input type='hidden' name='idjobViewphoto' value='$idjob'>";
            //include_once('../queries/projectlist.query.php');
            $stmtnote = $dbh->connect()->prepare($projectlistquery['details']['allNote']);    
            $stmtnote->bindParam(1, $idjob , PDO::PARAM_INT) ;
            $stmtnote->bindParam(2, $user_id , PDO::PARAM_STR) ;
            $stmtnote->execute();
            $resultsnote = $stmtnote->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultsnote as $resultnote) {
                
                echo "<div class='shadow rounded-3' style='$calloutinfo'>
                        <h5 style='$stylelogh5'>Log: <strong>$resultnote[des_note]</strong></h5>";
                        if ($resultnote['additional_note'] != '') {
                            echo "<h5 style='$stylelog'>Additional Note: $resultnote[additional_note]</h5>";
                        }
                        $idNote = $resultnote['id_note'];
                        //include_once('../queries/projectlist.query.php');
                        $stmtnotephoto = $dbh->connect()->prepare($projectlistquery['details']['photoNote']);
                        $stmtnotephoto->bindParam(1, $idNote , PDO::PARAM_INT) ;
                        $stmtnotephoto->bindParam(2, $idjob , PDO::PARAM_INT) ;
                        $stmtnotephoto->bindParam(3, $user_id , PDO::PARAM_STR) ;
                        $stmtnotephoto->execute();
                        $resultsnotephoto = $stmtnotephoto->fetchAll(PDO::FETCH_ASSOC);
                       
                            echo "<div class='photo-grid'>";
                            foreach ($resultsnotephoto as $resultnotephoto) {
                                $photoUrl =  htmlspecialchars($resultnotephoto['photo']);
                                if ($photoUrl != '') {
                                    echo "<button type='submit' 
                                                name='photoview'
                                                class='btn btn-primary float-end' 
                                                value='$photoUrl'
                                                >
                                                View Photo
                                    </button>";
                                }
                            }
                echo "</div>";
                        
                    
                        
                echo "<hr>
                    <h5 style='$stylelog'>User: <strong>$resultnote[name_user]</strong></h5>
                    <h5 style='$stylelog'>Date: $resultnote[date_note]</h5>        
                </div>";
            }
            //include_once('../queries/projectlist.query.php');
            $stmtcomment = $dbh->connect()->prepare($projectlistquery['details']['commentQuery']);
            $stmtcomment->bindParam(1, $idjob , PDO::PARAM_INT) ;            
            $stmtcomment->execute();
            $resultscomment = $stmtcomment->fetchAll(PDO::FETCH_ASSOC);
            foreach($resultscomment as $resultcomment) {
                
                echo "<div class='shadow rounded-3' style='$calloutinfo'>
                        <h5 style='$stylelogh5'>Log: <strong>$resultcomment[nm_comment]</strong></h5>               
                        <hr>
                        <h5 style='$stylelog'>User: <strong>$resultcomment[name_user]</strong> On <strong>$resultcomment[nm_dept]</strong>, Station: <strong>$resultcomment[id_station]</strong></h5>
                        <h5 style='$stylelog'>Date & Time: $resultcomment[date_comment] By $resultcomment[elapsed_time] Minutes.</h5>        
                    </div>";

            }   
        echo "</div>
    </form>
</div>";
?>