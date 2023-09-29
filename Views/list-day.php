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
                         if (isset($dayList)) {
                              foreach ($dayList as $day) { ?>
                                   <form action="<?php echo FRONT_ROOT . "Day/NotAvailable" ?>" method="post">
                                        <tr>
                                             <td><?php echo date("l", strtotime($day->getDate())) ?></td>
                                             <td><?php echo date("F", strtotime($day->getDate())) ?></td>
                                             <td><?php echo date("Y", strtotime($day->getDate())) ?></td>
                                             <td><?php echo $day->getDate() ?></td>
                                             <td>
                                                  <?php
                                                  if ($day->getIsAvailable()) { ?>
                                                       <span class='badge bg-success'>Yes</span>
                                                  <?php } else { ?>
                                                       <span class='badge bg-danger'>No</span>
                                                  <?php  }
                                                  ?>
                                             </td>
                                             <td>
                                                  <button type="submit" name="btnNotAvailable" class="btn btn-danger" value="<?php echo $day->getId() ?>">X</button>
                                             </td>
                                        </tr>
                                   </form>
                         <?php
                              }
                         }
                         ?>
                    </tbody>
               </table>
               <?php
               if (!empty($listEmpty)) {
                    echo $listEmpty;
               }
               if (!empty($message)) {
                    echo $message;
               }
               ?>
               <div>
                    <a class="btn btn-secondary" href="<?php echo FRONT_ROOT . "Day/ShowNotAvailableView" ?>">
                         Not Available Days
                    </a>
               </div>
          </div>
     </section>
</main>