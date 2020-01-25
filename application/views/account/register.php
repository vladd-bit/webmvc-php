<?php
    $layout = '/shared/layout.php';
    $title = 'Sign &nbsp; Up';
    $userAccountViewModel = new \Application\Models\ViewModels\UserAccountViewModel();
?>

<div class="account-creation-form mdc-elevation--z2">
    <div class="mdc-layout-grid">
        <h2>Create an account</h2>
        <form id="ww-user-sign-up-form" method="POST" class="" action="<?php echo WEBSITE_PATH; ?>/account/create">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="email" value="<?php echo htmlspecialchars($userAccountViewModel->getEmail(), ENT_QUOTES); ?>" required>
                            <label for="username" class="mdc-floating-label">Email</label>
                             <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('email') == 'error' ? 'text-error' : 'text-confirmation' ;  ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationMessage('email') ?>
                            </span>
                        </p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="username" value="<?php echo htmlspecialchars($userAccountViewModel->getUsername(), ENT_QUOTES) ?>" required>
                            <label for="username" class="mdc-floating-label">Username</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('username') == 'error' ? 'text-error' : 'text-confirmation' ;  ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationMessage('username')?>
                            </span>
                        </p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="password" value="<?php echo htmlspecialchars($userAccountViewModel->getPassword(), ENT_QUOTES) ?>" required>
                            <label for="username" class="mdc-floating-label">Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('password') == 'error' ? 'text-error' : 'text-confirmation' ; ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationMessage('password') ?>
                            </span>
                        </p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="confirmPassword" value="<?php echo htmlspecialchars($userAccountViewModel->getConfirmPassword(), ENT_QUOTES) ?>" required>
                            <label for="username" class="mdc-floating-label">Repeat Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('confirmPassword') == 'error' ? 'text-error' : 'text-confirmation' ; ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationMessage('confirmPassword') ?>
                            </span>
                        </p>
                    </div>

                    <?php
                        if(isset($this->viewData['accountExistsError']))
                            echo '<p class="text-error"> Cannot create account. The provided email or username is already registered</p>';
                    ?>

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
