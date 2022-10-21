<form action="<?php echo FRONT_ROOT . "Home/ForgotUser" ?>" method="post" class="login-form bg-dark p-5 text-white">
<div class="form-group mt-2 mb-0 text-center">
                    <a href="<?php echo FRONT_ROOT . "Home/Index" ?>">Login</a>
               </div>
<div class="form-group text-center">
        <h1>Me olvide la contraseña</h1>
    </div>
    <div class="form-group">
        <label for="">User Name</label>
        <input type="text" name="userName" class="form-control form-control-lg" placeholder="Enter username">
    </div>
    <button class="btn btn-warning btn-block btn-lg" type="submit">enviar</button>
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