
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
                         if (isset($petList)) {
                              foreach ($petList as $pet) {
                         ?>
                                   <form action="<?php echo FRONT_ROOT . "Pet/Unsubscribe" ?>" method="post">
                                        <tr>
                                             <td><?php echo $pet->getName() ?></td>
                                             <td><?php echo $pet->getPetType()->getName() ?></td>
                                             <td><?php echo $pet->getBreed()->getName() ?></td>
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
                                                  <button type="submit" name="btnUnsubscribe" class="btn btn-danger" value="<?php echo $pet->getId() ?>">X</button>
                                             </td>
                                        </tr>
                                   </form>
                         <?php
                              }
                         } ?>
                    </tbody>
               </table>
               <?php
               if(!empty($listEmpty)){
                              echo $listEmpty;
                         }
                         ?>
          </div>
          <?php
          if(isset($message))
         echo $message;
          ?>
     </section>
</main>