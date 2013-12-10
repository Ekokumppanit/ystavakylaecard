<div class="row">

    <div class="large-12 columns">
        <div class="panel">
            <h2>Lähetetyt kortit</h2>
            <p>Tällaisia tervehdyksiä on jo lähtenyt, laita sinäkin omasi!</p>
            <p>
                Postikortit ovat järjestetty luomisjärjestykseen, uusimmat ensimmäiseksi.
                Tällä hetkellä postikortteja on kaikkiaan <strong><?=$count->all;?></strong> kappaletta joista
                näytetään julkisesti <strong><?=$count->public;?></strong> kappaletta.
                Yksityisiä kortteja on <strong><?=$count->private;?></strong> kappaletta.
            </p>
        </div>
    </div>

<?php $this->load->view('_partial_cardlist.php', array('amount' => $count->public)); ?>


</div>

