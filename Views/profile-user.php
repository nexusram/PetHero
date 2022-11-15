<?php

include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">My Profile</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <tr>
                              <th><strong>DATA USER</strong></th>
                         </tr>
                         <tr>
                              <th>Name</th>
                              <td><?php echo $user->getName(); ?></td>
                         </tr>
                         <tr>
                              <th>Surname</th>
                              <td><?php echo $user->getSurName(); ?></td>
                         </tr>
                         <tr>
                              <th>Birthday</th>
                              <td><?php echo $user->getBirthday(); ?></td>
                         </tr>
                         <tr>
                              <th>Username</th>
                              <td><?php echo $user->getUserName(); ?></td>
                         </tr>
                         <tr>
                              <th>Email</th>
                              <td><?php echo $user->getEmail(); ?></td>
                         </tr>
                         <tr>
                              <th>Cellphone</th>
                              <td><?php echo $user->getCellphone(); ?></td>
                         </tr>
                         <tr>
                              <th>Address</th>
                              <td><?php echo $user->getAddress(); ?></td>
                         </tr>
                         <?php

                         if (!is_null($keeper) && $keeper->getActive()) {
                         ?>
                              <table class="table bg-light-alpha">
                                   <thead>
                                        <tr>
                                             <th><strong>DATA KEEPER</strong></th>
                                        </tr>
                                        <tr>
                                             <th>Description</th>
                                             <td><?php echo $keeper->getDescription(); ?></td>
                                        </tr>
                                        <tr>
                                             <th>Remuneration</th>
                                             <td>$ <?php echo $keeper->getRemuneration(); ?></td>
                                        </tr>
                                        <tr>
                                             <th>Pet size to keep</th>
                                             <td><?php echo $keeper->getPetSize()->getName(); ?></td>
                                        </tr>
                                   </thead>
                              </table>
                         <?php
                         }
                         ?>
                    </thead>
                    <tbody>
                    </tbody>
               </table>
          </div>
     </section>
</main>