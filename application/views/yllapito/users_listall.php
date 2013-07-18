

<div class="row">
    <div class="large-12 small-12 columns">
        <div class="panel">

            <h2>Kaikki käyttäjät</h2>

<?php
if (empty($user)) {
    $user = new stdClass();
}

if ($user->can_seeusers == 'no' && isset($user->can_seeusers)) { ?>
            <div data-alert class="alert-box error">
                Sinulla ei ole oikeutta käyttäjien listaamiseen.
            </div>
    <?php
} else {
    if ($user->can_modusers == 'yes') {
        echo lnk("yllapito/users/add", "Lisää uusi käyttäjä");
    }
    ?>



            <table>
                <thead>
                    <tr>
                        <th>Nimi</th>
                        <th>Tunnus lisätty</th>
                        <th>Edellinen kirjautuminen</th>
                        <th>Julkaisu</th>
                        <th>Näkee jäsenet</th>
                        <th>Hallitsee jäseniä</th>
                    </tr>
                </thead>
                <tbody>
    <?php
    if (empty($users)) {
        $users = array();
    } else {

        $ok = site_url('assets/img/ok.png');
        $no = site_url('assets/img/no.png');
        $now = time();

        foreach ($users as $usr) {

            // Set images accordingly permissions
            $queue  = ($usr->can_approve  == "yes") ? img($ok, true) : img($no, true);
            $seeusr = ($usr->can_seeusers == "yes") ? img($ok, true) : img($no, true);
            $modusr = ($usr->can_modusers == "yes") ? img($ok, true) : img($no, true);

            // Our last login and how show it
            $ll_mysql = strtotime($usr->last_login);
            $lastlogin = (empty($usr->last_login)) ? null : timespan($ll_mysql, $now);

            if (empty($lastlogin)) {
                $lastlogin = "&mdash;";
            } else {
                $lastlogin = $usr->last_login
                            . "<br><small>"
                            . $lastlogin
                            . "</small>";
            }

            $created_at = strtotime($usr->created_at);
            $created    = $usr->created_at
                        . "<br><small>"
                        . timespan(strtotime($usr->created_at), $now)
                        . "</small>";

            $name   = $usr->firstname. " ". $usr->lastname;

            ?>

                    <tr>
                        <td><?php echo lnk("yllapito/users/show/". $usr->id, $name); ?><br>
                            <small><?php echo $usr->username; ?></small>
                        </td>
                        <td><?php echo $created; ?></td>
                        <td><?php echo $lastlogin; ?></td>
                        <td><?php echo $queue; ?></td>
                        <td><?php echo $seeusr; ?></td>
                        <td><?php echo $modusr; ?></td>
                    </tr>

        <?php
        }
    }
    ?>

                </tbody>
            </table>
    <?php
}
?>

        </div>
    </div>
</div>
