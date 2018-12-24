<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="3600">
    <meta name="description" content="The WebWay">
    <meta name="keywords" content="VOID,WW">
    <meta name="author" content="az">

    <title>
        <?php
           echo $title;
        ?>
    </title>

    <link rel="icon" href="<?php echo PUBLIC_FOLDER_URL; ?>/media/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_FOLDER_URL; ?>/media/stylesheets/css/google-fonts.css">
    <link rel="stylesheet" type="text/css" href="<?php echo PUBLIC_FOLDER_URL; ?>/media/stylesheets/css/layouts/general-layout.css">
</head>
<body class="mdc-typography">

    <?php
        include_once('header.php');
    ?>

    <main class="mdc-layout-grid">
            {renderBody}
    </main>

    <?php
        include_once('footer.php');
    ?>

    <script type="text/javascript" src="<?php echo PUBLIC_FOLDER_URL; ?>/js/libraries/material-components-web/material-components-web.min.js"></script>
    <script type="text/javascript">
        mdc.autoInit();
    </script>
</body>
</html>