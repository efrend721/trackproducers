<?php
$consultaAll = array(
    'allprojects' => array(
        'sqlAllProjects' => "SELECT project.id_project, priority.nm_priority, project.date, project.address, project.piece, status_project.nm_status_project
                                            FROM project
                                            INNER JOIN priority ON project.id_priority = priority.id_priority 
                                            INNER JOIN (SELECT id_project, id_status_project FROM state_project GROUP BY id_project, id_status_project)
                                            AS unique_state_project ON project.id_project = unique_state_project.id_project
                                            INNER JOIN status_project ON unique_state_project.id_status_project = status_project.id_status_project
                                            ORDER BY project.id_priority DESC, project.date ASC",
                                            
        'sqlSingleproject' => "SELECT project.address, project.date, priority.nm_priority
                                                                 FROM project
                                                                 INNER JOIN (SELECT id_project, id_status_project  FROM state_project
                                                                             GROUP BY id_project, id_status_project) AS unique_state_project ON project.id_project = unique_state_project.id_project
                                                                 INNER JOIN priority ON project.id_priority = priority.id_priority
                                                                 INNER JOIN status_project ON unique_state_project.id_status_project = status_project.id_status_project
                                                                 WHERE project.id_project = ?"
    
    )
);
?>