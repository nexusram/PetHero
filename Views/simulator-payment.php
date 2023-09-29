
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Coupon | booking </h2>
               <form action="<?php echo FRONT_ROOT . "Coupon/ShowPaymentView" ?>" method="post" class="bg-light-alpha p-5">
                    <div class="row">
                         <div class="col-lg-2"></div>
                         <div class="col-lg-8">
                              <div class="form-group">
                                   <input type="hidden" name="bookingId" value="<?php echo $booking->getId() ?>">

                                    <label>Pet</label>
                                    <input class='form-control mb-3' type="text" name="pet_name" value="<?php echo $booking->getPet()->getName() ?>" disabled required>

                                    <label>Keeper Name</label>
                                    <input class='form-control mb-3' type="text" name="keeper_name" value="<?php echo $booking->getKeeper()->getUser()->getName() . " " . $booking->getKeeper()->getUser()->getSurname() ?>" disabled required>
                                   
                                    <label>Owner Name</label>
                                    <input class='form-control mb-3' type="text" name="owner_name" value="<?php echo $booking->getOwner()->getName() . " " . $booking->getOwner()->getSurname() ?>" disabled required>

                                    <label>Billing address</label>
                                    <input class='form-control mb-3' type="text" name="address" value="<?php echo $booking->getOwner()->getAddress() ?>" required>
                                    <label>Total (it's the 50% of total booking)</label>
                                   <input class='form-control mb-3' type="text" name="total" value="<?php echo $coupon->getTotal() ?>" disabled required>

                                   
                                   <label>Method</label>
                                   <select class='form-control mb-3' name="method" required>
                                        <option value="effective">Effective</option>
                                        <option value="debit">Debit</option>
                                        <option value="credit">Credit</option>
                                   </select>
                              </div>
                              <a class="btn btn-danger" href="<?php echo FRONT_ROOT . "Booking/ShowListView" ?>">Cancel</a>
                              <button type="submit" class="btn btn-success text-center">
                                        Next
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-chevron-right" viewBox="0 0 16 16">
                                            <path fill-rule="evenodd" d="M4.646 1.646a.5.5 0 0 1 .708 0l6 6a.5.5 0 0 1 0 .708l-6 6a.5.5 0 0 1-.708-.708L10.293 8 4.646 2.354a.5.5 0 0 1 0-.708z"/>
                                        </svg>
                                   </button>
                         </div>
               </form>
          </div>
     </section>
</main>