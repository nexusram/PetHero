<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">Not available day's</h2>
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
                         if (!empty($dayList)) {
                              foreach ($dayList as $day) {
                         ?>
                                   <form action="<?php echo FRONT_ROOT . "Day/Available" ?>" method="post">
                                        <input type="hidden" name="dayId" value="<?php echo $day->getId() ?>">
                                        <tr>
                                             <td><?php echo date("l", strtotime($day->getDate())) ?></td>
                                             <td><?php echo date("F", strtotime($day->getDate())) ?></td>
                                             <td><?php echo date("Y", strtotime($day->getDate())) ?></td>
                                             <td><?php echo $day->getDate() ?></td>
                                             <td>
                                                  <?php
                                                  if ($day->getIsAvailable()) {
                                                       echo "<span class='badge bg-success'>Yes</span>";
                                                  } else {
                                                       echo "<span class='badge bg-danger'>No</span>";
                                                  }
                                                  ?>
                                             </td>
                                             <td>
                                                  <?php
                                                  $today = strtotime(date("d-m-Y", time()));
                                                  $date = strtotime($day->getDate());

                                                  if ($today < $date) {
                                                  ?>
                                                       <button class="btn btn-success">
                                                            <input type="hidden" name="message" value="<?php echo $message = "<div class= 'container'>
            <div class='form-group text-center'>
            <div class='alert alert-success mt-3'>
                      <p>Successfully</p>
                      </div></div></div>" ?>">
                                                       <?php
                                                  } else {
                                                       ?>
                                                            <button class="btn btn-secondary" disabled>
                                                            <?php
                                                       }
                                                            ?>
                                                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-calendar-check" viewBox="0 0 16 16">
                                                                 <path d="M10.854 7.146a.5.5 0 0 1 0 .708l-3 3a.5.5 0 0 1-.708 0l-1.5-1.5a.5.5 0 1 1 .708-.708L7.5 9.793l2.646-2.647a.5.5 0 0 1 .708 0z" />
                                                                 <path d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5zM1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4H1z" />
                                                            </svg>
                                                            </button>
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
               ?>
               <a class="btn btn-dark" href="<?php echo FRONT_ROOT . "Day/ShowListView" ?>" value="<?php echo $message = " " ?>">Back</a>
          </div>
          <?php
          if (isset($message))
               echo $message;
          ?>
          </div>
          <?php
          ?>
     </section>
</main>