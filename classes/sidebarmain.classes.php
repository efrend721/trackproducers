<?php 
require_once 'dbh.classes.php';

class sidebarMain  {
    
    public function getSidebarMain() {
        
        $level_access = $_SESSION["id_level_access"];  
     
        $dbh = new Dbh();
        $stmtmenu = $dbh->connect()->prepare("SELECT m.id_menu, m.menu_describe, um.link, m.icon
                                              FROM users_menu um
                                              JOIN menu m ON um.id_menu = m.id_menu
                                              WHERE um.id_level_access = '$level_access' 
                                              ORDER BY m.id_menu ASC");
        
        $stmtmenu->execute();
        
        echo "<!-- offcanvas -->
            <div class='offcanvas offcanvas-start sidebar-nav bg-dark' tabindex='-1' id='sidebar'>
                <div class='offcanvas-body p-0'>
                    <nav class='navbar-dark'>
                        <ul class='navbar-nav'>
                            ";
                            $results = $stmtmenu->fetchAll(PDO::FETCH_ASSOC);
                            foreach($results as $result) {
                                $idMenu = $result['id_menu'];
                                $stmtCountmenu = $dbh->connect()->prepare("SELECT COUNT(sub_menu.id_sub_menu) AS countsubmenu
                                                                            FROM sub_menu
                                                                            JOIN users_sub_menu ON sub_menu.id_sub_menu = users_sub_menu.id_sub_menu
                                                                            WHERE users_sub_menu.id_level_access = '$level_access'
                                                                            AND sub_menu.id_menu = '$idMenu'");
                                $stmtCountmenu->execute();
                                $resultCountmenu = $stmtCountmenu->fetch(PDO::FETCH_ASSOC);
                                if($resultCountmenu['countsubmenu'] > 0) {
                                    echo "<li>
                                            <a class='nav-link px-3 sidebar-link' data-bs-toggle='collapse'  href='#layouts$idMenu' >
                                                <span class='me-2'><i class='{$result['icon']}'></i></span>
                                                <span>{$result['menu_describe']}</span>
                                                <span class='ms-auto'>
                                                    <span class='right-icon'>
                                                        <i class='bi bi-chevron-down'></i>
                                                    </span>
                                                </span>
                                            </a>";  
                                    $stmtSubmenu = $dbh->connect()->prepare("SELECT sub_menu.sub_menu_describe, sub_menu.icono, users_sub_menu.link  FROM sub_menu
                                                                            JOIN menu ON sub_menu.id_menu = menu.id_menu
                                                                            JOIN users_sub_menu ON sub_menu.id_sub_menu = users_sub_menu.id_sub_menu
                                                                            WHERE  menu.id_menu = '$idMenu'  AND users_sub_menu.id_level_access = '$level_access' 
                                                                            ORDER BY sub_menu.id_sub_menu ASC");
                                    $stmtSubmenu->execute();
                                    $resultsSubmenu = $stmtSubmenu->fetchAll(PDO::FETCH_ASSOC);
                                    foreach($resultsSubmenu as $resultSubmenu) {
                                        echo "<div class='collapse' id='layouts$idMenu'>
                                                <ul class='navbar-nav ps-3'>
                                                    <li>
                                                        <a href='{$resultSubmenu['link']}' class='nav-link px-3'>
                                                            <span class='me-2'><i class='{$resultSubmenu['icono']}'></i></span>
                                                            <span>{$resultSubmenu['sub_menu_describe']}</span>
                                                        </a>
                                                    </li>
                                                </ul>
                                            </div>
                                        </li>
                                        ";
                                    }        

                                } else {
                                        echo "<li>
                                            <a href='{$result['link']}' class='nav-link px-3 active'>
                                                <span class='me-2'><i class='{$result['icon']}'></i> </span>
                                                <span>{$result['menu_describe']}</span>
                                            </a>
                                        </li>";
                                }
                            }
        echo "          </ul>
                    </nav>
                </div>
            </div>
            <!-- offcanvas -->";                    
    
    }
    

}    

?>