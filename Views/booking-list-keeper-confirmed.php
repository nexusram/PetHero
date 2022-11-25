<?php

use Models\Booking;
use Others\Utilities;

include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Booking's <strong class="text text-primary">"Confirmed"</strong></h2>
               <table class="table table-dark text-center">
                    <thead>
                         <th>Pet</th>
                         <th>Client</th>
                         <th>Start Date</th>
                         <th>End Date</th>
                         <th>Price for day</th>
                         <th>Days quantity</th>
                         <th>Total</th>
                         <th>Actions</th>
                    </thead>
                    <tbody>
                         <?php
                         if (!empty($bookingList)) {
                              foreach ($bookingList as $booking) {
                         ?>
                                   <tr>
                                        <td><?php echo $booking->getPet()->getName(); ?></td>
                                        <td><?php echo $booking->getOwner()->getName() . " " . $booking->getOwner()->getSurname() ?></td>
                                        <td><?php echo $booking->getStartDate(); ?></td>
                                        <td><?php echo $booking->getEndDate(); ?></td>
                                        <td><?php echo $booking->getKeeper()->getRemuneration() ?></td>
                                        <td><?php $date = new Utilities();
                                             echo $date->getDiference($booking->getStartDate(), $booking->getEndDate()) ?></td>
                                        <td><?php echo $booking->getTotal() ?></td>
                                        <td>
                                             <form action="<?php echo FRONT_ROOT . "Booking/ShowDetailsView" ?>" method="post">
                                                  <input type="hidden" name="bookingId" value="<?php echo $booking->getId() ?>">
                                                  <button class="btn btn-info">
                                                       <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                                                            <path d="M16 8s-3-5.5-8-5.5S0 8 0 8s3 5.5 8 5.5S16 8 16 8zM1.173 8a13.133 13.133 0 0 1 1.66-2.043C4.12 4.668 5.88 3.5 8 3.5c2.12 0 3.879 1.168 5.168 2.457A13.133 13.133 0 0 1 14.828 8c-.058.087-.122.183-.195.288-.335.48-.83 1.12-1.465 1.755C11.879 11.332 10.119 12.5 8 12.5c-2.12 0-3.879-1.168-5.168-2.457A13.134 13.134 0 0 1 1.172 8z" />
                                                            <path d="M8 5.5a2.5 2.5 0 1 0 0 5 2.5 2.5 0 0 0 0-5zM4.5 8a3.5 3.5 0 1 1 7 0 3.5 3.5 0 0 1-7 0z" />
                                                       </svg>
                                                  </button>
                                             </form>
                                        </td>
                                   </tr>
                         <?php
                              }
                         }
                         ?>
                    </tbody>
               </table>

               <?php
               require_once(VIEWS_PATH . "menu-list.php");
               ?>

               <div class="mt-3">
                    <?php
                    require_once(VIEWS_PATH . "message.php");
                    ?>
               </div>

          </div>
     </section>
</main>

<?php include('footer.php') ?>