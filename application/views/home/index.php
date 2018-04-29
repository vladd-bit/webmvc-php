<?php
    $layout = 'layout.php';
    $title = 'Home';
?>

<form id="ww-user-login-form" class="mdc-layout-grid__inner" action="home/submit">
    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
    </div>
    <div class="mdc-text-field mdc-text-field--upgraded">
        <input class="" type="text" name="username" value="">
        <label class="" for="username">Username</label>
        <input class="" type="password" name="password" value="">
        <label class="" for="password">Password</label>
        <div class="mdc-line-ripple" style="transform-origin: 42.7667px center 0px;"></div>
        <button type="submit" class="">
            Login
        </button>
    </div>
    <div class="mdc-layout-grid__cell mdc-layout-grid__cell--span-4">
    </div>
</form>

