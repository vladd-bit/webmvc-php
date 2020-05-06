<?php
    $layout = '/shared/layout.php';
    $title = 'Sign &nbsp; Up';

    /* @var $userAccountViewModel Application\Models\ViewModels\UserAccountViewModel */
    $userAccountViewModel = $this->viewData['userAccountViewModel'];

?>

<div class="account-creation-form mdc-elevation--z2">
    <div class="mdc-layout-grid">
        <h2>Create an account</h2>
        <form id="ww-user-sign-up-form" method="POST" class="" action="<?php echo WEBSITE_PATH."/account/create";?>">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="email" aria-label="email" value="<?php echo htmlspecialchars($userAccountViewModel->email, ENT_QUOTES); ?>" required>
                            <label for="username" class="mdc-floating-label">Email</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('email')->status == 'error' ? 'text-error' : 'text-confirmation' ; ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationStatus('email')->validationMessage ?>
                            </span>
                        </p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="username" aria-label="username" value="<?php echo htmlspecialchars($userAccountViewModel->username, ENT_QUOTES) ?>" required>
                            <label for="username" class="mdc-floating-label">Username</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('username')->status == 'error' ? 'text-error' : 'text-confirmation' ; ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationStatus('username')->validationMessage ?>
                            </span>
                        </p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="password" value="<?php echo htmlspecialchars($userAccountViewModel->password, ENT_QUOTES) ?>" required>
                            <label for="username" class="mdc-floating-label">Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('password')->status == 'error' ? 'text-error' : 'text-confirmation' ; ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationStatus('password')->validationMessage ?>
                            </span>
                        </p>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="password" name="confirmPassword" value="<?php echo htmlspecialchars($userAccountViewModel->confirmPassword, ENT_QUOTES) ?>" required>
                            <label for="username" class="mdc-floating-label">Repeat Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                        <br>
                        <p class="mdc-text-field-helper-text mdc-text-field-helper-text--validation-msg mdc-text-field-helper-text--persistent">
                            <span class="<?php echo $userAccountViewModel->getFieldValidationStatus('confirmPassword')->status == 'error' ? 'text-error' : 'text-confirmation' ; ?>" >
                                <?php echo $userAccountViewModel->getFieldValidationStatus('confirmPassword')->validationMessage ?>
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
