<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Pet | Add</h2>
               <form action="<?php echo FRONT_ROOT . "Pet/Add" ?>" method="post" enctype="multipart/form-data" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-2"></div>
                         <div class="col-lg-8">
                              <div class="form-group">
                                   <input type="hidden" name="name" value="<?php echo $name; ?>">
                                   <input type="hidden" name="petType" value="<?php echo $petType; ?>">

                                   <label for="">Breed</label>
                                   <select class="form-control" name="breed" id="breed" required>
                                        <?php
                                        foreach ($breedList as $breed) {
                                        ?>
                                             <option value=<?php echo $breed->getId(); ?>>
                                                  <?php
                                                  echo $breed->getName(); ?></option>
                                        <?php
                                        }
                                        ?>
                                   </select>

                                   <label for="">Pet Size</label>
                                   <select class="form-control" name="petSize" id="petSize" required>
                                        <?php
                                        foreach ($petSizeList as $petSize) {
                                        ?>
                                             <option value=<?php echo $petSize->getId() ?>><?php echo $petSize->getName() ?></option>
                                        <?php } ?>
                                   </select>

                                   <label for="">Observation</label>
                                   <input type="textarea" name="observation" class="form-control" required>

                                   <label for="">Picture</label>
                                   <input type="file" name="picture" class="form-control" required>

                                   <label for="">Vacunation Plan</label>
                                   <input type="file" name="vacunationPlan" class="form-control" required>

                                   <label for="">Video</label>
                                   <input type="file" name="video" class="form-control">
                              </div>
                         </div>
                    </div>
                    <button type="submit" name="button" class="btn btn-success ml-auto d-block text-center">
                         <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                              <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                         </svg>
                         Add
                    </button>
                    <?php

                    ?>
               </form>
          </div>
     </section>
</main>