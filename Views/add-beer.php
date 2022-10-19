<?php

use DAO\BeerTypeDAO;

 include('nav-bar.php');
 require_once(VIEWS_PATH . "validate-session.php");
?>
<!-- ################################################################################################ -->
<div class="wrapper row2 bgded" style="background-image:url('../images/demo/backgrounds/1.png');">
  <div class="overlay">
    <div id="breadcrumb" class="clear"> 
      <ul>
        <li><a href="<?php echo FRONT_ROOT . "Cellphone/ShowAddView"?>">Home</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Cellphone/ShowAddView"?>">Add Cellphone</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Cellphone/ShowListView"?>">List/Remove Cellphone</a></li>
        <li><a href="<?php echo FRONT_ROOT . "BeerType/ShowAddView"?>">Add BeerType</a></li>
        <li><a href="<?php echo FRONT_ROOT . "BeerType/ShowListView"?>">List/Remove BeerType</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Beer/ShowAddView"?>">Add Beer</a></li>
        <li><a href="<?php echo FRONT_ROOT . "Beer/ShowListView"?>">List/Remove Beer</a></li>
      </ul>
    </div>
  </div>
</div>
<!-- ################################################################################################ -->
<div class="wrapper row4">
<main class="container clear"> 
    <div class="content"> 
      <div id="comments" >
        <h2>ADD NEW BEER</h2>
        <form action="<?php echo FRONT_ROOT . "Beer/Add"?>" method="post"  style="background-color: #EAEDED;padding: 2rem !important;">
          <table> 
            <thead>
              <tr>
                <th>Code</th>
                <th>Description</th>
                <th>Density</th>
                <th>BeerType</th>
                <th>Price</th>
              </tr>
            </thead>
            <tbody align="center">
              <tr>
                <td style="max-width: 100px;">
                  <input type="number" name="code" required>
                </td>
                <td>
                  <input type="text" name="description" required>
                </td>
                <td>
                  <input type="text" name="density" required>
                </td>
                <td>
                  <select name="beerType" id="beerType" class="select">
                      <?php
                        $beerTypeDAO = new BeerTypeDAO();
                        $beerTypeList = $beerTypeDAO->GetAll();

                        foreach($beerTypeList as $beerType) {
                          echo "<option value=". $beerType->getId() .">
                          ". $beerType->getName(). "
                          </option>";
                        }
                      ?>
                  </select>
                </td>   
                <td>
                  <input type="text" name="price" required>
                </td>      
              </tr>
              </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Agregar" style="background-color:#DC8E47;color:white;"/>
          </div>
          <div>
            <?php
                if($message != "") {
                  echo "<div>
                    <p>". $message ."</p>
                  </div>";
                }
            ?>
          </div>
        </form>
      </div>
    </div>
  </main>
</div>
<!-- ################################################################################################ -->

<?php 
  include('footer.php');
?>