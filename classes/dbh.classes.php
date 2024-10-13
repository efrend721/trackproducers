<?php
    class Dbh { 
        //public $dbh ;
     
        public function connect() {
            try{
                $username = "systems";
                $password = "123456";
                $dbh = new PDO('mysql:host=localhost;dbname=productiongestor', $username, $password); 
                return $dbh;
            }
            catch(PDOException $e){
                print "Error!: " . $e->getMessage() . "<br/>";
                die();
            }
        
        }
        
    }
?>    