
<div class="row">
    <div class="large-12 columns">
        <div class="panel">
<?php
if (empty($ecard)) {
    $ecard = new stdClass();
}

if ($ecard and $ecard->response == "200") {


    $time = date("d.m.Y \k\l\o H.i", strtotime($ecard->created_at));

    ?>
        <img src="<?php echo site_url('assets/cards/' . $ecard->hash . '.png'); ?>" width="100%">

        <h2><?php echo $ecard->message_title; ?></h2>
        <p>
            <?php echo nl2br($ecard->message_content); ?>
        </p>

        <hr>

    <?php
    if ($ecard->card_status == "queue") { ?>
            <div data-alert class="alert-box">
        Tämä kortti on vielä ylläpidon jonossa, eikä se näy kuin linkkiä seuraamalla.<br>
    <?php
        if ($ecard->private == "yes") { ?>
            Koska valitsit että korttia ei saa julkaista,
            ei ylläpitokaan sitä pysty lisäämään sivuston "Listaa kaikki"-osioon.
    <?php
        } else { ?>
            Kun ylläpito on tarkastanut kortin, päätetään voidaanko korttia julkaista "Listaa kaikki"-osioon.
    <?php
        }
        ?></div><?php
    }
    ?>

        <p>
            <ul style="list-style: none">
                <li>Lähettäjä: <?php echo $ecard->uploader_name; ?></li>
                <li>Vastaanottaja: <?php echo $ecard->receiver_name; ?></li>
                <li>Koska lähetetty: <?php echo $time; ?></li>
                <li>Osoite tähän korttiin: <code><?php echo site_url('ecards/' . $ecard->hash); ?></code></li>
            </ul>
        </p>


    <?php
} else {
    ?>
        <h2>Tunnuksella ei löytynyt ainuttakaan korttia</h2>
        <p>Sähköpostikortti on joko poistettu järjestelmästä, tai sitten seurasit rikkinäistä linkkiä.</p>
        <p></p>
    <?php
}
    ?>

        </div>
    </div>
</div>