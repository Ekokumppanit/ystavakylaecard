
<div class="row">
    <div class="large-12 small-12 columns">
        <div class="panel">

            <h2>Luo omasi</h2>

            <p>Lähettäminen käy helposti alla olevalla lomakkeella. Valitse kuvavaihtoehdoista pohja joulukortillesi ja kirjoita mukaan omat terveisesi vastaanottajalle. Sen jälkeen kortti onkin valmis matkaan!</p>

            <p>Ystäväkylä maksaa sähköpostikulut!</p>
        </div>
    </div>
</div>

<div class="row">
    <div class="large-6 small-12 columns">
        <div class="panel">
            <form id="ecard_form" method="post" action="<?php echo site_url('tallenna'); ?>">

                <h2>Tiedot</h2>

                <!-- Sender information -->
                <div class="row">
                    <div class="large-12 small-12">
                        <div class="row">
                            <div class="small-12 large-3 columns">
                                <label for="sender_name" class="right">Nimenne</label>
                            </div>
                            <div class="small-12 large-9 columns">
                                <input required type="text" id="sender_name"
                                    name="sender_name" value="" placeholder="Lähettäjän nimi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 large-3 columns">
                                <label for="sender_email" class="right">Email-osoitteenne</label>
                            </div>
                            <div class="small-12 large-9 columns">
                                <input required type="email" id="sender_email"
                                    name="sender_email" value="" placeholder="Lähettäjän email">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Receiver information -->
                <div class="row">
                    <div class="large-12 small-12">
                        <div class="row">
                            <div class="small-12 large-3 columns">
                                <label for="receiver_name" class="right">Vastaanottaja</label>
                            </div>
                            <div class="small-12 large-9 columns">
                                <input required type="text" id="receiver_name"
                                    name="receiver_name" value="" placeholder="Vastaanottajan nimi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 large-3 columns">
                                <label for="receiver_email" class="right">Vastaanottajan email</label>
                            </div>
                            <div class="small-12 large-9 columns">
                                <input required type="email" id="receiver_email"
                                    name="receiver_email" value="" placeholder="Vastaanottajan email">
                            </div>
                        </div>
                    </div>
                </div>


                <!-- Picture -->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label for="select_image" class="right">Valitse kortin taustakuva</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <select name="select_image" id="select_image" class="image-picker">
<?php
if (! empty($images)) {
    foreach ($images as $i => $image) {

        $url  = $image->card_url;
        $name = $image->card_alt . ' (#' . $i . ')';

        ?>                            <option data-img-src='<?php echo $url;
                            ?>' value='<?php
                                echo $url;
                            ?>'>Kuva: <?php echo $name; ?></option><?php
            echo "\n";
    }
}
?>

                        </select>
                    </div>
                </div>


                <!-- Hello -->
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label for="message_title" class="right">Otsikko</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <input type="text" maxlength="200" id="message_title"
                            name="message_title" value="" placeholder="Moikka!">
                    </div>
                </div>
                <div class="row">
                    <div class="small-12 large-3 columns">
                        <label for="message_text" class="right">Viestinne</label>
                    </div>
                    <div class="small-12 large-9 columns">
                        <textarea required id="message_text" name="message_text"
                            placeholder="Terveiset täältä internetistä"></textarea>
                    </div>
                </div>
                <!-- Hidden -->
                <input type="hidden" id="sizeOf_message_text_w"
                        name="sizeOf_message_text_w" value="">
                <input type="hidden" id="sizeOf_message_text_h"
                        name="sizeOf_message_text_h" value="">
                <input type="hidden" id="sizeOf_message_title_w"
                        name="sizeOf_message_title_w" value="">
                <input type="hidden" id="sizeOf_message_title_h"
                        name="sizeOf_message_title_h" value="">

                <input type="hidden" id="sizeOf_image_w"
                        name="sizeOf_image_w" value="">
                <input type="hidden" id="sizeOf_image_h"
                        name="sizeOf_image_h" value="">

                <input type="hidden" id="placeOf_message_text_y"
                        name="placeOf_message_text_y" value="">
                <input type="hidden" id="placeOf_message_text_x"
                        name="placeOf_message_text_x" value="">
                <input type="hidden" id="placeOf_message_title_y"
                        name="placeOf_message_title_y" value="">
                <input type="hidden" id="placeOf_message_title_x"
                        name="placeOf_message_title_x" value="">


                <div class="row">
                    <div class="small-12  large-3 columns">
                        <label for="participate" class="right">Osallistutko arvontaan?</label>
                    </div>
                    <div class="small-12  large-9 columns" style="padding-top:5px;padding-bottom: 10px;">
                        <select name="participate" id="participate">
                            <option value="yes">Kyllä, haluan osallistua</option>
                            <option value="no">En halua osallistua</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-12  large-3 columns">
                        <label for="publiccard" class="right">Listaaminen</label>
                    </div>
                    <div class="small-12  large-9 columns" style="padding-top:5px;padding-bottom: 10px;">
                        <select name="publiccard" id="publiccard">
                            <option value="yes">Kyllä, korttini saa näkyä julkisessa listauksessa</option>
                            <option value="no">En halua, että korttini listataan</option>
                        </select>
                    </div>
                </div>

                <div class="row">
                    <div class="small-12  large-3 columns">&nbsp;</div>
                    <div class="small-12  large-9 columns">
                        <input type="submit" id="submit" class="button" value="Lähetä eKorttisi!" name="submit">
                    </div>
                </div>

            </form>

        </div>
    </div>

    <div class="large-6 small-12 columns">
        <div class="panel previewpanelclear requires-js">
            <h2>Esikatselu</h2>
            <div id="previewpanel">
                <div id="message_title_preview">Moikka!</div>
                <div id="message_text_preview">Terveisiä täältä internetistä!</div>
                <img id="previewimage" src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image">
            </div>
            <p>Voit raahata tässä tekstejä parempiin kohtiin.</p>
        </div>
        <div class="panel noscript">
            <p>
                Jos selaimessanne olisi JavaScript-tuki päällä,
                tässä näkyisi hieno esikatselu kortistanne
                kirjoittamanne tekstin kera.
                <a target="_blank" href="http://www.enable-javascript.com/">Ohjeet tuen päällepistämiseen</a>.
            </p>
            <table>
<?php
if (! empty($images)) {
    foreach ($images as $i => $image) {

        $url  = $image->card_url;
        $name = $image->card_alt . ' (#' . $i . ')';

        ?>
                <tr>
                    <td width="120" class="thumb"><img src="<?php echo $url; ?>" alt="<?php echo $name; ?>"></td>
                    <td class="details">
                        Kuva: <strong><?php echo $name; ?></strong><br>
                        Tekijä: <strong><?php echo $image->card_author; ?></strong><br>
                    </td>
                </tr>
                <?php
            echo "\n";
    }
}
?>
            </table>
        </div>

<?php
if (ENVIRONMENT == "development") {
    ?>
        <div class="panel toteutuva requires-js">
            <a href="javascript:return false;" class="updatepreview">
                <img src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=toteutuva" width="800" height="600">
            </a>
            <small class="url"></small>
        </div>


    <?php
}
?>
        <div class="panel">
            <p>Tiedot kerätään vain postikorttien lähettämiseen ja halutessasi arvontaan osallistumista varten.</p>
        </div>
    </div>


</div>
