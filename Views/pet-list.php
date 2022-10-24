<?php
    include_once(VIEWS_PATH . "nav-user.php");
    include_once(VIEWS_PATH . "validate-session.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <div class="mb-3">
                    <div>
                        <a class="btn btn-success" href="<?php echo FRONT_ROOT . "Pet/ShowAddView"?>">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z"/>
                            </svg>
                            Add Pet
                        </a>
                    </div>
               </div>
               <h2 class="mb-4">My Pet´s</h2>
               <?php
                    if(!empty($petList)) {
               ?>
               <table class="table table-dark text-center">
                    <thead>
                         <th>Name</th>
                         <th>Breed</th>
                         <th>Specie</th>
                         <th>Pet type</th>
                         <th>Observation</th>
                         <th>Photo</th>
                         <th>Vacunation Plan</th>
                         <th>Video</th>
                         <th>Actions</th>
                    </thead>
                    <tbody>
               <?php
                    }
               ?>
               <?php
                    if(!empty($petList)) {
                         foreach($petList as $pet) {
               ?>
                    <form action="<?php echo FRONT_ROOT . "Pet/Remove"?>" method="post">
                              <tr>
                                   <td><?php echo $pet->getName() ?></td>
                                   <td><?php echo $pet->getBreed() ?></td>
                                   <td><?php echo $pet->getSpecie()?></td>
                                   <td><?php echo $pet->getPetTypeId() ?></td>
                                   <td><?php echo $pet->getObservation() ?></td>
                                   <td>
                                        <button type="button" value="<?php $pet->getId()?>" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#photo">View</button>
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#vacunationPlan">View</button>
                                   </td>
                                   <td>
                                        <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#video">View</button></td>
                                   <td>
                                   <a class="btn btn-info" href="<?php echo FRONT_ROOT . "Pet/ShowModifyView/" . $pet->getId() ?>">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-square" viewBox="0 0 16 16">
                                             <path d="M15.502 1.94a.5.5 0 0 1 0 .706L14.459 3.69l-2-2L13.502.646a.5.5 0 0 1 .707 0l1.293 1.293zm-1.75 2.456-2-2L4.939 9.21a.5.5 0 0 0-.121.196l-.805 2.414a.25.25 0 0 0 .316.316l2.414-.805a.5.5 0 0 0 .196-.12l6.813-6.814z"/>
                                             <path fill-rule="evenodd" d="M1 13.5A1.5 1.5 0 0 0 2.5 15h11a1.5 1.5 0 0 0 1.5-1.5v-6a.5.5 0 0 0-1 0v6a.5.5 0 0 1-.5.5h-11a.5.5 0 0 1-.5-.5v-11a.5.5 0 0 1 .5-.5H9a.5.5 0 0 0 0-1H2.5A1.5 1.5 0 0 0 1 2.5v11z"/>
                                        </svg>
                                   </a>
                                   <button type="submit" name="btnRemove" class="btn btn-danger" value="<?php echo $pet->getId() ?>">X</button>
                                   </td>
                              </tr>
                              </form>
                              <div class="modal fade" id="photo">
                                   <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                                  <h5 class="modal-title text-dark" id="exModalLabel">Photo</h5>
                                             </div>
                                             <div class="modal-body">
                                                  <div class="container-fluid">
                                                       <div class="row">
                                                            <div class="col">
                                                                 <div class="card">
                                                                      <a href="https://images3.alphacoders.com/857/857335.jpg" target="_blank">
                                                                           <img class="card-img-top" src="https://images3.alphacoders.com/857/857335.jpg" alt="">
                                                                      </a>
                                                                      <div class="card-body">
                                                                           Perro
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col">
                                                                 <form action="<?php echo FRONT_ROOT . "Pet/UploadPhoto"?>" method="post" enctype="multipart/form-data">
                                                                      <div class="m-2">
                                                                           <div class="m-2">
                                                                                <input type="hidden" name="id" value="<?php echo $pet->getId() ?>">
                                                                                <label for=""><strong>Select image</strong></label>
                                                                                <input type="file" name="photo" required>
                                                                           </div>
                                                                           <div class="m-2">
                                                                                <button type="submit" name="btn" class="btn btn-secondary">Upload</button>
                                                                           </div>
                                                                      </div>

                                                                 </form>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="modal-footer">
                                                  <button name="btn" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="modal fade" id="vacunationPlan">
                                   <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                                  <h5 class="modal-title text-dark" id="exModalLabel">Vacunation plan</h5>
                                             </div>
                                             <div class="modal-body">
                                                  <div class="container-fluid">
                                                       <div class="row">
                                                            <div class="col">
                                                                 <div class="card">
                                                                      <a href="https://images3.alphacoders.com/857/857335.jpg" target="_blank">
                                                                           <img class="card-img-top" src="https://images3.alphacoders.com/857/857335.jpg" alt="">
                                                                      </a>
                                                                      <div class="card-body">
                                                                           Esquema
                                                                      </div>
                                                                 </div>
                                                            </div>
                                                            <div class="col">
                                                                 <form action="<?php echo FRONT_ROOT . "Pet/UploadPhoto"?>" method="post">
                                                                      <div class="m-2">
                                                                           <div class="m-2">
                                                                                <label for=""><strong>Select image</strong></label>
                                                                                <input type="file">
                                                                           </div>
                                                                           <div class="m-2">
                                                                                <button class="btn btn-secondary">Upload</button>
                                                                           </div>
                                                                      </div>

                                                                 </form>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="modal-footer">
                                                  <button name="btn" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                             </div>
                                        </div>
                                   </div>
                              </div>
                              <div class="modal fade" id="video">
                                   <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                             <div class="modal-header">
                                                  <h5 class="modal-title text-dark" id="exModalLabel">Video</h5>
                                             </div>
                                             <div class="modal-body">
                                                  <div class="container-fluid">
                                                       <div class="row">
                                                            <div class="col">
                                                                 <div class="card">
                                                                      <video controls>
                                                                           <source src="http://techslides.com/demos/sample-videos/small.mp4">
                                                                      </video>
                                                                 </div>
                                                            </div>
                                                            <div class="col">
                                                                 <form action="<?php echo FRONT_ROOT . "Pet/UploadPhoto"?>" method="post">
                                                                      <div class="m-2">
                                                                           <div class="m-2">
                                                                                <label for=""><strong>Select video</strong></label>
                                                                                <input type="file">
                                                                           </div>
                                                                           <div class="m-2">
                                                                                <button class="btn btn-secondary">Upload</button>
                                                                           </div>
                                                                      </div>

                                                                 </form>
                                                            </div>
                                                       </div>
                                                  </div>
                                             </div>
                                             <div class="modal-footer">
                                                  <button name="btn" class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                                             </div>
                                        </div>
                                   </div>
                              </div>
               <?php
                    }
               } else {
                    echo "<div class='container alert alert-warning'>
                         <div class='content text-center'>
                              <p><strong>Usted no cuenta con mascotas, para comezar agrege uno con el boton #Add</strong></p>
                         </div>
                    </div>";
               }
               ?>
                    </tbody>
               </table>
          </div>
          <?php
                    if($message != "") {
                    ?>
                         <div class='form-group text-center'>
                    <?php
                         if($type == "") {
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