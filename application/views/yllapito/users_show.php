
<?php
if (empty($userdata)) {
    $userdata = array();
}

?>

<div class="row">
    <div class="large-12 small-12 columns">
        <div class="panel">

<?php
if ($user->can_seeusers == "no") {
    ?>
            <div data-alert class="alert-box error">
                Sinulla ei ole oikeutta käyttäjien listaamiseen.
            </div>
            <?php echo lnk("yllapito/users", "Takaisin"); ?>
    <?php
} elseif (empty($userdata) || ! is_object($userdata)) {
    ?>
            <h2>Käyttäjää tunnisteella #<?php echo $userid; ?> ei löydetty</h2>
            <?php echo lnk("yllapito/users", "Takaisin"); ?>
    <?php
} else {
    ?>
            <h2>Käyttäjä #<?php echo $userdata->id; ?></h2>


    <?php
}
?>

        </div>
    </div>
</div>