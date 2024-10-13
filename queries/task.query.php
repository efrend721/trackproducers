<?php
$sqlTask = array(
    'allSqltask' => array(
        'sqlIdStation' => "SELECT station.id_area, user_station.id_station  
                           FROM user
                           INNER JOIN user_station ON user.user_id = user_station.user_id
                           INNER JOIN station ON station.id_station = user_station.id_station
                           WHERE user_station.user_id = ?",
        
        'sqlTaskNowDriver' => "SELECT user_id FROM assigneddeliveries WHERE user_id = ? GROUP BY user_id",
        
        'sqlCountTask' => "SELECT COUNT(*) AS counttask FROM task WHERE id_station = ? AND id_status_station = 1",
        
        'sqlProjectOne' => "SELECT project.id_project, project.address, project.piece, project.id_color, priority.nm_priority, project.date, task.date_start, task.time_start
                                                                        FROM project
                                                                        INNER JOIN priority ON project.id_priority = priority.id_priority
                                                                        INNER JOIN task ON task.id_project = project.id_project
                                                                        INNER JOIN status_station ON status_station.id_status_station = task.id_status_station
                                                                        WHERE task.id_status_station IN (1)
                                                                        AND task.id_station = ?
                                                                        ORDER BY project.id_priority DESC, project.date ASC",
        
        'sqlProjectZero' => "SELECT project.id_project, project.address, priority.nm_priority, project.date
                                                            FROM project
                                                            INNER JOIN state_project ON project.id_project = state_project.id_project
                                                            INNER JOIN priority ON project.id_priority = priority.id_priority
                                                            INNER JOIN status_project ON state_project.id_status_project = status_project.id_status_project
                                                            WHERE state_project.id_status_project = 0
                                                            ORDER BY project.id_priority DESC, project.date DESC LIMIT 6",
        
        'sqlTaskPreStation' => "SELECT station.id_station, station.id_previus_area  
                                                      FROM user
                                                      INNER JOIN user_station ON user.user_id = user_station.user_id
                                                      INNER JOIN station ON station.id_station = user_station.id_station
                                                      WHERE user_station.user_id = ?",
        'sqlTaskPre' => "SELECT project.id_project, cart.id_cart, project.address, project.piece, project.id_color, priority.nm_priority, project.date
                                                                        FROM project
                                                                        INNER JOIN priority ON project.id_priority = priority.id_priority
                                                                        INNER JOIN task ON project.id_project = task.id_project
                                                                        INNER JOIN cart ON project.id_project = cart.id_project
                                                                        WHERE task.id_station = ? 
                                                                        AND task.id_status_station = 1
                                                                        AND cart.id_area IN (SELECT id_area FROM station WHERE id_station = ? )
                                                                        ORDER BY project.id_priority DESC, project.date DESC",

        'sqlDeliveryTaskPre' => "SELECT project.id_project, cart.id_cart, project.address, project.piece, project.id_color, priority.nm_priority, project.date
                                                                        FROM project
                                                                        INNER JOIN priority ON project.id_priority = priority.id_priority
                                                                        INNER JOIN task ON project.id_project = task.id_project
                                                                        INNER JOIN cart ON project.id_project = cart.id_project
                                                                        WHERE task.id_station = ? 
                                                                        AND task.id_status_station = 1
                                                                        AND cart.id_area = 3
                                                                        ORDER BY project.id_priority DESC, project.date DESC",

        'sqlTaskPreGeneral' => "SELECT project.id_project, cart.id_cart, project.address, priority.nm_priority, project.date
                                                            FROM project
                                                            INNER JOIN state_project ON project.id_project = state_project.id_project
                                                            INNER JOIN priority ON project.id_priority = priority.id_priority
                                                            INNER JOIN status_project ON state_project.id_status_project = status_project.id_status_project
                                                            INNER JOIN task ON project.id_project = task.id_project
                                                            INNER JOIN cart ON project.id_project = cart.id_project
                                                            WHERE task.id_area = ? 
                                                            AND task.id_status_station = 2
                                                            AND state_project.id_status_project BETWEEN 1 AND 3
                                                            AND cart.id_area IN (SELECT id_area FROM station WHERE id_station = ? )
                                                            AND task.id_project NOT IN (SELECT id_project FROM task WHERE id_station = ? AND id_status_station IN (1, 2))
                                                            ORDER BY project.id_priority DESC, project.date DESC;",
        'sqlDeliveryPreGeneral' => "SELECT project.id_project, project.address, priority.nm_priority, project.date
                                        FROM project
                                        INNER JOIN state_project ON project.id_project = state_project.id_project
                                        INNER JOIN priority ON project.id_priority = priority.id_priority
                                        INNER JOIN status_project ON state_project.id_status_project = status_project.id_status_project
                                        INNER JOIN task ON project.id_project = task.id_project
                                        WHERE task.id_area = ? 
                                        AND task.id_status_station = 2
                                        AND state_project.id_status_project BETWEEN 1 AND 3
                                        AND task.id_project NOT IN (SELECT id_project FROM task WHERE id_station = ? AND id_status_station IN (1, 2))
                                        AND project.id_project IN (SELECT id_project FROM assigneddeliveries WHERE user_id = ? group by id_project)
                                        GROUP BY project.id_project, project.address, priority.nm_priority, project.date
                                        ORDER BY project.id_priority DESC, project.date DESC",

    
    )
);
?>