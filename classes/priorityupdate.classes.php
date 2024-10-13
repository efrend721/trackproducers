<?php
require_once 'dbh.classes.php';

class ProjectDetails
{

    public $id;
    public function __construct($id = null)
    {
        if ($id === null) {
            $id = $_GET['ref'];
        }

        $id = $_GET['ref'];
        $this->id = $id;
    }

    public function display()
    {
        $dbh = new Dbh();

        $stmt2 = $dbh->connect()->prepare("SELECT project.id_project, priority.nm_priority, 
                                            project.date, project.address, project.piece,
                                            status_project.nm_status_project
                                            FROM project, priority, state_project, status_project 
                                            WHERE project.id_project = state_project.id_project 
                                            AND project.id_priority = priority.id_priority
                                            AND state_project.id_status_project = status_project.id_status_project
                                             AND project.id_project = '{$this->id}' ORDER BY project.id_priority ASC, project.date DESC");

        $stmt2->execute();
        $ResultProject = $stmt2->fetchAll(PDO::FETCH_ASSOC);

        //foreach ($ResultProject as $ResultProject) {
        //Modal
        echo "<div class='modal fade' id='updatedata' tabindex='-1' aria-labelledby='updatedataLabel' aria-hidden='true'>
            <div class='modal-dialog modal-lg'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='updatedataLabel'>Update Priority</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <form action='../classes/priorityupdatesingle.classes.php' method='POST'>
                        <div class='modal-body'>
                            <div class='form-group mb-3'>
                                <label for=''>Priority</label>
                                <input type='text' name='idproject' id='idproject' class='form-control' readonly = 'true' value='{$this->id}'>
        
                            </div>
        
        
                            <div class='form-group mb-3'>
                                <label for=''>Priority</label>";
                                
                                echo "<select name='priority' id='priority' class='form-select' aria-label='Default select example'>
                                        <option></option>";
                                $stmt3 = $dbh->connect()->prepare('SELECT id_priority, nm_priority FROM priority ');
                                $stmt3->execute();
                                $ResultProject1 = $stmt3->fetchAll(PDO::FETCH_ASSOC);
                                foreach ($ResultProject1 as $ResultProject1) {
                                    echo "<option value = {$ResultProject1['id_priority']}>{$ResultProject1['nm_priority']}</option>";
                                }
                                echo "</select>";




                            echo "</div>
                        </div>
                        <div class='modal-footer'>
                            <button type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</button>
                            <button type='submit' name='update' class='btn btn-primary'>Update</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>";
        //End Modal    

        echo "<main class='mt-5 pt-4'>
                <div class='container-fluid'>
                <div class='row' >
                
                <div class='col-md-12 mb-2'> ";
                if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
                    echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <strong>' . $_SESSION['status'] . '</strong>
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        </div>';
                    unset($_SESSION['status']);
                }
                
                echo " <div class='card'>
                   
                        <div class='card-header'>
                            <span><i class='bi bi-table me-2'></i></span>
                            Project N. {$this->id}
                        </div>
                        <div class='card-body'>
                            <div class='table-responsive'>
                            <form action='../classes/priorityupdatesingle.classes.php' method='post'> 
                                <table id='example' class='table table-striped' style='width: 100%'>
                                    <thead>
                                        <tr>
                                            <th>Id</th>
                                            <th>Priority</th>
                                            <th>Date</th>
                                            <th>Address</th>
                                            <th>Piece</th>
                                            <th>Status</th>
                                            <th>Update Priority</th>
                                        </tr>
                                    </thead>
                                    <tbody>";
                                 echo "<tr>
                                <td>{$ResultProject[0]['id_project']}</td>
                                <td>{$ResultProject[0]['nm_priority']}</td>
                                <td>{$ResultProject[0]['date']}</td>
                                <td>{$ResultProject[0]['address']}</td>
                                <td>{$ResultProject[0]['piece']}</td>
                                <td>{$ResultProject[0]['nm_status_project']}</td>
                                <td><button type='button' class='btn btn-primary float-end' data-bs-toggle='modal' data-bs-target='#updatedata'>
                                    Update
                                    </button>
                                </td>
                                </tr>";
                                echo "
                                </tbody>
                                
                            </table>
                        </form> 
                    </div>
                </div>
            </div>
            </div>
            </div>
        </div>
    </main>\n";
    }
}
