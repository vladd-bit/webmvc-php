<?php
    $layout = 'layout.php';
    $title = 'Sign &nbsp; Up';

    $userAccountViewModel = (object) ($this->viewData['userAccountViewModel']);


?>

<div class="account-creation-form mdc-elevation--z2">
    <div class="mdc-layout-grid">
        <form id="ww-user-sign-up-form" method="POST" class="" action="<?php echo WEBSITE_PATH; ?>/account/create">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-6">
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="email" value="<?php echo $userAccountViewModel->getEmail(); ?>" required>
                            <label for="username" class="mdc-floating-label">Email</label>
                             <div class="mdc-line-ripple"></div>
                        </div>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent"><?php echo $userAccountViewModel->getValidationMessage('email') ?></p>
                    </div>

                    <br>

                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="password" value="<?php echo $userAccountViewModel->getPassword() ?>" required>
                            <label for="username" class="mdc-floating-label">Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent"><?php echo $userAccountViewModel->getValidationMessage('password') ?></p>
                    </div>
                </div>
                <div class="mdc-layout-grid__cell--span-6">
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="username" value="<?php echo $userAccountViewModel->getUsername() ?>" required>
                            <label for="username" class="mdc-floating-label">Username</label>
                            <div class="mdc-line-ripple"></div>
                       </div>
                       <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent"><?php echo $userAccountViewModel->getValidationMessage('username')?></p>
                    </div>

                    <br>

                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="confirmPassword" value="<?php echo $userAccountViewModel->getConfirmPassword() ?>" required>
                            <label for="username" class="mdc-floating-label">Repeat Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
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

<div class="mdc-text-field mdc-ripple-upgraded" style="--mdc-ripple-fg-size:133px; --mdc-ripple-fg-scale:1.8039391011582069; --mdc-ripple-fg-translate-start:64.5px, -29.933349609375px; --mdc-ripple-fg-translate-end:45px, -38.5px;">
    <input type="text" class="mdc-text-field__input" id="full-func-text-field" aria-controls="my-text-field-helper-text" aria-describedby="my-text-field-helper-text">
    <label for="full-func-text-field" class="mdc-floating-label mdc-floating-label--float-above">Email Address</label>
    <div class="mdc-line-ripple" style="transform-origin: 131px center 0px;"></div>
</div>
<p id="my-text-field-helper-text" class="mdc-text-field-helper-text" style="visibility: hidden" aria-hidden="true">Helper Text</p>