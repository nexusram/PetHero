<?php
include_once(VIEWS_PATH . "validate-session.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Keepers</h2>
               <table class="table bg-light-alpha">
                    <thead>
                         <th>Name</th>
                         <th>Address</th>
                         <th>Pet Size to Keep</th>
                         <th>Remuneration</th>
                    </thead>
                    <tbody>
                         <form action="process/removeBeer.php" method="POST">
                         <?php
                              if(isset($keeperList)){
                                   foreach($keeperList as $keeper){
                                   
                                        ?>
                                             <tr>
                                                  <td><?php echo $keeper->getUser()->getName(); ?></td>
                                                  <td><?php echo $keeper->getUser()->getAddress(); ?></td>
                                                  <td><?php echo $keeper->getPetSize()->getName(); ?></td>
                                                  <td><?php echo $keeper->getRemuneration(); ?></td>
                                                  <td> 
                                                       <button type="submit" name="btnRemove" class="btn btn-danger" value=""</button>
                                                  </td>
                                             </tr>
                                        <?php
                                   }
                              }
                         ?>
                         </form>
                    </tbody>
               </table>
          </div>
     </section>
</main>

<?php include('footer.php') ?>
