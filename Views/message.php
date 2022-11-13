<?php
if ($message != "") {
?>
    <div class='form-group text-center'>
        <?php
        if ($type == "") {
        ?>
            <div class='alert alert-danger'>
                <p><?php echo $message ?></p>
            </div>
        <?php
        } else {
        ?>
            <div class='alert alert-success'>
                <p><?php echo $message ?></p>
            </div>
    <?php
        }
    }
    ?>