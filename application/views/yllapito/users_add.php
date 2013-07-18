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
                Sinulla ei ole oikeutta käyttäjien lisäämiseen.
            </div>
            <?php echo lnk("yllapito/users", "Takaisin"); ?>
    <?php
} else {

    $post_url = site_url("yllapito/users/create");
    $options = array('no' => 'Ei voi', 'yes' => 'Kyllä voi');
    $dd = ' class="medium large-6 small-12"';

    $inputs = array(
        'name'  => 'name',
        'id'    => 'name',
        'value' => '',
        'required' => null
    );
    ?>
            <h2>Lisää uusi käyttäjä</h2>

            <div class="row">
                <form action="<?php echo $post_url; ?>" method="post"
                    accept-charset="utf-8" id="user_add" class="custom">
                    <div class="large-4 small-12 columns">
                        <h3>Tiedot</h3>
                        <?php
                            echo form_label('Käyttäjätunnus (email)', 'username') . "\n";
                            $inputs['type'] = 'email';
                            $inputs['name'] = 'username';
                            $inputs['id'] = 'username';
                            echo form_input($inputs) . "\n";

                            unset($inputs['type']);

                            echo form_label('Etunimi', 'firstname') . "\n";
                            $inputs['name'] = 'firstname';
                            $inputs['id'] = 'firstname';
                            echo form_input($inputs) . "\n";

                            echo form_label('Sukunimi', 'lastname') . "\n";
                            $inputs['name'] = 'lastname';
                            $inputs['id'] = 'lastname';
                            echo form_input($inputs) . "\n";
                        ?>
                    </div>
                    <div class="large-4 small-12 columns">
                        <h3>Oikeudet</h3>
                        <?php
                            echo form_label('Voi hallita kortteja', 'can_approve') . "\n";
                            echo form_dropdown('can_approve', $options, null, $dd);

                            echo form_label('Voi nähdä käyttäjät', 'can_seeusers') . "\n";
                            echo form_dropdown('can_seeusers', $options, null, $dd);

                            echo form_label('Voi muokata käyttäjiä', 'can_modusers') . "\n";
                            echo form_dropdown('can_modusers', $options, null, $dd);
                        ?>
                    </div>
                    <div class="large-4 small-12 columns">
                        <h3>Salasana</h3>
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

                            $password['id'] = 'password_again';
                            $password['name'] = 'password_again';
                            echo form_label('Salasana uudelleen', 'password_again') . "\n";
                            echo form_password($password) . "\n";

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
    <?php
}
?>

        </div>
    </div>
</div>