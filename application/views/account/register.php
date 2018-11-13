<?php
    $layout = 'layout.php';
    $title = 'Sign Up';

    $userAccountViewModel = new \Application\Models\ViewModels\Home\UserAccountViewModel();
?>

<div class="account-creation-form mdc-elevation--z2">
    <div class="mdc-layout-grid">
        <form id="ww-user-sign-up-form" method="POST" class="" action="<?php echo WEBSITE_PATH; ?>/account/create">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-6">
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="email" value="" required>
                            <label for="username" class="mdc-floating-label">Email</label>
                            <p><?php $userAccountViewModel->validationStatus['email']?></p>
                            <div class="mdc-line-ripple"></div>
                        </div>
                    </div>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="password" value="" required>
                            <label for="username" class="mdc-floating-label">Password</label>
                            <div class="mdc-line-ripple"></div>
                            <p><?php $userAccountViewModel->validationStatus['password']?></p>
                        </div>
                    </div>
                </div>
                <div class="mdc-layout-grid__cell--span-6">
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="username" value="" required>
                            <label for="username" class="mdc-floating-label">Username</label>
                            <div class="mdc-line-ripple"></div>
                            <p><?php $userAccountViewModel->validationStatus['username']?></p>
                        </div>
                    </div>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="Repeat Password" value="" required>
                            <label for="username" class="mdc-floating-label">Repeat Password</label>
                            <div class="mdc-line-ripple"></div>
                            <p><?php $userAccountViewModel->validationStatus['passwordRepeat']?></p>
                        </div>
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
