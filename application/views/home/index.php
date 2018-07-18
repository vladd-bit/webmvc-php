<?php
    $layout = 'layout.php';
    $title = 'WebWay';
?>

<div class="login-form mdc-elevation--z2">
    <form id="ww-user-login-form" method="POST" class="" action="<?php echo WEBSITE_PATH; ?>/home/login">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-typography--headline4">Sign in</div>
                    <br>

                    <div class="mdc-text-field mdc-text-field--upgraded full-width" data-mdc-auto-init="MDCTextField">
                        <input class="mdc-text-field__input" id="" type="text" name="username" value="" required>
                        <label for="username" class="mdc-floating-label">Username</label>
                    </div>

                    <br>
                    <br>

                    <div class="mdc-text-field mdc-text-field--upgraded full-width" data-mdc-auto-init="MDCTextField">
                        <input class="mdc-text-field__input" id="" type="text" name="password" value=""  aria-label="Password" required>
                        <label for="password" class="mdc-floating-label">Password</label>
                    </div>

                    <br>
                    <br>
                    <br>
                    <button type="submit" class="mdc-button mdc-button--unelevated mdc-elevation--z1">
                        Login
                    </button>

                </div>
            </div>
        </div>
    </form>
</div>
