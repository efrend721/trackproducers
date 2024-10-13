<?php
$projectlistquery = array(
    'allProjects' => array(
        
        'allProjectlist' => "SELECT project.id_project, project.address, project.city, priority.nm_priority, project.date, status_project.nm_status_project
                            FROM project
                            INNER JOIN priority ON project.id_priority = priority.id_priority
                            INNER JOIN (SELECT id_project, id_status_project  FROM state_project
                                        GROUP BY id_project, id_status_project ) AS unique_state_project 
                            ON project.id_project = unique_state_project.id_project
                            INNER JOIN status_project ON unique_state_project.id_status_project = status_project.id_status_project
                            ORDER BY project.city ASC, project.date ASC, priority.nm_priority DESC",
        'deptQuery' => "SELECT id_dept, nm_dept  FROM dept",
        'searchQuery' => "SELECT project.id_project, project.address, project.city, priority.nm_priority, project.date, status_project.nm_status_project
                            FROM project
                            INNER JOIN priority ON project.id_priority = priority.id_priority
                            INNER JOIN (SELECT id_project, id_status_project  FROM state_project
                                        GROUP BY id_project, id_status_project ) AS unique_state_project 
                            ON project.id_project = unique_state_project.id_project
                            INNER JOIN status_project ON unique_state_project.id_status_project = status_project.id_status_project
                            WHERE project.id_project LIKE ? OR project.address LIKE ? OR project.city LIKE ? OR priority.nm_priority LIKE ? OR project.date LIKE ? OR status_project.nm_status_project LIKE ?
                            ORDER BY project.city ASC, project.date ASC, priority.nm_priority DESC"   
    ),

    'details' => array(
        'deleteImages'  => "DELETE FROM images WHERE user_id = ? AND id_project = ?",

        'specificProject' => "SELECT project.id_project, project.address, project.date, project.piece, project.id_color
                              FROM project
                              INNER JOIN (SELECT id_project, id_status_project  FROM state_project
                                         GROUP BY id_project, id_status_project) AS unique_state_project 
                              ON project.id_project = unique_state_project.id_project
                              INNER JOIN status_project ON unique_state_project.id_status_project = status_project.id_status_project
                              WHERE project.id_project = ?",

        'allNote' => "SELECT  u.name_user, n.id_note, nd.des_note, n.additional_note, n.date_note
                        FROM notes n
                        JOIN note_description nd ON n.id_note = nd.id_note
                        JOIN user u ON u.user_id = n.user_id
                        WHERE n.id_project = ? 
                        AND n.user_id = ?
                        GROUP BY n.id_note, nd.des_note, n.additional_note, n.date_note",

        'photoNote' => "SELECT n.photo
                        FROM notes n
                        JOIN note_description nd ON n.id_note = nd.id_note
                        WHERE nd.id_note = ? 
                        AND n.id_project = ?
                        AND n.user_id = ?",

        'commentQuery' => "SELECT u.name_user, d.nm_dept, c.nm_comment, s.id_station, s.date_comment, s.time_comment, s.elapsed_time 
                            FROM comment c 
                            INNER JOIN state_project s ON c.id_comment = s.id_comment 
                            INNER JOIN user u ON u.user_id = s.user_id  
                            INNER JOIN station st ON st.id_station = s.id_station 
                            INNER JOIN area a ON a.id_area = st.id_area 
                            INNER JOIN dept d ON d.id_dept = a.id_dept
                            WHERE s.id_project = ?",

        'countAreaquery' => "SELECT COUNT(id_area) FROM area WHERE id_dept = ?" ,

        'taskQuery' => "SELECT COUNT(task.id_project) AS count1  
                        FROM task
                        INNER JOIN project ON task.id_project = project.id_project AND project.id_project = ?
                        INNER JOIN area ON task.id_area = area.id_area
                        INNER JOIN dept ON area.id_dept = dept.id_dept AND dept.id_dept = ?",

        'taskAreaquery' => "SELECT COUNT(task.id_area) FROM task, area, dept, project 
                                                        WHERE area.id_dept = dept.id_dept 
                                                        AND task.id_area = area.id_area 
                                                        AND task.id_project = project.id_project 
                                                        AND project.id_project = ? and dept.id_dept = ?",
                                                            
        'taskStatusquery' => "SELECT COUNT(DISTINCT task.id_status_station ) AS count  
                                    FROM status_station
                                    INNER JOIN task ON status_station.id_status_station = task.id_status_station
                                    INNER JOIN project ON task.id_project = project.id_project AND project.id_project = ?
                                    INNER JOIN area ON task.id_area = area.id_area
                                    INNER JOIN dept ON area.id_dept = dept.id_dept AND dept.id_dept = ?",
        'taskStatusquery2' => "SELECT DISTINCT task.id_status_station  
                                    FROM status_station
                                    INNER JOIN task ON status_station.id_status_station = task.id_status_station
                                    INNER JOIN project ON task.id_project = project.id_project AND project.id_project = ?
                                    INNER JOIN area ON task.id_area = area.id_area
                                    INNER JOIN dept ON area.id_dept = dept.id_dept AND dept.id_dept = ?",

        'taskStatusDept' => "SELECT id_project, id_status_station, id_area FROM task WHERE id_area IN (SELECT id_area FROM area WHERE id_dept = ?)",

        'areaDept' => "SELECT id_area, nm_area FROM area WHERE id_dept = ? ",
        
        //'stationArea' => "SELECT id_station FROM station WHERE id_area = ?",
        'stationArea' => "SELECT s.nm_station, t.id_status_station
                            FROM 
                                station AS s
                            INNER JOIN 
                                task AS t ON s.id_station = t.id_station
                            INNER JOIN 
                                project AS p ON t.id_project = p.id_project
                            WHERE 
                                s.id_station IN (SELECT id_station FROM station WHERE id_area = ?)
                                AND t.id_project = ?;
                            ",


        'stationDetail' => "SELECT s.nm_station, t.id_status_station
                            FROM station AS s
                            INNER JOIN task AS t ON s.id_station = t.id_station
                            INNER JOIN project AS p ON t.id_project = p.id_project
                            WHERE t.id_station = ? AND t.id_project = ?"


    )
);
?>