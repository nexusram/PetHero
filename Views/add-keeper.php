
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
                                <?php foreach ($petSizeList as $petSize) { ?>
                                    <option value=<?php echo $petSize->getId() ?>><?php echo $petSize->getName() ?></option>
                                    <?php } ?>
                            </select>
                            <label>Description*</label>
                            <input type="text" name="Description" class="form-control mb-3" placeholder="description of the animal" required>
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