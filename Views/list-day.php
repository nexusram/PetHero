<?php

use Controllers\HomeController;

include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <div class="mb-3">
                    <div>
                         <a class="btn btn-success" href="<?php echo FRONT_ROOT . "Day/ShowAddView" ?>">
                              <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-plus-circle-fill" viewBox="0 0 16 16">
                                   <path d="M16 8A8 8 0 1 1 0 8a8 8 0 0 1 16 0zM8.5 4.5a.5.5 0 0 0-1 0v3h-3a.5.5 0 0 0 0 1h3v3a.5.5 0 0 0 1 0v-3h3a.5.5 0 0 0 0-1h-3v-3z" />
                              </svg>
                              Add Day/s
                         </a>
                    </div>
               </div>
               <h2 class="mb-4">Available day's</h2>
               <?php
               if (!empty($dayList)) {
               ?>
                    <table class="table table-dark text-center">
                         <thead>
                              <th>Day</th>
                              <th>Month</th>
                              <th>Year</th>
                              <th>Date</th>
                              <th>Available</th>
                              <th>Actions</th>
                         </thead>
                         <tbody>
                         <?php
                    }
                         ?>
                         <?php
                         if (!empty($dayList)) {
                              var_dump($dayList);
                              foreach ($dayList as $day) {
                                  
                         ?>
                                   <form action="<?php echo FRONT_ROOT . "Day/NotAvailable" ?>" method="post">
                                        <tr>
                                             <td><?php echo date("l", strtotime($day->getDate())) ?></td>
                                             <td><?php echo date("F", strtotime($day->getDate())) ?></td>
                                             <td><?php echo date("Y", strtotime($day->getDate()))?></td>
                                             <td><?php echo $day->getDate() ?></td>
                                             <td>
                                                <?php
                                                    if($day->getIsAvailable()) {
                                                        echo "<span class='badge bg-success'>Yes</span>";
                                                    } else {
                                                        echo "<span class='badge bg-danger'>No</span>";
                                                    }
                                                ?>
                                             </td>
                                             <td>
                                                  <button type="submit" name="btnNotAvailable" class="btn btn-danger" value="<?php echo $day->getId() ?>">X</button>
                                             </td>
                                        </tr>
                                   </form>
                         <?php
                              }
                         } else {
                              echo "<div class='container alert alert-warning'>
                         <div class='content text-center'>
                              <p><strong>You have no added days. to start add with the #Add button</strong></p>
                         </div>
                    </div>";
                         }
                         ?>
                         </tbody>
                    </table>
                    <form action="<?php echo FRONT_ROOT . "Day/ShowNotAvailableView"?>">
                         <button class="btn btn-secondary" name="btn">Not Available Days</button>
                    </form>
          </div>
          <?php
          $controller = new HomeController();
          $controller->Message($message, $type);
                    ?>
               </div>
          <?php
          ?>
     </section>
</main>