<?php
    $layout = 'shared/layout.php';
    $title = 'WebWay';
    
    /* @var $userAccountLoginViewModel \Application\Models\ViewModels\Home\UserAccountLoginViewModel */
    $userAccountLoginViewModel = $this->viewData['userAccountLoginViewModel'];
?>

<div class="login-form mdc-elevation--z2">
    <div class="mdc-layout-grid">
        <form id="ww-user-login-form" method="POST" class="" name="user-login-form" action="<?php echo WEBSITE_PATH."/home/login"; ?>">
            <div class="mdc-layout-grid__inner">
                <div class="mdc-layout-grid__cell--span-12">
                    <div class="mdc-typography--headline4">Sign in</div>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input" type="text" name="username" value="<?php echo htmlspecialchars($userAccountLoginViewModel->username, ENT_QUOTES) ?>" required>
                            <label for="username" class="mdc-floating-label">Username</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <div class="text-field-container">
                        <div class="mdc-text-field text-field mdc-ripple-upgraded full-width" data-mdc-auto-init="MDCTextField">
                            <input class="mdc-text-field__input"  type="password" name="password" value="<?php echo htmlspecialchars($userAccountLoginViewModel->password, ENT_QUOTES) ?>"  aria-label="Password" required>
                            <label for="password" class="mdc-floating-label">Password</label>
                            <div class="mdc-line-ripple"></div>
                        </div>
                    </div>
                    <br>
                    <br>
                    <br>
                    <button type="submit" class="mdc-button mdc-button--unelevated mdc-elevation--z1">
                        Login
                    </button>
                </div>
            </div>
        </form>
        <br>
        <?php
            if($this->viewData['error'])
            {
                echo '<p class="mdc-typography--body2 subtitle1 full-width text-error"><i class="material-icons">error</i> Incorrect account details, please try again.</p>';
            }
        ?>
        <br>
        <a href="<?php echo WEBSITE_PATH."/account/register"; ?>" class="mdc-button mdc-typography--body1">
            <span>Don't have an account ? Sign up !</span>
        </a>
    </div>
</div>
