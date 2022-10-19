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
        <h2>MODIFY BEER</h2>
        <form action="<?php echo FRONT_ROOT . "Beer/Modify"?>" method="post"  style="background-color: #EAEDED;padding: 2rem !important;">
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
                  <input type="hidden" name="id" value="<?php echo $beer->getId() ?>">
                  <input type="number" name="code" value="<?php echo $beer->getCode() ?>" required>
                </td>
                <td>
                  <input type="text" name="description" value="<?php echo $beer->getDescription() ?>" required>
                </td>
                <td>
                  <input type="text" name="density" value="<?php echo $beer->getDensity() ?>" required>
                </td>
                <td>
                  <select name="beerType" id="beerType" class="select">
                      <?php
                        $beerTypeDAO = new BeerTypeDAO();
                        $beerTypeList = $beerTypeDAO->GetAll();

                        foreach($beerTypeList as $beerType) {
                          if($beerType->getId() == $beer->getBeerType()->getId()) {
                            echo "<option selected value=". $beerType->getId() .">
                            ". $beerType->getName(). "
                            </option>";
                          } else {
                            echo "<option value=". $beerType->getId() .">
                            ". $beerType->getName(). "
                            </option>";
                          }
                        }
                      ?>
                  </select>
                </td>   
                <td>
                  <input type="text" name="price" value="<?php echo $beer->getPrice() ?>" required>
                </td>      
              </tr>
              </tbody>
          </table>
          <div>
            <input type="submit" class="btn" value="Modificar" style="background-color:#DC8E47;color:white;"/>
          </div>
          <div>
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