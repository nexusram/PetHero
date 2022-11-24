<?php

use Models\Booking;
use Others\Utilities;

include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Booking's <strong class="text text-primary">"Declined"</strong></h2>
               <table class="table table-dark text-center"> 
                    <thead>
                         <th>Pet</th>
                         <th>Start Date</th>
                         <th>End Date</th>
                         <th>Price for day</th>
                         <th>Days quantity</th>
                         <th>Total</th>
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
                                                  <td><?php echo $booking->getKeeper()->getRemuneration() ?></td>
                                                  <td><?php $date = new Utilities(); echo $date->getDiference($booking->getStartDate(), $booking->getEndDate()) ?></td>
                                                  <td><?php echo $booking->getTotal()?></td>
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
          </div>
          <div class="mt-3">
          <?php
               require_once(VIEWS_PATH . "message.php");
          ?>
          </div>
     </section>
</main>
<?php
include('footer.php')
?>
