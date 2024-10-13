<?php
require_once 'dbh.classes.php';

class ProjectGroupMain
{
    public function getProjectgroupquery()
    {
        $dbh = new Dbh();
        include_once '../includes/serverside.rendering.php';
        include '../queries/allprojects.query.php';

        // Define how many results per page
        $resultsPerPage = 5;

        // Get the current page number from the URL, default to 1 if not provided
        $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
        if ($page < 1) $page = 1;

        // Calculate the starting row for the SQL query
        $offset = ($page - 1) * $resultsPerPage;

        // Prepare the paginated query with LIMIT and OFFSET
        $stmt1 = $dbh->connect()->prepare($consultaAll['allprojects']['sqlAllProjects'] . " LIMIT :limit OFFSET :offset");
        $stmt1->bindParam(':limit', $resultsPerPage, PDO::PARAM_INT);
        $stmt1->bindParam(':offset', $offset, PDO::PARAM_INT);
        $stmt1->execute();

        // Count the total number of records for pagination
        $stmtCount = $dbh->connect()->prepare("SELECT COUNT(*) AS total FROM project");
        $stmtCount->execute();
        $totalRecords = $stmtCount->fetch(PDO::FETCH_ASSOC)['total'];

        // Calculate total pages
        $totalPages = ceil($totalRecords / $resultsPerPage);

        // Calculate the range of page numbers to display (5 links at a time)
        $linkLimit = 6; // Show 6 links at a time
        $startPage = max(1, $page - floor($linkLimit / 2)); // Start page for the links
        $endPage = min($totalPages, $startPage + $linkLimit - 1);

        // Adjust the start page if we are too close to the end
        if ($endPage - $startPage < $linkLimit - 1) {
            $startPage = max(1, $endPage - $linkLimit + 1);
        }

        echo <<<HTML
        <main class='mt-5 pt-3'>
            <div class='container-fluid'>
                <div class='row'>
                    <div class='col-md-12'>
                        <h4>Update Priorities by Group</h4>
                    </div>
                </div>
        HTML;

        include_once '../includes/mensages.php';

        echo <<<HTML
            <div class='row'>
                <div class='col-md-12'>
        HTML;

        if ($devise == 'mobile') {
            include_once '../templates/mobile/updateprioritygroup.template.php';
        } else {
            include_once '../templates/updateprioritygroup.template.php';
        }

        $pagination = <<<HTML
        <br>
        <div class="card">
            <div class="card-body">
                <nav>
                    <ul class="pagination">
        HTML;
        
        // Enlace a la página anterior
        if ($page > 1) {
            $pagination .= '<li class="page-item"><a class="page-link" href="?page=' . ($page - 1) . '">Previous</a></li>';
        }
        
        // Enlaces a los números de página (mostrando 6 a la vez)
        for ($i = $startPage; $i <= $endPage; $i++) {
            if ($i == $page) {
                $pagination .= '<li class="page-item active"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            } else {
                $pagination .= '<li class="page-item"><a class="page-link" href="?page=' . $i . '">' . $i . '</a></li>';
            }
        }
        
        // Enlace a la siguiente página
        if ($page < $totalPages) {
            $pagination .= '<li class="page-item"><a class="page-link" href="?page=' . ($page + 1) . '">Next</a></li>';
        }
        
        $pagination .= <<<HTML
                    </ul>
                </nav>
            </div>
        </div>
        HTML;
        
        echo $pagination;
        

        echo <<<HTML
                </div>
            </div>
        </div>
    </main>
    HTML;
    }
}
