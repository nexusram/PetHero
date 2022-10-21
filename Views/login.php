<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <header class="text-center">
               <h2>WELCOME!</h2>
          </header>
          <form action="<?php echo FRONT_ROOT . "Home/Login"?>" method="post" class="login-form bg-dark p-5 text-white">
               <div class="form-group text-center">
                    <h1>Login</h1>
               </div>
               <div class="form-group">
                    <label for="">User Name</label>
                    <input type="text" name="userName" class="form-control form-control-lg" placeholder="Enter username">
               </div>
               <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter password">
               </div>
               <button class="btn btn-warning btn-block btn-lg" type="submit">Sign in</button>
               <div class="form-group mt-2 mb-0 text-center">
                    <a href="<?php echo FRONT_ROOT . "Home/ShowForgetUserView" ?>">I forgot the password?</a>
               </div>
               <div class="form-group mt-2 mb-0 text-center">
                    <a href="<?php echo FRONT_ROOT . "Home/ShowRegisterView" ?>">Do you not a user? Register now!</a>
               </div>
               <?php
                    if($message != "") {
                    ?>
                         <div class='form-group text-center'>
                    <?php
                         if($type == "") {
                              ?>
                              <div class='alert alert-danger'>
                                   <p><?php echo $message ?></p>
                              </div>
                         <?php
                         } else {
                              ?>
                              <div class='alert alert-success'>
                              <p><?php echo $message ?></p>
                              </div>
                         <?php
                         }
                    ?>
                         </div>
                    <?php
                    }
               ?>
          </form>
     </div>
</main>