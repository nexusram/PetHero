<?php
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container ">
               <h2 class="mb-4">Coupon | booking </h2>
               <form action="<?php echo FRONT_ROOT . "Coupon/PayWithCard" ?>" method="post" class="bg-dark-alpha p-5">
                    <div class="row">
                         <div class="col-lg-3"></div>
                         <div class="col-lg-6">
                              <div class="form-group">
                                   <input type="hidden" name="bookingId" value="<?php echo $bookingId ?>">

                                   <label class="text-white">Card Number</label>
                                   <input class='form-control mb-3' type="text" name="numbers" placeholder="Enter card number" minlength="16" maxlength="16" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required>

                                   <label class="text-white">Type</label>
                                   <select class="form-control mb-3" name="type_card" required>
                                        <option hidden selected>Select a option</option>
                                        <option value="visa">Visa</option>
                                        <option value="mastercard">Mastercard</option>
                                        <option value="naranja">Naranja</option>
                                        <option value="fava">Fava</option>
                                        <option value="american express">American Express</option>
                                   </select>

                                   <label class="text-white">Expiration date</label>
                                   <input class="form-control mb-3" type="date" name="expiration" placeholder="Enter expiration date" required>

                                   <label class="text-white">Cvc</label>
                                   <input class='form-control mb-3' type="cvc" name="cvc" placeholder="Enter cvc of your card" minlength="3" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, ''); this.value = this.value.replace(/(\..*)\./g, '$1');" required>

                                   <label class="text-white">Name</label>
                                   <input class='form-control mb-3' type="text" name="name" placeholder="Enter name of owner it is card" required>

                                   <label class="text-white">Dni</label>
                                   <input class='form-control mb-3' type="text" name="dni" placeholder="Enter dni of owner it is card" required>

                                   <button type="submit" name="btn" class="btn btn-success ml-auto mr-auto d-block text-center p-3 text-white">
                                        Pay
                                   </button>

                                   <a class="btn btn-danger ml-auto mr-auto d-block text-center mt-3 p-3" href="<?php echo FRONT_ROOT . "Booking/ShowListView" ?>">Cancel</a>

                                   <div class="mt-3">
                                        <?php
                                        require_once(VIEWS_PATH . "message.php");
                                        ?>
                                   </div>
                              </div>
                         </div>
               </form>
          </div>
     </section>
</main>