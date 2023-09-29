<main class="d-flex align-items-center justify-content-center p-3">
     <div class="content">
          <header class="text-center">
               <h2>Sign up in to Pet Hero</h2>
          </header>
          <form action="<?php echo FRONT_ROOT . "Home/Register" ?>" method="post" class="register-form bg-dark p-5 text-white">
               <div class="form-group text-center">
                    <h1>Register</h1>
               </div>
               <div class="form-group">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control form-control-lg" placeholder="Enter your name" required>
               </div>
               <div class="form-group">
                    <label for="">Surname</label>
                    <input type="text" name="surname" class="form-control form-control-lg" placeholder="Enter your surname" required>
               </div>
               <div class="form-group">
                    <label for="">BirthDay</label>
                    <input type="date" name="birthday" class="form-control form-control-lg" required>
               </div>
               <div class="form-group">
                    <label for="">UserName</label>
                    <input type="text" name="username" class="form-control form-control-lg" placeholder="Enter your username" required>
               </div>
               <div class="form-group">
                    <label for="">Password</label>
                    <input type="password" name="password" class="form-control form-control-lg" minlength="8" maxlength="20" placeholder="Enter your password" required>
               </div>
               <div class="form-group">
                    <label for="">Retry Password</label>
                    <input type="password" name="password_two" class="form-control form-control-lg" minlength="8" maxlength="20" placeholder="Enter your password" required>
               </div>
               <div class="form-group">
                    <label for="">Email</label>
                    <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" required>
               </div>
               <div class="form-group">
                    <label for="">Cellphone</label>
                    <input type="text" name="cellphone" class="form-control form-control-lg" placeholder="Enter your cellphone" required>
               </div>
               <div class="form-group">
                    <label for="">Address</label>
                    <input type="text" name="address" class="form-control form-control-lg" placeholder="Enter your address" required>
               </div>
               <button name="btn" class="btn btn-warning btn-block btn-lg" type="submit">Sign up</button>
               <div class="form-group mt-2 mb-0 text-center">
                    <a href="<?php echo FRONT_ROOT . "Home/Index" ?>">Register? Sign in!</a>
               </div>
               <?php
              if(isset($message))
              {
               echo $message;
              }
               ?>
          </form>
     </div>
</main>