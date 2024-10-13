<?php
function displayStatus() {
    if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
        $mensage = $_SESSION['status'];
        $statusMap = [
            "Deliveries Assigned Successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
            "Error: Deliveries Not Assigned" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"]
        ];
        list($icono, $color) = $statusMap[$mensage] ?? ["<i class='bi bi-exclamation-triangle-fill'></i>", "alert alert-warning"];
        echo <<<HTML
                    <div class='$color alert-dismissible fade show' role='alert'>
                        $icono 
                        <strong>$mensage</strong>
                        <button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button>
                    </div>
        HTML;
        unset($_SESSION['status']);
    }
}
?>