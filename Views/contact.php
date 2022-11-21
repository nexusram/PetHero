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
               <a class="btn btn-primary" href="<?php echo FRONT_ROOT . "Keeper/ShowListView" ?>">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                         <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z"/>
                         <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z"/>
                    </svg>
                    Back
               </a>
          </div>
     </section>
</main>