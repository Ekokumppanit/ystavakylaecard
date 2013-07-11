
<div class="row">
    <div class="large-12 small-12 columns">
        <div class="panel">

            <h2>Luo uusi eKortti!</h2>

            <p>
                Suunnittele oma eKorttisi ja lähetä se ystävällesi!
                Samalla voit osallistua arvontaan josta voit voittaa huikean hienoja palkintoja.
            </p>


        </div>
    </div>
</div>

<div class="row">
    <div class="large-6 small-12 columns">
        <div class="panel">
            <form id="ecard_form">

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
                                    name="sender_name" placeholder="Lähettäjän nimi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 large-3 columns">
                                <label for="sender_email" class="right">Email-osoitteenne</label>
                            </div>
                            <div class="small-12 large-9 columns">
                                <input required type="email" id="sender_email"
                                    name="sender_email" placeholder="Lähettäjän email">
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
                                    name="receiver_name" placeholder="Vastaanottajan nimi">
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-12 large-3 columns">
                                <label for="receiver_email" class="right">Vastaanottajan email</label>
                            </div>
                            <div class="small-12 large-9 columns">
                                <input required type="email" id="receiver_email"
                                    name="receiver_email" placeholder="Vastaanottajan email">
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

        ?>                            <option data-img-src='<?php echo
                                $image;
                            ?>' value='<?php
                                echo $i;
                            ?>'>Cute Kitten <?=$i;?></option><?php
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
                            name="message_title" placeholder="Moikka!">
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
        <div class="panel previewpanelclear">
            <h2>Esikatselu</h2>
            <div id="previewpanel">
                <div id="message_title_preview">Moikka!</div>
                <div id="message_text_preview">Terveisiä täältä internetistä!</div>
                <img id="previewimage" src="http://dummyimage.com/800x600/4d494d/686a82.gif&text=placeholder+image">
            </div>
        </div>
        <div class="panel">
            <p>Tiedot kerätään vain postikorttien lähettämiseen ja halutessasi arvontaan osallistumista varten.</p>
        </div>
    </div>


</div>
