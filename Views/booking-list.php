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
                         <th>Owners</th>
                    </thead>
                    <tbody>
                         <?php
                              if(isset($bookingList) && isset($userList)){
                                   foreach($bookingList as $booking){
                                        foreach($userList as $user)
                                        {
                                            $userAux= $user->GetById($booking->getIdOwner());
                                        ?>
                                             <tr> <!--$petDAO nos devuelve la mascota, consigo su id mediante el booking, y de esa mascota obtengo el nombre-->

                                                  <td><?php echo $booking->getPet()->getName();?></td>
                                                  <td><?php echo $booking->getStartDate(); ?></td>
                                                  <td><?php echo $booking->getEndDate(); ?></td>
                                                  <td><?php echo $booking->getKeeper()->getUser()->getName(); ?></td>
                                                  <td>
                                                       <a class="btn btn-info" href="<?php echo FRONT_ROOT . "User/ShowContactView/" .$userAux->getId(); ?>">
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-telephone" viewBox="0 0 16 16">
                                                                 <path d="M3.654 1.328a.678.678 0 0 0-1.015-.063L1.605 2.3c-.483.484-.661 1.169-.45 1.77a17.568 17.568 0 0 0 4.168 6.608 17.569 17.569 0 0 0 6.608 4.168c.601.211 1.286.033 1.77-.45l1.034-1.034a.678.678 0 0 0-.063-1.015l-2.307-1.794a.678.678 0 0 0-.58-.122l-2.19.547a1.745 1.745 0 0 1-1.657-.459L5.482 8.062a1.745 1.745 0 0 1-.46-1.657l.548-2.19a.678.678 0 0 0-.122-.58L3.654 1.328zM1.884.511a1.745 1.745 0 0 1 2.612.163L6.29 2.98c.329.423.445.974.315 1.494l-.547 2.19a.678.678 0 0 0 .178.643l2.457 2.457a.678.678 0 0 0 .644.178l2.189-.547a1.745 1.745 0 0 1 1.494.315l2.306 1.794c.829.645.905 1.87.163 2.611l-1.034 1.034c-.74.74-1.846 1.065-2.877.702a18.634 18.634 0 0 1-7.01-4.42 18.634 18.634 0 0 1-4.42-7.009c-.362-1.03-.037-2.137.703-2.877L1.885.511z"/>
                                                            </svg>
                                                       </a>
                                                  </td>
                                             </tr>
                                        <?php
                                        }
                                   }
                              }
                         ?>
                    </tbody>
               </table>
          </div>
     </section>
</main>

<?php include('footer.php') ?>
