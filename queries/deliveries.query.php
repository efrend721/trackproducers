<?php
$deliveriesquery = array(
    'allDeliveries' => array(
        'allProjects' => "SELECT project.id_project, project.address, project.city, project.date, project.piece, priority.nm_priority
                          FROM task
                          INNER JOIN project ON task.id_project = project.id_project
                          INNER JOIN priority ON project.id_priority = priority.id_priority
                          WHERE task.id_status_station = '2' 
                          AND task.id_area IN (SELECT id_previus_area FROM station WHERE id_area = '40' GROUP BY id_previus_area)
                          AND project.id_project NOT IN (SELECT id_project FROM assigneddeliveries)",

        'allDeliveriesAssigned' => "SELECT DISTINCT project.id_project, project.address, project.city, project.date, project.piece,  priority.nm_priority, user.name_user 
                                    FROM task
                                    INNER JOIN project ON project.id_project = task.id_project
                                    INNER JOIN priority ON project.id_priority = priority.id_priority
                                    INNER JOIN assigneddeliveries ON project.id_project = assigneddeliveries.id_project
                                    INNER JOIN user ON assigneddeliveries.user_id = user.user_id
                                    WHERE assigneddeliveries.id_project NOT IN (
                                            SELECT id_project 
                                            FROM task 
                                            WHERE id_area IN ('40') 
                                            GROUP BY id_project 
                                            ORDER BY id_project
                                        ) 
                                    ORDER BY 
                                        project.id_project",

        'allDeliveriesAssignedDriver' => "SELECT task.id_project, project.address, project.city, user.name_user, task.date_finish, task.time_finish, task.id_status_station 
                                          FROM task 
                                          JOIN assigneddeliveries ON task.id_project = assigneddeliveries.id_project 
                                          JOIN project ON project.id_project = task.id_project 
                                          JOIN user ON user.user_id = assigneddeliveries.user_id 
                                          WHERE task.id_area = '40' AND ( project.address LIKE ? OR project.city LIKE ? OR user.name_user LIKE ? OR task.date_finish LIKE ? OR task.id_status_station LIKE ? )
                                          GROUP BY task.id_project, project.address, project.city, user.name_user, task.id_status_station, task.date_finish, task.time_finish 
                                          ORDER BY task.id_project ASC"
    ),

    'details' => array(
        'drivers' => "SELECT user.user_id, user.name_user FROM user, drivers WHERE user.user_id = drivers.user_id",
        'driversArea' => "SELECT id_station 
                          FROM user_station, user  
                          WHERE user.user_id = user_station.user_id 
                          AND user_station.user_id = ? ",
        'driverAssigned' => "SELECT assigneddeliveries.user_id, user.name_user 
                            FROM assigneddeliveries 
                            INNER JOIN user ON assigneddeliveries.user_id = user.user_id 
                            GROUP BY assigneddeliveries.user_id, user.name_user",

        'deliveriesAssigned' => "SELECT  project.id_project, project.address, project.city, project.date, project.piece,  priority.nm_priority,  user.name_user
                                FROM task
                                INNER JOIN project ON task.id_project = project.id_project
                                INNER JOIN priority ON project.id_priority = priority.id_priority
                                INNER JOIN assigneddeliveries ON project.id_project = assigneddeliveries.id_project
                                INNER JOIN user ON assigneddeliveries.user_id = user.user_id
                                WHERE  assigneddeliveries.id_project NOT IN (
                                            SELECT id_project 
                                            FROM task 
                                            WHERE id_area IN ('40') 
                                            GROUP BY id_project 
                                            ORDER BY id_project
                                        ) 
                                    AND user.user_id = ?
                                    GROUP BY project.id_project, project.address, project.city, project.date, project.piece,  priority.nm_priority,  user.name_user"


    )


);
