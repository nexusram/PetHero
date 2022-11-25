<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container ">
            <h2 class="mb-4">Finish Payment</h2>
            <form action="<?php echo FRONT_ROOT . "Coupon/PayWithCard" ?>" method="post" class="bg-dark-alpha p-5">
                <div class="row">
                    <div class="col-lg-3"></div>
                    <div class="col-lg-6">
                        <div class="form-group">
                            <h2 class="text-center">Thank you for using Fast Pay!</h2>
                            <?php
                            require_once(VIEWS_PATH . "message.php");
                            ?>

                            <div>
                                <a class="btn btn-primary ml-auto mr-auto d-block text-center mt-3 p-3" href="<?php echo FRONT_ROOT . "Booking/ShowListView" ?>">Back</a>
                            </div>
                        </div>
                    </div>
            </form>
        </div>
    </section>
</main>