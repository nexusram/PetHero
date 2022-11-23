<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <div class="mb-3">
                    <div>
                         <a class="btn btn-success" href="<?php echo FRONT_ROOT . "Booking/ShowAddFiltersView" ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                   <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                              </svg>
                              Add Booking
                         </a>
                    </div>
               </div>
          <div class="container">
               <h2 class="mb-4">Your Active Bookings </h2>
               <table class="table table-dark text-center"> 
                    <thead>
                         <th>Pets</th>
                         <th>Start Dates</th>
                         <th>End Dates</th>
                         <th>Keeper</th>
                         <th>Validade</th>
                    </thead>
                    <tbody>
                         <?php
                              if(!empty($bookingList)){
                                   foreach($bookingList as $booking) {
                                        ?>
                                             <tr>
                                                  <td><?php echo $booking->getPet()->getName();?></td>
                                                  <td><?php echo $booking->getStartDate(); ?></td>
                                                  <td><?php echo $booking->getEndDate(); ?></td>
                                                  <td><?php echo $booking->getKeeper()->getUser()->getName() ." ". $booking->getKeeper()->getUser()->getSurname() ?></td>
                                                  <td>
                                                       <?php
                                                       if($booking->getState() == 1) {
                                                            echo "<span class='badge bg-success p-2'>Confirm</span>";
                                                       } else if ($booking->getState() == 0){
                                                            echo "<span class='badge bg-warning p-2'>In wait</span>";
                                                       } else {
                                                            echo "<span class='badge bg-danger p-2'>Declined</span>";
                                                       }
                                                       ?>
                                                  </td>
                                             </tr>
                                        <?php
                                   }
                              }
                         ?>
                    </tbody>
               </table>
          </div>
     </section>
</main>

<?php include('footer.php') ?>
