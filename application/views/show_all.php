
<?php
    $cards = rand(10, 200);
    $private = rand(4,100);
    $public = $cards-$private;

    if( $public < 4 ) {
        $public = rand(10, 200);
        $private = $private + $public;
        $cards = $public + $private;
    }
?>
<div class="row">

    <div class="large-12 columns">
        <div class="panel">
            <h2>Tässä kaikki Ystäväkylän sähköpostikortit!</h2>
            <p>Postikortit ovat järjestetty luomisjärjestykseen, uusimmat ensimmäiseksi. Tällä hetkellä postikortteja on kaikkiaan <strong><?=$cards;?></strong> kappaletta joista näytetään julkisesti <strong><?=$public;?></strong> kappaletta. Yksityisiä kortteja on <strong><?=$private;?></strong> kappaletta.</p>
        </div>
    </div>

<?php $this->load->view('_partial_cardlist.php', array('amount' => $public)); ?>


</div>

