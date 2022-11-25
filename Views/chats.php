<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");

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
                              Your chat's
                         </a>
                    </div>
               </div>
               <div class="container">
                    <h2 class="mb-4">Your Active Bookings </h2>
                    <table class="table table-dark text-center">
                         <thead>
                              <th>User's</th>
                              <th>Time</th>
                         </thead>
                         <tbody>
                         <form action="<?php echo FRONT_ROOT."Chat/ShowChatPersonalView"?>" method="post">  
                              <?php
                                if(!empty($chatList)){
                                    foreach($chatList as $chat){
                                       ?>
                                       <tr>
                                        <td><?php echo $chat->getReciever_user_id()?></td>
                                        <td><?php echo $chat->getCreated_on()?><td>
                                       </tr>
                                       <?php     
                                    }
                                }
                                else{
                                    echo 'Sorry, you currently have no chats, come back later...';
                                }
                              ?>
                                                            
                           </form>    
                         </tbody>
                    </table>
               </div>
     </section>
</main>

<?php include('footer.php') ?>