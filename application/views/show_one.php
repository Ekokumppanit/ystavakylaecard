
<div class="row">
    <div class="large-12 columns">
        <div class="panel">
<?php
    if( $ecard and $ecard->response == "200" ) {
?>
        <h2>Postikortti #<?php echo $ecard->id;?></h2>
<?php
    } else {
?>
        <h2>Tunnuksella ei löytynyt ainuttakaan korttia</h2>
        <p>Sähköpostikortti on joko poistettu järjestelmästä, tai sitten seurasit rikkinäistä linkkiä.</p>
        <p></p>
<?php
    }
?>
        <pre><?php var_export($ecard); ?></pre>

        </div>
    </div>
</div>