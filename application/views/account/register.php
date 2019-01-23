<?php
    $layout = 'layout.php';
    $title = 'Sign &nbsp; Up';

    $userAccountViewModel = $this->viewData['userAccountViewModel'];
?>

<div class="account-creation-form mdc-elevation--z2">
    <div class="mdc-layout-grid">
        <h2>Create an account</h2>
        <form id="ww-user-sign-up-form" method="POST" class="" action="<?php echo WEBSITE_PATH; ?>/account/create">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="email" value="<?php echo $userAccountViewModel->getEmail(); ?>" required>
                            <label for="username" class="mdc-floating-label">Email</label>
                             <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent"><?php echo $userAccountViewModel->getValidationMessage('email') ?></p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="username" value="<?php echo $userAccountViewModel->getUsername() ?>" required>
                            <label for="username" class="mdc-floating-label">Username</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent"><?php echo $userAccountViewModel->getValidationMessage('username')?></p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="password" value="<?php echo $userAccountViewModel->getPassword() ?>" required>
                            <label for="username" class="mdc-floating-label">Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent"><?php echo $userAccountViewModel->getValidationMessage('password') ?></p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="confirmPassword" value="<?php echo $userAccountViewModel->getConfirmPassword() ?>" required>
                            <label for="username" class="mdc-floating-label">Repeat Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent"><?php echo $userAccountViewModel->getValidationMessage('confirmPassword') ?></p>
                    </div>
                </div>
            </div>
            <br>
            <br>
            <br>

            <button type="submit" class="mdc-button mdc-button--unelevated mdc-elevation--z1">
                Create Account
            </button>
        </form>
        <br>
    </div>
</div>

<?php
    print_r($userAccountViewModel,0);
?>
