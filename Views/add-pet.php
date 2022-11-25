<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Pet | Add</h2>
               <form action="<?php echo FRONT_ROOT . "Pet/ShowSelectBreedView" ?>" method="post" enctype="multipart/form-data" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-2"></div>
                         <div class="col-lg-8">
                              <div class="form-group">
                                   <label for="">Name</label>
                                   <input type="text" name="name" class="form-control" required>

                                   <label for="">Pet type</label>
                                   <select class="form-control" name="petType" id="petType" onchange="sendPetType()" required>
                                        <option hidden selected>Select the option</option>
                                        <?php
                                        foreach ($petTypeList as $petType) {
                                        ?>
                                             <option value=<?php echo $petType->getId(); ?>>
                                                  <?php
                                                  echo $petType->getName(); ?></option>
                                        <?php
                                        }
                                        ?>
                                   </select>

                                   <div class="mt-3">
                                        <button type="submit" name="button" class="btn btn-success ml-auto d-block text-center">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                  <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                             </svg>
                                             Next
                                        </button>
                                   </div>

                                   <?php
                                   include_once(VIEWS_PATH . "message.php");
                                   ?>
               </form>
          </div>
     </section>
</main>