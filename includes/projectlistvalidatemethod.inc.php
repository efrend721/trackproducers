<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
            
            if (!isset($_POST['newnote']) || $_POST['newnote'] === NULL  ) {
                $_POST['newnote'] = NULL;
                
                if (!isset($_POST['process']) ||$_POST['process'] === NULL ) {
                    $_POST['process'] = NULL;
                    $idjob = $_POST['process'];
                }
                if (!isset($_POST['photoview']) || $_POST['photoview'] === NULL) {
                    $_POST['photoview'] = NULL;
                    $photoview = $_POST['photoview'];
                }
                if (!isset($_POST['idjobViewphoto']) || $_POST['idjobViewphoto'] === NULL) {
                    $_POST['idjobViewphoto'] = NULL;
                    $idjobTmp = $_POST['idjobViewphoto'];
                }
                if (!isset($_POST['submit']) || $_POST['submit'] === NULL) {
                    $_POST['submit'] = NULL;
                    $idjobSavenote = $_POST['submit'];
                }

                $idjobaddnote = $_POST['newnote'];
                $idjob = $_POST['process']; 
                $photoview = $_POST['photoview'];
                $idjobTmp = $_POST['idjobViewphoto'];
                $idjobSavenote = $_POST['submit'];
                var_dump($idjob);
                var_dump($idjobaddnote);
                var_dump($photoview);
                var_dump($idjobSavenote);

            }
            
            elseif (!isset($_POST['process']) ||$_POST['process'] === NULL ) {
                $_POST['process'] = NULL;    
                
                if (!isset($_POST['newnote']) ||$_POST['newnote'] === NULL ) {
                    $_POST['newnote'] = NULL;
                    $idjobaddnote = $_POST['newnote'];
                }
                if (!isset($_POST['photoview']) || $_POST['photoview'] === NULL) {
                    $_POST['photoview'] = NULL;
                    $photoview = $_POST['photoview'];
                }
                if (!isset($_POST['idjobViewphoto']) || $_POST['idjobViewphoto'] === NULL) {
                    $_POST['idjobViewphoto'] = NULL;
                    $idjobTmp = $_POST['idjobViewphoto'];
                }
                if (!isset($_POST['submit']) || $_POST['submit'] === NULL) {
                    $_POST['submit'] = NULL;
                    $idjobSavenote = $_POST['submit'];
                }
                    $idjob = $_POST['process'];
                    $idjobaddnote = $_POST['newnote'];
                    $photoview = $_POST['photoview'];
                    $idjobSavenote = $_POST['submit'];
                    var_dump($idjob);
                    var_dump($idjobaddnote);
                    $idjobTmp = $_POST['idjobViewphoto'];
                    var_dump($photoview);
                    var_dump($photoview);
                }
            elseif (!isset($_POST['photoview']) || $_POST['photoview'] === NULL) {
                    $_POST['photoview'] = NULL;
                    
                    if (!isset($_POST['process']) ||$_POST['process'] === NULL ) {
                        $_POST['process'] = NULL;
                        $idjob = $_POST['process'];
                    }
                    if (!isset($_POST['newnote']) ||$_POST['newnote'] === NULL ) {
                        $_POST['newnote'] = NULL;
                        $idjobaddnote = $_POST['newnote'];
                    }
                    if (!isset($_POST['idjobViewphoto']) || $_POST['idjobViewphoto'] === NULL) {
                        $_POST['idjobViewphoto'] = NULL;
                        $idjobTmp = $_POST['idjobViewphoto'];
                    }
                    if (!isset($_POST['submit']) || $_POST['submit'] === NULL) {
                        $_POST['submit'] = NULL;
                        $idjobSavenote = $_POST['submit'];
                    }
            

                    $idjob = $_POST['process'];
                    $idjobaddnote = $_POST['newnote'];
                    $photoview = $_POST['photoview'];
                    $idjobTmp = $_POST['idjobViewphoto']; 
                    $idjobSavenote = $_POST['submit'];   
                    var_dump($idjob);
                    var_dump($idjobaddnote);
                    var_dump($_POST['photoview']);
                    var_dump($idjobSavenote);
            }
            elseif (!isset($_POST['submit']) || $_POST['submit'] === NULL) {
                $_POST['submit'] = NULL;
                
                if (!isset($_POST['process']) ||$_POST['process'] === NULL ) {
                    $_POST['process'] = NULL;
                    $idjob = $_POST['process'];
                }
                if (!isset($_POST['newnote']) ||$_POST['newnote'] === NULL ) {
                    $_POST['newnote'] = NULL;
                    $idjobaddnote = $_POST['newnote'];
                }
                if (!isset($_POST['photoview']) || $_POST['photoview'] === NULL) {
                    $_POST['photoview'] = NULL;
                    $photoview = $_POST['photoview'];
                }
                if (!isset($_POST['idjobViewphoto']) || $_POST['idjobViewphoto'] === NULL) {
                    $_POST['idjobViewphoto'] = NULL;
                    $idjobTmp = $_POST['idjobViewphoto'];
                }
                $idjob = $_POST['process'];
                $idjobaddnote = $_POST['newnote'];
                $photoview = $_POST['photoview'];
                $idjobTmp = $_POST['idjobViewphoto'];
                $idjobSavenote = $_POST['submit'];
                var_dump($idjob);
                var_dump($idjobaddnote);
                var_dump($_POST['photoview']);
                var_dump($idjobTmp);
                var_dump($idjobSavenote);

            }        
            elseif (isset($_POST['process'])) {
                    $idjob = $_POST['process'];
                    $idjobTmp = $_POST['idjobViewphoto'];
                    $idjobaddnote = $_POST['newnote'];
                    $photoview = $_POST['photoview'];
                    $idjobSavenote = $_POST['submit'];
                    var_dump($idjob);
                    var_dump($idjobaddnote);
                    var_dump($_POST['photoview']);
                    echo "<br>";
                    var_dump($idjobTmp);
                    var_dump($idjobSavenote);
            }
            
            else {
                
                $idjob = $_POST['process'];
                $idjobaddnote = $_POST['newnote'];
                $photoview = $_POST['photoview'];    
                $idjobTmp = $_POST['idjobViewphoto'];
                $idjobSavenote = $_POST['submit'];
                var_dump($idjob);
                var_dump($idjobaddnote);
                var_dump($_POST['photoview']);
                var_dump($idjobTmp);
                var_dump($idjobSavenote);
            }
            
        }
?>