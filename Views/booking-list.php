<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");

use Others\Utilities;
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
                              <th>Price for day</th>
                              <th>Days quantity</th>
                              <th>Total</th>
                              <th>State</th>
                              <th>Action</th>
                         </thead>
                         <tbody>
                              <?php
                              if (!empty($bookingList)) {
                                   foreach ($bookingList as $booking) {
                              ?>
                                        <tr>
                                             <td><?php echo $booking->getPet()->getName(); ?></td>
                                             <td><?php echo $booking->getStartDate(); ?></td>
                                             <td><?php echo $booking->getEndDate(); ?></td>
                                             <td><?php echo $booking->getKeeper()->getUser()->getName() . " " . $booking->getKeeper()->getUser()->getSurname() ?></td>
                                             <td><?php echo $booking->getKeeper()->getRemuneration() ?></td>
                                             <td><?php $date = new Utilities();
                                                  echo $date->getDiference($booking->getStartDate(), $booking->getEndDate()) ?></td>
                                             <td><?php echo $booking->getTotal() ?></td>
                                             <td>
                                                  <?php
                                                  if ($booking->getState() == 1) {
                                                       echo "<span class='badge bg-success p-2'>Confirm</span>";
                                                  } else if ($booking->getState() == 0) {
                                                       echo "<span class='badge bg-warning p-2'>In wait</span>";
                                                  } else {
                                                       echo "<span class='badge bg-danger p-2'>Declined</span>";
                                                  }
                                                  ?>
                                             </td>
                                             <td>
                                                  <div>
                                                       <form action="<?php echo FRONT_ROOT . "Coupon/ShowMakePaymentView" ?>" method="post">
                                                       <input type="hidden" name="id_booking" value="<?php echo $booking->getId() ?>">
                                                       <?php
                                                       if ($booking->getState() != 1 ||$booking->getValidate() == 1) {

                                                            ?>
                                                                 <button class="btn btn-warning" disabled>
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                                           <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                                                           <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                                                           <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                                                           <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                                                      </svg>
                                                                 </button>
                                                            <?php
                                                            } else {
                                                            ?>
                                                                 <button class="btn btn-warning">
                                                                      <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-cash-coin" viewBox="0 0 16 16">
                                                                           <path fill-rule="evenodd" d="M11 15a4 4 0 1 0 0-8 4 4 0 0 0 0 8zm5-4a5 5 0 1 1-10 0 5 5 0 0 1 10 0z" />
                                                                           <path d="M9.438 11.944c.047.596.518 1.06 1.363 1.116v.44h.375v-.443c.875-.061 1.386-.529 1.386-1.207 0-.618-.39-.936-1.09-1.1l-.296-.07v-1.2c.376.043.614.248.671.532h.658c-.047-.575-.54-1.024-1.329-1.073V8.5h-.375v.45c-.747.073-1.255.522-1.255 1.158 0 .562.378.92 1.007 1.066l.248.061v1.272c-.384-.058-.639-.27-.696-.563h-.668zm1.36-1.354c-.369-.085-.569-.26-.569-.522 0-.294.216-.514.572-.578v1.1h-.003zm.432.746c.449.104.655.272.655.569 0 .339-.257.571-.709.614v-1.195l.054.012z" />
                                                                           <path d="M1 0a1 1 0 0 0-1 1v8a1 1 0 0 0 1 1h4.083c.058-.344.145-.678.258-1H3a2 2 0 0 0-2-2V3a2 2 0 0 0 2-2h10a2 2 0 0 0 2 2v3.528c.38.34.717.728 1 1.154V1a1 1 0 0 0-1-1H1z" />
                                                                           <path d="M9.998 5.083 10 5a2 2 0 1 0-3.132 1.65 5.982 5.982 0 0 1 3.13-1.567z" />
                                                                      </svg>
                                                                 </button>
                                                            <?php
                                                            }
                                                            ?>
                                                       </form>
                                                  </div>
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