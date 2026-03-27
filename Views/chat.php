<main class="d-flex align-items-center justify-content-center p-3">
     <form action="<?php echo FRONT_ROOT . "Message/setMessage" ?>" method="post" class="login-form bg-dark p-5 text-white">
          <?php
          if (isset($user) && isset($keeper)) { ?>
               <h5 class="mb-4">El Usuario es: <?php echo $user->getName() ?></h5>
               <h5 class="mb-4">El Keeper es: <?php Keeper:
                                                  echo $keeper->getUser()->getName() ?></h5>
               <?php if (!empty($messageList)) { ?>
                    <div class="container">
                         <?php foreach ($messageList as $list) { ?>
                              <h5 class="mb-4">Escrito Por : <?php echo $list->getAuthor() ?></h5>
                              <p class="mb-4">Mensaje: <?php echo $list->getMessage() ?></p>
                         <?php } ?>
                    </div>
               <?php } 
                    if (isset($message))
                         echo $message;
                ?>
               <div class="container">
                    <input name="author" type="hidden" value=<?php echo $_SESSION["loggedUser"]->getUserName() ?> />
                    <input name="user" type="hidden" value=<?php echo $user->getId() ?> />
                    <input name="keeper" type="hidden" value=<?php echo $keeper->getUser()->getId() ?> />
                    <textarea name="messageSend" class="mb-4 btn-block btn-lg" placeholder="into Message" required></textarea>
                    <button class="btn btn-warning btn-block btn-lg" type="submit">Send</button>
                    <!--<a class="btn btn-danger btn-block btn-lg" href="<?php // echo FRONT_ROOT . "Booking/ShowConfirmedView" ?>">cancel</a> -->
               </div>
     </form>
<?php } ?>
</div>
</main>