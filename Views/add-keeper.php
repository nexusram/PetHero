<?php
include_once(VIEWS_PATH . "validate-session.php");
include_once(VIEWS_PATH . "nav-user.php");
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Keeper Register</h2>
            <form action="<?php echo FRONT_ROOT . "Keeper/Add" ?>" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group">
                            <label for="">Remuneration*</label>
                            <input type="number" name="remuneration" min=0 class="form-control mb-3" placeholder="Expected remuneration" required>

                            <label for="">Size of pet to care*</label>
                            <select class="form-control mb-3" name="petSize" id="petSize" required>
                                <?php
                                        foreach($petSizeList as $petSize) {
                                            echo "<option value=". $petSize->getId() .">
                                                " . $petSize->getName() . "
                                            </option>";
                                        }
                                ?>
                            </select>

                            <label for="">Description*</label>
                            <input type="textarea" name="description" class="form-control mb-3" placeholder="Enter your description" required>

                            <!--agregar campos de start y end fecha-->

                            <div>
                                <a class="btn btn-danger" href="<?php echo FRONT_ROOT . "Pet/ShowPetListView"?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
            </form>
        </div>
    </section>
</main>