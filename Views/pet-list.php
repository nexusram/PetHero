<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <div class="mb-3">
                    <div>
                         <a class="btn btn-success" href="<?php echo FRONT_ROOT . "Pet/ShowAddView" ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                   <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                              </svg>
                              Add Pet
                         </a>
                    </div>
               </div>
               <h2 class="mb-4">My Pet´s</h2>
               <?php
               if (!empty($petList)) {
               ?>
                    <table class="table table-dark text-center">
                         <thead>
                              <th>Name</th>
                              <th>PetType</th>
                              <th>Breed</th>
                              <th>PetSize</th>
                              <th>Observation</th>
                              <th>Picture</th>
                              <th>Vacunation</th>
                              <th>Video</th>
                              <th>Actions</th>
                         </thead>
                         <tbody>
                         <?php
                    }
                         ?>
                         <?php
                         if (!empty($petList)) {
                              foreach ($petList as $pet) {
                         ?>
                                   <form action="<?php echo FRONT_ROOT . "Pet/Unsubscribe" ?>" method="post">
                                        <tr>
                                             <td><?php echo $pet->getName() ?></td>
                                             <td><?php echo $pet->getPetType()->getName() ?></td>
                                             <td><?php echo $pet->getBreed() ?></td>
                                             <td><?php echo $pet->getPetSize()->getName() ?></td>
                                             <td><?php echo $pet->getObservation() ?></td>
                                             <td>
                                                  <?php
                                                  if ($pet->getPicture() != null) {
                                                  ?>
                                                       <a href="<?php echo FRONT_ROOT . base64_decode($pet->getPicture()) ?>" target="_blank">
                                                            <img widht="50px" height="50px" src="<?php echo FRONT_ROOT . base64_decode($pet->getPicture()) ?>" alt="">
                                                       </a>
                                                  <?php
                                                  } else {
                                                       echo "Without image";
                                                  }
                                                  ?>
                                             </td>
                                             <td>
                                                  <?php
                                                  if ($pet->getVacunationPlan() != null) {
                                                  ?>
                                                       <a href="<?php echo FRONT_ROOT . base64_decode($pet->getVacunationPlan()) ?>" target="_blank">
                                                            <img widht="50px" height="50px" src="<?php echo FRONT_ROOT . base64_decode($pet->getVacunationPlan()) ?>" alt="">
                                                       </a>
                                                  <?php
                                                  } else {
                                                       echo "Without image";
                                                  }
                                                  ?>
                                             </td>
                                             <td>
                                                  <?php
                                                  if ($pet->getVideo() != null) {
                                                  ?>
                                                       <a href="<?php echo FRONT_ROOT . base64_decode($pet->getVideo()) ?>" target="_blank">
                                                            <video widht="50px" height="50px">
                                                                 <source src="<?php echo FRONT_ROOT . base64_decode($pet->getVideo()) ?>">
                                                            </video>
                                                       </a>
                                                  <?php
                                                  } else {
                                                       echo "Without video";
                                                  }
                                                  ?>
                                             <td>
                                                  <a class="btn btn-info" href="<?php echo FRONT_ROOT . "Pet/ShowModifyView/" . $pet->getId() ?>">
                                                       <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                                            <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z" />
                                                            <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z" />
                                                       </svg>
                                                  </a>
                                                  <button type="submit" name="btnUnsubscribe" class="btn btn-danger" value="<?php echo $pet->getId() ?>">X</button>
                                             </td>
                                        </tr>
                                   </form>
                         <?php
                              }
                         } else {
                              echo "<div class='container alert alert-warning'>
                         <div class='content text-center'>
                              <p><strong>You do not have pets, to start add one with the #Add Pet button</strong></p>
                         </div>
                    </div>";
                         }
                         ?>
                         </tbody>
                    </table>
          </div>
          <?php
          if ($message != "") {
          ?>
               <div class='form-group text-center'>
                    <?php
                    if ($type == "") {
                    ?>
                         <div class="container">
                              <div class='alert alert-danger'>
                                   <p><?php echo $message ?></p>
                              </div>
                         </div>
                    <?php
                    } else {
                    ?>
                         <div class="container">
                              <div class='alert alert-success'>
                                   <p><?php echo $message ?></p>
                              </div>
                         </div>
                    <?php
                    }
                    ?>
               </div>
          <?php
          }
          ?>
     </section>
</main>