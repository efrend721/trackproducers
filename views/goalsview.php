<?php
include_once '../libraries/components.php';
include_once '../classes/goals.classes.php';
include_once '../classes/sidebarmain.classes.php';
session_start();

echo $head;
class UserSession {
        

    public function displaySidebar() {
        
        $sidebar = new sidebarMain;
        $sidebar->getSidebarMain();

    }
    
    public function displayGoals () {
        $managermain = new GoalsMain;
        $managermain->setGoals();
    }
    

    private function printUserDetails($userName) {
      
      include_once '../templates/printuserdetails.template.php';  
    }
    
    public function displayUserDetails() {
        
      if(isset($_SESSION['name_user'])){
      
      $this->printUserDetails($_SESSION["name_user"]);
      
      }
      
  }     

    
}

// Ejemplo de uso:
$userSession = new UserSession;

$userSession->displayUserDetails();
$userSession->displaySidebar();
$userSession->displayGoals();

echo $footer;


?>
