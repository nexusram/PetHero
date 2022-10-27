<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Contact | <?php echo $user->getName() ?></h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <tr>
                              <th>Cellphone</th>
                              <td><?php echo $user->getCellphone(); ?></td>
                         </tr>
                         <tr>
                              <th>Email</th>
                              <td><?php echo $user->getEmail(); ?></td>
                         </tr>
                         <tr>
                              <th>Address</th>
                              <td><?php echo $user->getAddress(); ?></td>
                         </tr>
                    </thead>
                    <tbody>
                    </tbody>
               </table>
          </div>
     </section>
</main>