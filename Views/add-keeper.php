<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Owner to Keeper</h2>
            <form action="<?php echo FRONT_ROOT . "Keeper/Add" ?>" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
<<<<<<< HEAD:Views/add-keeper.php

                            <label for="">Remuneration</label>
                            <input type="number" name="remuneration" min=0 class="form-control mb-3" placeholder="500" required>

                            <label for="">Size of pet to care</label>
                            <select class="form-control mb-3" name="petSize" id="petSize" required>
                                <?php
                                        foreach($petSizeList as $petSize) {
                                            echo "<option value=". $petSize->getId() .">
                                                " . $petSize->getName() . "
                                            </option>";
                                        }
                                ?>
                            </select>

                            <label>Activar session Keeper??</label>
                            <div>
                            <input type="radio" id="si" value=1 name="option" >
                            <label for="Si">Si</label>
                            <input type="radio" id="no" value=0 name="option" checked>
                            <label for="No">No</label>
=======
                            <label for="">cantidad a abonar</label>
                            <input type="number" name="count" value="" class="form-control">
                            <label>Activar session Keeper??</label>
                            <div>
                                <input type="radio" id="si" value=1 name="user_sex">
                                <label for="Si">Si</label>
                                <input type="radio" id="no" value=0 name="user_sex" checked>
                                <label for="No">No</label>
>>>>>>> 32ed3c12e2ff0d23502360a2b93732a08461cdf1:Views/validate-keeper.php
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
            </form>
        </div>
    </section>
</main>