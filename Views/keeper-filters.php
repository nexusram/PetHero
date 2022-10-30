<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Select your Pet</h2>
               <form action="<?php echo FRONT_ROOT . "Booking/Add" ?>" method="post" enctype="multipart/form-data" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-2"></div>
                         <div class="col-lg-8">
                              <div class="form-group">
                                   <?php
                                    if($petList){
                                      ?>  
                                
                                   <select class="form-control" name="idPet" required>
                                        <?php
                                        foreach ($petList as $pet) {
                                             echo "<option value=" . $pet->getId() . ">
                                                       " . $pet->getName() . "
                                                  </option>";
                                        }
                                        ?>
                                   </select>
                                   <?php
                                       }
                                       else{
                                        echo "Currently, you do not have registered pets....";
                                       }     
                                   ?>
                                   <label>Start Date</label>
                                   <?php echo "<input class='form-control mb-3' type='date' name='startDate' min='" . date ('Y-m-d') ."'required>"; ?>

                                   <label>End Date</label>
                                   <?php echo "<input class='form-control mb-3' type='date' name='endDate' min='" . date   ('Y-m-d') . "required'>"; ?>
                              </div>
                              <a class="btn btn-danger" href="<?php echo FRONT_ROOT . "Pet/ShowPetListView" ?>">Cancel</a>
                         </div>           
               </form>
          </div>
     </section>
</main>