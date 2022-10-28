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
                            <label>Remuneration*</label>
                            <input type="number" name="remuneration" min=0 class="form-control mb-3"  placeholder="Expected remuneration" required>

                            <label>Size of pet to care*</label>
                            <select class="form-control mb-3" name="petSize" id="petSize" required>
                                <?php
                                foreach ($petSizeList as $petSize) {
                                    echo "<option value=" . $petSize->getId() . ">
                                                " . $petSize->getName() . "
                                            </option>";
                                }
                                ?>
                            </select>
                            <label>Description*</label>
                            <input type="String" name="Description" class="form-control mb-3" placeholder="description of the animal" required>
                            <label>Start Date</label>
                            <?php echo "<input class='form-control mb-3' type='date' name='startDate' min='" . date('Y-m-d') ."'required>"; ?>
                            <label>End Date</label>
                            <?php echo "<input class='form-control mb-3' type='date' name='endDate' min='" . date('Y-m-d') . "required'>"; ?>
                            <div>
                                <a class="btn btn-danger" href="<?php echo FRONT_ROOT . "Pet/ShowPetListView" ?>">Cancel</a>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
            </form>
        </div>
    </section>
</main>