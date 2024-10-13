<?php

$consultas = array(
    'basic' => array(
        'countMachines' => 'SELECT COUNT(id_station) AS countmachines FROM station WHERE id_area = ?',
        'stationName' => 'SELECT nm_station FROM station WHERE id_area = ? ORDER by nm_station ASC',
        'singleMachine' => 'SELECT nm_station FROM station WHERE id_area = ? AND id_station = ?'
        
    ),
    'details' => array(
        'queryOperators' => "SELECT u.user_id,  u.name_user,
                                CASE
                                    WHEN ul.time_finish < '14:30:00' THEN 'AM'
                                    WHEN ul.time_start > '14:30:00' THEN 'PM'
                                    ELSE ''
                                END AS turno_periodo
                                FROM 
                                    user u
                                JOIN 
                                    user_station us ON u.user_id = us.user_id
                                JOIN 
                                    station s ON us.id_station = s.id_station
                                JOIN
                                    user_log ul ON u.user_id = ul.user_id
                                WHERE 
                                    s.nm_station = :nm_station
                            AND ul.date_start = :currentDate
                            AND (
                                ul.time_finish < '14:30:00'
                                OR ul.time_start > '14:30:00'
                            )",
        
        'queryTimes' => "SELECT 
                            c.nm_comment, 
                            SUM(sp.elapsed_time) AS total_elapsed_time,
                            CASE 
                                WHEN sp.time_comment < '14:30:00' THEN 'AM'
                                ELSE 'PM'
                            END AS shift
                            FROM 
                                state_project AS sp
                            JOIN 
                                comment AS c ON sp.id_comment = c.id_comment
                            JOIN 
                                station AS s ON sp.id_station = s.id_station
                            WHERE 
                                sp.date_comment = :currentDate
                                AND sp.time_comment < '14:30:00' 
                                AND s.nm_station = :nm_station
                            GROUP BY 
                                c.nm_comment, shift",

        'queryOperatorsRangeDates' => "SELECT u.user_id,  u.name_user,
                            CASE
                                WHEN ul.time_finish < '14:30:00' THEN 'AM'
                                WHEN ul.time_start > '14:30:00' THEN 'PM'
                                ELSE ''
                            END AS turno_periodo
                            FROM 
                                user u
                            JOIN 
                                user_station us ON u.user_id = us.user_id
                            JOIN 
                                station s ON us.id_station = s.id_station
                            JOIN
                                user_log ul ON u.user_id = ul.user_id
                            WHERE 
                                s.nm_station = :nm_station
                                AND ul.date_start BETWEEN :startDate AND :endDate
                                AND (
                                    ul.time_finish < '14:30:00'
                                    OR ul.time_start > '14:30:00'
                                )",
        'queryTimesRangeDates' => "SELECT 
                            c.nm_comment, 
                            SUM(sp.elapsed_time) AS total_elapsed_time,
                            CASE 
                                WHEN sp.time_comment < '14:30:00' THEN 'AM'
                                ELSE 'PM'
                            END AS shift
                            FROM 
                                state_project AS sp
                            JOIN 
                                comment AS c ON sp.id_comment = c.id_comment
                            JOIN 
                                station AS s ON sp.id_station = s.id_station
                            WHERE 
                                sp.date_comment BETWEEN :startDate AND :endDate
                                AND sp.time_comment < '14:30:00' 
                                AND s.nm_station = :nm_station
                            GROUP BY 
                                c.nm_comment, shift",
        /*
        Nuevo Formato PDF Consulta original 
        'queryComments' => "SELECT DISTINCT cart.id_cart, task.date_finish, task.time_finish, state_project.id_station, state_project.id_comment, comment.nm_comment, state_project.elapsed_time FROM cart JOIN task ON task.id_project = cart.id_project AND task.id_area = cart.id_area JOIN state_project ON state_project.id_project = cart.id_project JOIN comment ON comment.id_comment = state_project.id_comment WHERE cart.id_project IN (SELECT id_project  FROM task  WHERE id_status_station = '2' AND id_station = '6' AND date_finish = '2024-08-18') AND cart.id_area = 3 and state_project.id_station = 6"
         ----------------------------------------------                           
        SELECT task.id_project, cart.id_cart, user_station.user_id, task.id_station, task.time_start, task.time_finish FROM task, user_station, cart where task.id_project = cart.id_project AND task.id_area = cart.id_area AND task.id_station = user_station.id_station and task.id_area = '3' and task.id_status_station = '2' ORDER BY `task`.`id_project` ASC;
        --------------
        esta casi funciona , estoy cerca de la solucion
         SELECT 
            task.id_project, 
            cart.id_cart, 
            user_station.user_id, 
            task.id_station, 
            task.time_start, 
            task.time_finish,
            state_project.id_comment
        FROM 
            task 
        JOIN 
            user_station ON task.id_station = user_station.id_station 
        JOIN 
            cart ON task.id_project = cart.id_project AND task.id_area = cart.id_area 
        LEFT JOIN 
            state_project ON task.id_project = state_project.id_project 
            AND state_project.id_station = task.id_station
        WHERE 
            task.id_area = '3' 
            AND task.id_status_station = '2'
            AND task.date_finish = '2024-08-18'  
        ORDER BY 
            task.id_project ASC;
    
    -----

        */
        
        
        
       // 'queryComments' => "SELECT DISTINCT cart.id_cart, task.date_finish, task.time_finish, state_project.id_station, user_station.user_id, state_project.id_comment, comment.nm_comment, state_project.elapsed_time FROM cart JOIN task ON task.id_project = cart.id_project AND task.id_area = cart.id_area JOIN state_project ON state_project.id_project = cart.id_project JOIN user_station ON state_project.id_station = user_station.id_station JOIN comment ON comment.id_comment = state_project.id_comment WHERE cart.id_project IN ( SELECT id_project FROM task WHERE id_status_station = '2' AND id_station = '6' AND date_finish = '2024-08-18' ) AND cart.id_area = 3 AND state_project.id_station = 6"
       'queryCommentsAll' => "SELECT 
                        task.id_project, 
                        cart.id_cart, 
                        user_station.user_id, 
                        task.id_station, 
                        task.time_start, 
                        task.time_finish,
                        GROUP_CONCAT(
                            CONCAT(comment.nm_comment, ' (', 
                                IFNULL(state_project.elapsed_time, 0), ')') 
                            ORDER BY comment.nm_comment ASC 
                            SEPARATOR ', '
                        ) AS nm_comments,  -- Concatenates nm_comment with their corresponding elapsed_time
                        SUM(CASE WHEN state_project.elapsed_time IS NOT NULL THEN state_project.elapsed_time ELSE 0 END) AS total_elapsed_time  -- Sums elapsed_time when not NULL
                        FROM 
                            task 
                        JOIN 
                            user_station ON task.id_station = user_station.id_station 
                        JOIN 
                            cart ON task.id_project = cart.id_project AND task.id_area = cart.id_area 
                        LEFT JOIN 
                            state_project ON task.id_project = state_project.id_project 
                            AND state_project.id_station = task.id_station
                        LEFT JOIN 
                            comment ON state_project.id_comment = comment.id_comment  -- Join to include nm_comment
                        WHERE 
                            task.id_area = ? 
                            AND task.date_finish = ?  
                            AND task.id_status_station = '2'
                        GROUP BY 
                            task.id_project, 
                            cart.id_cart, 
                            user_station.user_id, 
                            task.id_station, 
                            task.time_start, 
                            task.time_finish
                        ORDER BY 
                            task.time_start ASC;

                    ",
        'queryCommentSingleMachine' => "SELECT 
                        task.id_project, 
                        cart.id_cart, 
                        user_station.user_id, 
                        task.id_station, 
                        task.time_start, 
                        task.time_finish,
                        GROUP_CONCAT(
                            CONCAT(comment.nm_comment, ' (', 
                                IFNULL(state_project.elapsed_time, 0), ')') 
                            ORDER BY comment.nm_comment ASC 
                            SEPARATOR ', '
                        ) AS nm_comments,  -- Concatenates nm_comment with their corresponding elapsed_time
                        SUM(CASE WHEN state_project.elapsed_time IS NOT NULL THEN state_project.elapsed_time ELSE 0 END) AS total_elapsed_time  -- Sums elapsed_time when not NULL
                        FROM 
                            task 
                        JOIN 
                            user_station ON task.id_station = user_station.id_station 
                        JOIN 
                            cart ON task.id_project = cart.id_project AND task.id_area = cart.id_area 
                        LEFT JOIN 
                            state_project ON task.id_project = state_project.id_project 
                            AND state_project.id_station = task.id_station
                        LEFT JOIN 
                            comment ON state_project.id_comment = comment.id_comment  -- Join to include nm_comment
                        WHERE 
                            task.id_area = ? 
                            AND task.id_station = ?
                            AND task.date_finish = ?  
                            AND task.id_status_station = '2'
                            
                        GROUP BY 
                            task.id_project, 
                            cart.id_cart, 
                            user_station.user_id, 
                            task.id_station, 
                            task.time_start, 
                            task.time_finish
                        ORDER BY 
                            task.time_start ASC;

                    ",
                    'queryCommentsAllRangeDate' => "SELECT 
                        task.id_project, 
                        cart.id_cart, 
                        user_station.user_id, 
                        task.id_station, 
                        task.time_start, 
                        task.time_finish,
                        GROUP_CONCAT(
                            CONCAT(comment.nm_comment, ' (', 
                                IFNULL(state_project.elapsed_time, 0), ')') 
                            ORDER BY comment.nm_comment ASC 
                            SEPARATOR ', '
                        ) AS nm_comments,  -- Concatenates nm_comment with their corresponding elapsed_time
                        SUM(CASE WHEN state_project.elapsed_time IS NOT NULL THEN state_project.elapsed_time ELSE 0 END) AS total_elapsed_time  -- Sums elapsed_time when not NULL
                        FROM 
                            task 
                        JOIN 
                            user_station ON task.id_station = user_station.id_station 
                        JOIN 
                            cart ON task.id_project = cart.id_project AND task.id_area = cart.id_area 
                        LEFT JOIN 
                            state_project ON task.id_project = state_project.id_project 
                            AND state_project.id_station = task.id_station
                        LEFT JOIN 
                            comment ON state_project.id_comment = comment.id_comment  -- Join to include nm_comment
                        WHERE 
                            task.id_area = ? 
                            AND task.date_finish BETWEEN ? AND ?  
                            AND task.id_status_station = '2'
                        GROUP BY 
                            task.id_project, 
                            cart.id_cart, 
                            user_station.user_id, 
                            task.id_station, 
                            task.time_start, 
                            task.time_finish
                        ORDER BY 
                            task.time_start ASC;

                    ",
                'queryCommentSingleMachineRangeDate' => "SELECT 
                        task.id_project, 
                        cart.id_cart, 
                        user_station.user_id, 
                        task.id_station, 
                        task.time_start, 
                        task.time_finish,
                        GROUP_CONCAT(
                            CONCAT(comment.nm_comment, ' (', 
                                IFNULL(state_project.elapsed_time, 0), ')') 
                            ORDER BY comment.nm_comment ASC 
                            SEPARATOR ', '
                        ) AS nm_comments,  -- Concatenates nm_comment with their corresponding elapsed_time
                        SUM(CASE WHEN state_project.elapsed_time IS NOT NULL THEN state_project.elapsed_time ELSE 0 END) AS total_elapsed_time  -- Sums elapsed_time when not NULL
                        FROM 
                            task 
                        JOIN 
                            user_station ON task.id_station = user_station.id_station 
                        JOIN 
                            cart ON task.id_project = cart.id_project AND task.id_area = cart.id_area 
                        LEFT JOIN 
                            state_project ON task.id_project = state_project.id_project 
                            AND state_project.id_station = task.id_station
                        LEFT JOIN 
                            comment ON state_project.id_comment = comment.id_comment  -- Join to include nm_comment
                        WHERE 
                            task.id_area = ? 
                            AND task.id_station = ?
                            AND task.date_finish BETWEEN ? AND ?  
                            AND task.id_status_station = '2'
                            
                        GROUP BY 
                            task.id_project, 
                            cart.id_cart, 
                            user_station.user_id, 
                            task.id_station, 
                            task.time_start, 
                            task.time_finish
                        ORDER BY 
                            task.time_start ASC;

                    "                
                                

    )
);
?>