<?php
if (isset($_SESSION['status']) && $_SESSION['status'] != '') {
    $mensage = $_SESSION['status'];
    $statusMap = [
                  "Note saved successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                  "Note and Extra comment not set" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-warning"],
                  "Comment added successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                  "Comment not added" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                  "Invalid input" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                  "Deliveries Assigned Successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                  "Select at least one project." => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-warning"],
                  "Error: Deliveries Not Assigned" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                  "A driver has not been selected" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-warning"],
                  "Priority updated successfully" => ["<i class='bi bi-check-circle-fill'></i>", "alert alert-success"],
                  "Priority not updated" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"],
                  "No priority has been selected" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-warning"],
                  

                

                    //"Extra comment not set" => ["<i class='bi bi-x-circle-fill'></i>", "alert alert-danger"]
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
?>