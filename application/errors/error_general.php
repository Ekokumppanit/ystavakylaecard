<?php
if (!isset($heading)) {
    $heading = "Otsikko";
}
if (!isset($message)) {
    $message = "Viesti";
}

?>

<div class="row">
    <div class="small-12 large-12 columns" id="adminmenu">
        <div class="panel">

            <h2><?php echo $heading; ?></h2>
            <?php echo $message; ?>
        </div>
    </div>
</div>
