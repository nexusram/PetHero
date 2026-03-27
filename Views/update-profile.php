
<main class="py-5">
     <section id="listado" class="mb-5">
          <div class="container">
               <h2 class="mb-4">My Profile | Update</h2>
               <table class="table table-bordered table-dark">
                    <form action="<?php echo FRONT_ROOT . "User/Update" ?>">
                         <thead>
                              <tr>
                                   <th>Name</th>
                                   <td><input type="text" name="name" value="<?php echo $_SESSION["loggedUser"]->getName() ?>" class="form-control text-white" style="background-color:transparent" required></td>
                              </tr>
                              <tr>
                                   <th>Surname</th>
                                   <td><input type="text" name="surname" value="<?php echo $_SESSION["loggedUser"]->getSurname() ?>" class="form-control text-white" style="background-color:transparent" required></td>
                              </tr>
                              <tr>
                                   <th>Birthday</th>
                                   <td><input type="Date" name="birthday" value="<?php echo $_SESSION["loggedUser"]->getBirthday() ?>" class="form-control text-white" style="background-color:transparent" required>
                              </tr>
                              <tr>
                                   <th>UseerName</th>
                                   <td><?php echo $_SESSION["loggedUser"]->getUserName() ?></td>
                              </tr>
                              <tr>
                                   <th>Email</th>
                                   <td><?php echo $_SESSION["loggedUser"]->getEmail() ?></td>
                              </tr>
                              <tr>
                                   <th>Cellphone</th>
                                   <td><input type="num" name="cellphone" value="<?php echo $_SESSION["loggedUser"]->getCellphone() ?>" class="form-control text-white" style="background-color:transparent" required></td>
                              </tr>
                              <tr>
                                   <th>Address</th>
                                   <td><input type="text" name="address" value="<?php echo $_SESSION["loggedUser"]->getAddress() ?>" class="form-control text-white" style="background-color:transparent" required></td>
                              </tr>
                         </thead>
                         <tbody>
                              <td>
                                   <button type="submit" name="btn" class="btn btn-success">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="25" height="25" fill="currentColor" class="bi bi-check-lg" viewBox="0 0 16 16">
                                             <path d="M12.736 3.97a.733.733 0 0 1 1.047 0c.286.289.29.756.01 1.05L7.88 12.01a.733.733 0 0 1-1.065.02L3.217 8.384a.757.757 0 0 1 0-1.06.733.733 0 0 1 1.047 0l3.052 3.093 5.4-6.425a.247.247 0 0 1 .02-.022Z" />
                                        </svg>
                                        Update
                                   </button>
                                   <a class="btn btn-danger" href="<?php echo FRONT_ROOT . "User/ShowProfileView" ?>">
                                        X Cancel
                                   </a>
                              </td>
                    </form>
                    </tbody>
               </table>
          </div>
     </section>
</main>