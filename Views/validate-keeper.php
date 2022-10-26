<?php
include('header.php');
include('nav-user.php');
?>
<main class="py-5">
    <section id="listado" class="mb-5">
        <div class="container">
            <h2 class="mb-4">Activar Keeper</h2>
            <form action="<?php echo FRONT_ROOT . "Keeper/Add" ?>" method="post" class="bg-light-alpha p-5">
                <div class="row">
                    <div class="col-lg-3">
                        <div class="form-group">
                            <label for="">cantidad a abonar</label>
                            <input type="number" name="count" value="" class="form-control" >
                            <label>Activar session Keeper??</label>
                            <div>
                            <input type="radio" id="si" value=1 name="user_sex" >
                            <label for="Si">Si</label>
                            <input type="radio" id="no" value=0 name="user_sex" checked>
                            <label for="No">No</label>
                            </div>
                        </div>
                    </div>
                </div>
                <button type="submit" name="button" class="btn btn-dark ml-auto d-block">Agregar</button>
            </form>
        </div>
    </section>
</main>