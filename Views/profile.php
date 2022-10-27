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
                              <th>Name</th>
                              <td><?php echo $_SESSION["loggedUser"]->getName(); ?></td>
                         </tr>
                         <tr>
                              <th>Surname</th>
                              <td><?php echo $_SESSION["loggedUser"]->getSurName(); ?></td>
                         </tr>
                         <tr>
                              <th>Birthday</th>
                              <td><?php echo $_SESSION["loggedUser"]->getBirthday(); ?></td>
                         </tr>
                         <tr>
                              <th>Username</th>
                              <td><?php echo $_SESSION["loggedUser"]->getUserName(); ?></td>
                         </tr>
                         <tr>
                              <th>Email</th>
                              <td><?php echo $_SESSION["loggedUser"]->getEmail(); ?></td>
                         </tr>
                         <tr>
                              <th>Cellphone</th>
                              <td><?php echo $_SESSION["loggedUser"]->getCellphone(); ?></td>
                         </tr>
                         <tr>
                              <th>Address</th>
                              <td><?php echo $_SESSION["loggedUser"]->getAddress(); ?></td>
                         </tr>
                    </thead>
                    <tbody>
                         <td>
                              <a class="btn btn-info" href="<?php echo FRONT_ROOT . "User/ShowUpdateView" ?>">
                                   <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                        <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                        <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                   </svg>
                              </a>
                         </td>
                    </tbody>
                    <?php
                    if ($message != "") {
                    ?>
                         <div class='form-group text-center'>
                              <?php
                              if ($type == "") {
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
               </table>
          </div>
     </section>
</main>