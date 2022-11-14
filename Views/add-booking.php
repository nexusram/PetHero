<?php

use Controllers\HomeController;

include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Finalize your Booking</h2>
               <form action="<?php echo FRONT_ROOT . "Booking/Add" ?>" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-2"></div>
                         <div class="col-lg-8">
                              <div class="form-group">
                                   <input type="hidden" name="pet" value="<?php echo $pet->getId() ?>">
                                   <input type="hidden" name="startDate" value="<?php echo $startDate ?>">
                                   <input type="hidden" name="endDate" value="<?php echo $endDate ?>">
                                   <?php
                                   if (!empty($keeperList)) {
                                   ?>
                                        <label for="">Select your keeper</label>
                                        <select class="form-control mb-3" name="keeper" required>
                                             <?php
                                             foreach($keeperList as $keeper) {
                                                  echo "<option value=". $keeper->getId() .">
                                                       ". $keeper->getUser()->getName() ." / $ ". $keeper->getRemuneration() . " for day
                                                  </option>";
                                             }
                                             ?>
                                        </select>
                                        <button type="submit" name="button" class="btn btn-success ml-auto d-block text-center">
                                             <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                                  <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                             </svg>
                                             Confirm my booking
                                        </button>
                              </div>
                         </div>
                    <?php
                         }
                    ?>
               </form>
               <?php
               $type ="";
               $controller = new HomeController();
               $controller->Message($message, $type);
               ?>
          </div>
          <div class="container">
               <a class="btn btn-danger m-auto" href="<?php echo FRONT_ROOT . "Booking/ShowAddFiltersView" ?>">Cancel</a>
          </div>
     </section>
</main>