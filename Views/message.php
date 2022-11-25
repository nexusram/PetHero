<?php
if ($message != "") {
?>
<div class = "container">
    <div class='form-group text-center'>
        <?php
        if ($type == "") {
        ?>
            <div class='alert alert-danger mt3'>
                <p><?php echo $message ?></p>
            </div>
        <?php
        } else {
        ?>
            <div class='alert alert-success mt-3'>
                <p><?php echo $message ?></p>
            </div>
    <?php
        }
    }

?>
</div>