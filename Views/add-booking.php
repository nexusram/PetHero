<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Finalize your Booking</h2>
               <form action="<?php echo FRONT_ROOT . "Booking/Add" ?>" method="post" enctype="multipart/form-data" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-2"></div>
                         <div class="col-lg-8">
                              <div class="form-group">
                                   <?php
                                    if($keeperList){
                                      ?>  
                                
                                   <select class="form-control" name="idKeeper" required>
                                        <?php
                                        foreach ($keeperList as $keeper) {
                                             echo "<option value=" . $keeper->getId() . ">
                                                       " . $keeper->getName() . "
                                                  </option>";
                                        }
                                        ?>
                                   </select>
                                   <?php
                                       }
                                       else{
                                        echo "No Hay Keepers Disponibles";
                                       }     
                                   ?>
               </form>
          </div>
     </section>
</main>