

<div class="row">
    <div class="large-12 small-12 large-centered columns">
        <div class="panel">

            <div class="row">
                <div class="large-6 small-12 large-centered columns">

            <h2>Kirjaudu sisään</h2>

<?php
if (empty($error)) {
    $error = null;
}
if (! empty($error)) { ?>
    <div data-alert class="alert-box alert">
        <?php echo $error; ?>
    </div>
    <?php
}
?>

            <form id="loginform" method="post">
                <div class="row">
                    <div class="large-12 small-12">
                        <div class="row">
                            <div class="small-3 large-3 columns">
                                <label for="username"
                                    class="right">Tunnus</label>
                            </div>
                            <div class="small-9 large-9 columns">
                                <input
                                    required
                                    type="text"
                                    id="username"
                                    name="username"
                                    class="expand"
                                    value=""
                                >
                            </div>
                        </div>
                        <div class="row">
                            <div class="small-3 columns">
                                <label for="password"
                                    class="right">Salasana</label>
                            </div>
                            <div class="small-9 columns">
                                <input
                                    required
                                    type="password"
                                    id="password"
                                    name="password"
                                    placeholder=""
                                    class="expand"
                                    value=""
                                >
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="small-3 large-3 columns">&nbsp;</div>
                    <div class="small-9 large-9 columns">
                        <input type="submit" id="submit"
                            class="button expand" value="Kirjaudu"
                            name="submit">
                    </div>
                </div>
            </form>


                </div>
            </div>


        </div>
    </div>
</div>



