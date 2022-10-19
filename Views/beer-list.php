<?php 
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
  <main class="hoc container clear"> 
    <!-- main body -->
    <div class="content"> 
      <div class="scrollable">
      <form action="<?php echo FRONT_ROOT . "Beer/Remove" ?>" method="post">
        <table style="text-align:center;">
          <thead>
            <tr>
              <th style="width: 5%;">Id</th>
              <th style="width: 10%;">Code</th>
              <th style="width: 10;">Description</th>
              <th style="width: 10">Density</th>
              <th style="width: 10">BeerType</th>
              <th style="width: 20">Price</th>
              <th style="width: 30%">Action</th>
            </tr>
          </thead>
          <tbody>

          <?php
              foreach($beerList as $beer) {
          ?>
            <tr>
                <td><?php echo $beer->getId() ?></td>
                <td><?php echo $beer->getCode() ?></td>
                <td><?php echo $beer->getDescription() ?></td>
                <td><?php echo $beer->getDensity() ?></td>
                <td><?php echo $beer->getBeerType()->getName() ?></td>
                <td><?php echo $beer->getPrice() ?></td>
                <td>
                  <button type="submit" name="code" class="btn" value="<?php echo $beer->getCode() ?>"> Remove </button>
                  <a href="<?php echo FRONT_ROOT . "Beer/ShowModifyView/" . $beer->getCode() ?>" class="btn"> Modificar </a>
                </td>
              </tr>
          <?php
          }
          ?>
          </tbody>
        </table></form> 
      </div>
    </div>
    <!-- / main body -->
    <div class="clear"></div>
  </main>
</div>

<?php 
  include('footer.php');
?>