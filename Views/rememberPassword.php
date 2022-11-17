<main class="d-flex align-items-center justify-content-center height-100">
    <div class="content">
        <header class="text-center">
            <h2>WELCOME!</h2>
        </header>
        <form action="<?php

use Controllers\HomeController;

 echo FRONT_ROOT . "Home/RememberPassword" ?>" method="post" class="login-form bg-dark p-5 text-white">
            <div class="form-group text-center">
                <h1>Login</h1>
            </div>
            <div class="form-group">
                <label for="">Ingrese el nombre de la cuenta</label>
                <input type="text" name="userName" class="form-control form-control-lg" placeholder="Enter username" required>
            </div>
            <button class="btn btn-warning btn-block btn-lg" type="submit">Sign in</button>
            <div class="form-group mt-3 mb-0 text-center">
                <a href="<?php echo FRONT_ROOT . "Home/Index" ?>">Back</a>
            </div>
            <?php
                include_once(VIEWS_PATH . "message.php");
            ?>
        </form>
    </div>
</main>