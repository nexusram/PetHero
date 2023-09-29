
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Booking | Details</h2>
            <table class="table bg-light-alpha">
                <thead>
                    <tr>
                        <td>
                            <h5>OWNER</h5>
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $booking->getOwner()->getName() . " " . $booking->getOwner()->getSurname() ?></td>
                    </tr>
                    <tr>
                        <th>Address</th>
                        <td><?php echo $booking->getOwner()->getAddress() ?></td>
                    </tr>
                    <tr>
                        <th>Cellphone</th>
                        <td><?php echo $booking->getOwner()->getCellphone() ?></td>
                    </tr>
                    <tr>
                        <th>Email</th>
                        <td><?php echo $booking->getOwner()->getEmail() ?></td>
                    </tr>
                    <tr>
                        <td>
                            <h5>PET</h5>
                        </td>
                    </tr>
                    <tr>
                        <th>Name</th>
                        <td><?php echo $booking->getPet()->getName() ?></td>
                    </tr>
                    <tr>
                        <th>Type</th>
                        <td><?php echo $booking->getPet()->getBreed()->getPetType()->getName() ?></td>
                    </tr>
                    <tr>
                        <th>Breed</th>
                        <td><?php echo $booking->getPet()->getBreed()->getName() ?></td>
                    </tr>
                    <tr>
                        <th>Size</th>
                        <td><?php echo $booking->getPet()->getPetSize()->getName() ?></td>
                    </tr>
                    <tr>
                        <th>Observation</th>
                        <td><?php echo $booking->getPet()->getObservation() ?></td>
                    </tr>
                    <tr>
                        <th>Picture</th>
                        <td>
                            <a href="<?php echo FRONT_ROOT . base64_decode($booking->getPet()->getPicture()) ?>" target="_blank">
                                <img widht="150px" height="150px" src="<?php echo FRONT_ROOT . base64_decode($booking->getPet()->getPicture()) ?>" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Vacunation Plan</th>
                        <td>
                            <a href="<?php echo FRONT_ROOT . base64_decode($booking->getPet()->getVacunationPlan()) ?>" target="_blank">
                                <img widht="150px" height="150px" src="<?php echo FRONT_ROOT . base64_decode($booking->getPet()->getVacunationPlan()) ?>" alt="">
                            </a>
                        </td>
                    </tr>
                    <tr>
                        <th>Video</th>
                        <td>
                            <?php
                            if ($booking->getPet()->getVideo() != null) {
                            ?>
                                <a href="<?php echo FRONT_ROOT . base64_decode($booking->getPet()->getVideo()) ?>" target="_blank">
                                    <video widht="50px" height="50px">
                                        <source src="<?php echo FRONT_ROOT . base64_decode($booking->getPet()->getVideo()) ?>">
                                    </video>
                                </a>
                            <?php
                            } else {
                                echo "Without video";
                            }
                            ?>
                        </td>
                    </tr>
                    <tr>
                        <th><h5>BOOKING</h5></th>
                    </tr>
                    <tr>
                        <th>StartDate</th>
                        <td><?php echo $booking->getStartDate() ?></td>
                    </tr>
                    <tr>
                        <th>EndDate</th>
                        <td><?php echo $booking->getEndDate() ?></td>
                    </tr>
                    <tr>
                        <th>State</th>
                        <td>
                        <?php
                            if($booking->getState() == 0) {
                                echo "In wait";
                            } else if($booking->getState() == 1) {
                                echo "Confirmed";
                            } else {
                                echo "Declined";
                            }
                        ?>
                        </td>
                    </tr>
                    <tr>
                        <th>IsPayment</th>
                        <td><?php echo ($booking->getValidate()) ? "Yes" : "No" ?></td>
                    </tr>
                    <tr>
                        <th>Total</th>
                        <td><?php echo $booking->getTotal() ?></td>
                    </tr>
                </thead>
                <tbody>
                </tbody>
            </table>
            <a class="btn btn-primary" href="<?php echo FRONT_ROOT . "Booking/ShowPaymentView" ?>">
                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-box-arrow-in-left" viewBox="0 0 16 16">
                    <path fill-rule="evenodd" d="M10 3.5a.5.5 0 0 0-.5-.5h-8a.5.5 0 0 0-.5.5v9a.5.5 0 0 0 .5.5h8a.5.5 0 0 0 .5-.5v-2a.5.5 0 0 1 1 0v2A1.5 1.5 0 0 1 9.5 14h-8A1.5 1.5 0 0 1 0 12.5v-9A1.5 1.5 0 0 1 1.5 2h8A1.5 1.5 0 0 1 11 3.5v2a.5.5 0 0 1-1 0v-2z" />
                    <path fill-rule="evenodd" d="M4.146 8.354a.5.5 0 0 1 0-.708l3-3a.5.5 0 1 1 .708.708L5.707 7.5H14.5a.5.5 0 0 1 0 1H5.707l2.147 2.146a.5.5 0 0 1-.708.708l-3-3z" />
                </svg>
                Back
            </a>
        </div>
    </section>
</main>