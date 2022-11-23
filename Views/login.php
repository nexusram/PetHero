<main class="d-flex align-items-center justify-content-center height-100">
     <div class="content">
          <header class="text-center">
               <h2>WELCOME!</h2>
          </header>
          <form action="<?php

                         echo FRONT_ROOT . "Home/Login" ?>" method="post" class="login-form bg-dark p-5 text-white">
               <div class="form-group text-center">
                    <h1>Login</h1>
               </div>
               <div class="form-group">
                    <label for="">User Name</label>
                    <input type="text" name="userName" class="form-control form-control-lg" placeholder="Enter username" required>
               </div>
               <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter password" required>
               </div>
               <button class="btn btn-warning btn-block btn-lg" type="submit">Sign in</button>
               <div class="form-group mt-3 mb-0 text-center">
                    <a href="<?php echo FRONT_ROOT . "Home/ShowRegisterView" ?>">Do you not a user? Register now!</a>
               </div>
               <div class="form-group mt-3 mb-0 text-center">
                    <a href="<?php echo FRONT_ROOT . "Home/ShowRememberPassword" ?>">Do you not remember password?</a>
               </div>
               <?php
                    include_once(VIEWS_PATH . "message.php");
               ?>
          </form>
     </div>
</main>