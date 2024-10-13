<?php
include_once '../libraries/components.php';
include_once '../classes/deliveryredispatch.classes.php';
include_once '../classes/sidebarmain.classes.php';


session_start();

echo $head;
class UserSession {
        

    public function displaySidebar() {
        
        $sidebar = new sidebarMain;
        $sidebar->getSidebarMain();

    }
    
    public function displayProjectRedispatchMain () {
        $managermain = new ProjectRedispatchMain;
        $managermain->getProjectRedispatchQuery();
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
$userSession = new UserSession;
$userSession->displayUserDetails();
$userSession->displaySidebar();
$userSession->displayProjectRedispatchMain();

echo $footer;
?>
