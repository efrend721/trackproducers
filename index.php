
<?php
include_once 'libraries/components.php';

session_start();
echo $indexhead;
?>

   

<div class="container">

    <div  class="row mt-5" >
    
        <div  class="col-lg-4 bg-white m-auto rouded-top ">
            <div class="alert alert-primary" role="alert">
                <h2 class="text-center pt-3">KingsWood Cabinets</h2>
            </div>
            <div class="alert alert-primary" role="alert">
                <h2 class="text-center pt-3">Production Tracking Software</h2>
            </div>            
            <form class="row g-1 needs-validation "  id="validarusuario" action="includes/login.inc.php" method="post" novalidate="">
            <div class="form-group ">
                
            
                <div class="input-group mb-3 has-validation">
                    <span class="input-group-text" id="uid"><i class="bi bi-person-fill"></i></span>
                    <input type="text" class="form-control" aria-describedby="inputGroupPrepend" required="" id="uid" name="uid" placeholder="Username"  >
                    <div class="invalid-feedback">
                      Please provide a valid Username.
                    </div>

                </div>
                
            
            
            
            
            </div>    
            
            
            <div class="form-group">
                <div class="form-inline row">
                    <div class="input-group mb-3 has-validation">
                            <span class="input-group-text"><i class="bi bi-lock"></i></span>
                            <input type="password" class="form-control" aria-describedby="inputGroupPrepend" required="" id="pwd" name="pwd" placeholder="Password" >
                            <div class="invalid-feedback">
                                Please provide a valid Password.
                            </div>
                            
                    </div>    
                </div>
            </div>
            
            <?php 
              if (isset($_GET['error'])) {
                if ($_GET['error'] == 'usernotfound') {
                    echo '
                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                      <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                      </symbol>
                    </svg>
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                      User not found.
                    </div>
                    <button  id="usernotfound" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>
                  </div>';
                }
                elseif ($_GET['error'] == 'wrongpassword') {
                    echo'
                    <svg xmlns="http://www.w3.org/2000/svg" class="d-none">
                      <symbol id="exclamation-triangle-fill" viewBox="0 0 16 16">
                        <path d="M8.982 1.566a1.13 1.13 0 0 0-1.96 0L.165 13.233c-.457.778.091 1.767.98 1.767h13.713c.889 0 1.438-.99.98-1.767L8.982 1.566zM8 5c.535 0 .954.462.9.995l-.35 3.507a.552.552 0 0 1-1.1 0L7.1 5.995A.905.905 0 0 1 8 5zm.002 6a1 1 0 1 1 0 2 1 1 0 0 1 0-2z"/>
                      </symbol>
                    </svg>
                    <div class="alert alert-danger d-flex align-items-center alert-dismissible fade show" role="alert">
                    <svg class="bi flex-shrink-0 me-2" role="img" aria-label="Danger:"><use xlink:href="#exclamation-triangle-fill"/></svg>
                    <div>
                      Wrong password.
                    </div>
                    <button id="wrongpassword" type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close" ></button>
                  </div>';
                }
              }
            ?>

            <div class="d-grid">
                    <button type="submit" name="submit" class="btn btn-success">LOGIN</button>
            </div>
            
        
            </form>
        </div>
    </div>
</div> 
<script>
        (() => {
          'use strict'
          const forms = document.querySelectorAll('.needs-validation')
          // Loop over them and prevent submission
          Array.from(forms).forEach(form => {
            form.addEventListener('submit', event => {
              if (!form.checkValidity()) {
                event.preventDefault()
                event.stopPropagation()
              }

              form.classList.add('was-validated')
            }, false)
          })
        })()
</script>
<script>
        var userNotFoundButton = document.getElementById("usernotfound");
var wrongPasswordButton = document.getElementById("wrongpassword");

if(userNotFoundButton) {
    userNotFoundButton.addEventListener("click", function() {
        window.location.href = "http://localhost/kingswood/index.php";
    });
}

if(wrongPasswordButton) {
    wrongPasswordButton.addEventListener("click", function() {
        window.location.href = "http://localhost/kingswood/index.php";
    });
}
                  
                  
</script>


<?php 





echo $indexfooter;
?>
   


