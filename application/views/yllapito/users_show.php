<?php
if (empty($userdata)) {
    $userdata = array();
}
if (empty($user)) {
    $user = new stdClass();
}
if (empty($userid)) {
    $userid = 0;
}
?>

<div class="row">
    <div class="large-12 small-12 columns">
        <div class="panel">

<?php
if ($user->can_modusers == "no") {
    ?>
            <div data-alert class="alert-box error">
                Sinulla ei ole oikeutta käyttäjien muokkaamiseen.
            </div>
            <?php echo lnk("yllapito/users", "Takaisin"); ?>
    <?php
} elseif (empty($userdata) || ! is_object($userdata)) {
    ?>
            <h2>Käyttäjää tunnisteella #<?php echo $userid; ?> ei löydetty</h2>
            <?php echo lnk("yllapito/users", "Takaisin", 'button medium'); ?>
    <?php
} else {

    $post_url = site_url("yllapito/users/");
    $options = array('yes' => 'Kyllä voi', 'no' => 'Ei voi');
    $dd = ' class="medium large-6 small-12"';

    $inputs = array(
        'name'  => 'name',
        'id'    => 'name',
        'value' => '',
        'required' => null
    );
    ?>
            <h2>Käyttäjä #<?php echo $userdata->id; ?></h2>

            <div class="row">
                <form action="<?php echo $post_url."/save/".$userid; ?>" method="post"
                    accept-charset="utf-8" id="user_data" class="custom">
                    <input type="hidden" name="from_page" value="<?php echo current_url(); ?>">
                    <div class="large-6 small-12 columns">
                        <h3>Tiedot</h3>
                        <?php
                            echo form_label('Käyttäjätunnus', 'username') . "\n";
                            $inputs['name'] = 'username';
                            $inputs['id'] = 'username';
                            $inputs['value'] = $userdata->username;
                            echo form_input($inputs) . "\n";

                            echo form_label('Etunimi', 'firstname') . "\n";
                            $inputs['name'] = 'firstname';
                            $inputs['id'] = 'firstname';
                            $inputs['value'] = $userdata->firstname;
                            echo form_input($inputs) . "\n";

                            echo form_label('Sukunimi', 'lastname') . "\n";
                            $inputs['name'] = 'lastname';
                            $inputs['id'] = 'lastname';
                            $inputs['value'] = $userdata->lastname;
                            echo form_input($inputs) . "\n";
                        ?>
                    </div>
                    <div class="large-6 small-12 columns">
                        <h3>Oikeudet</h3>
                        <?php
                            echo form_label('Voi hallita kortteja', 'can_approve') . "\n";
                            echo form_dropdown('can_approve', $options, $userdata->can_approve, $dd);

                            echo form_label('Voi nähdä käyttäjät', 'can_seeusers') . "\n";
                            echo form_dropdown('can_seeusers', $options, $userdata->can_seeusers, $dd);

                            echo form_label('Voi muokata käyttäjiä', 'can_modusers') . "\n";
                            echo form_dropdown('can_modusers', $options, $userdata->can_modusers, $dd);
                        ?>
                    </div>
                    <div class="large-12 small-12 columns">
                        <?php
    echo form_submit(
        array(
            'name' => 'savedata',
            'value' => 'Tallenna tiedot',
            'class' => 'button small large-12 small-12'
        )
    );

                        ?>
                    </div>
                </form>
            </div>
            <div class="row">
                <form action="<?php echo $post_url."/password/".$userid; ?>" method="post"
                    accept-charset="utf-8" id="user_password" class="custom">
                    <input type="hidden" name="from_page" value="<?php echo current_url(); ?>">
                    <div clas="large-12 small-12 columns">
                        <div class="panel">
                            <h3>Salasana</h3>
                            <div class="row">
                                <div class="large-6 small-12 columns">
                                    <?php
                                        $password = array(
                                            'id'        => 'password',
                                            'name'      => 'password',
                                            'minlength' => "2",
                                            'value'     => '',
                                            'required'  => null
                                        );
                                        echo form_label('Salasana', 'password') . "\n";
                                        echo form_password($password) . "\n";
                                    ?>
                                </div>
                                <div class="large-6 small-12 columns">
                                    <?php
                                        $password['id'] = 'password_again';
                                        $password['name'] = 'password_again';
                                        echo form_label('Salasana uudelleen', 'password_again') . "\n";
                                        echo form_password($password) . "\n";
                                    ?>
                                </div>
                            </div>
                            <?php
    echo form_submit(
        array(
            'name' => 'savepassword',
            'value' => 'Tallenna uusi salasana',
            'class' => 'button small large-12 small-12'
        )
    );
                            ?>
                        </div>
                    </div>
                </form>
            </div>
            <div class="row">
                <div clas="large-12 small-12 columns">
                    <div class="panel">
                        <h3>Poista käyttäjä</h3>
                        <div class="row">
                            <div class="large-12 small-12 columns">
                                <?php
    if ($user->id == $userid) { ?>
                                <strong>Et voi poistaa itseäsi, hassu.</strong>
                                <?php
    } else {
                                ?>
                                <a class="deleteuser button medium alert large-12 small-12"
                                    href="<?php echo $post_url."/delete/".$userid; ?>">Poista käyttäjä</a>
                                <?php
    }
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
    <?php
}
?>

        </div>
    </div>
</div>