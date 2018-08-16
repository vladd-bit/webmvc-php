<header class="mdc-toolbar mdc-toolbar--fixed mdc-toolbar--platform mdc-theme--background">
    <div class="mdc-top-app-bar__row">
        <section class="mdc-toolbar__section mdc-toolbar__section--align-start">
            <img class="mdc-toolbar__title mdc-toolbar__title--full brand-small-logo" src="<?php echo PUBLIC_FOLDER_URL; ?>/media/images/WebWayLogo.png" alt="WebWay">
            <span class="mdc-toolbar__title mdc-toolbar__title--full">WebWay</span>
        </section>
        <section class="mdc-toolbar__section mdc-toolbar__section--align-end">
            <nav class="">
                <span><?php echo $_SESSION['identityUsername'] ?></span>
                <a href="#" class="" aria-label="" ><span class="">Item 1</span></a>
                <a href="#" class="" aria-label="" >Item 2</a>
                <a href="#" class="" aria-label="" >Item 3</a>
            </nav>
        </section>
    </div>
</header>
