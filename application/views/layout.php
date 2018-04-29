<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="refresh" content="60">
    <meta name="description" content="The WebWay">
    <meta name="keywords" content="VOID,WW">
    <meta name="author" content="az">

    <title>
        <?php
           echo htmlspecialchars($title);
        ?>
    </title>

    <link rel="stylesheet" type="text/css" href="media/stylesheets/css/google-fonts.css">
    <link rel="stylesheet" type="text/css" href="media/stylesheets/css/material-components-web/material-components-web.min.css">
    <link rel="icon" href="media/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="media/stylesheets/css/layouts/general-layout.css">
</head>
<body class="mdc-typography">

<?php
    include_once('header.php');
?>

<main class="">
    {renderBody}
</main>

<?php
    include_once('footer.php');
?>

<script type="text/javascript" src="js/libraries/material-components-web/material-components-web.min.js"></script>
<script type="text/javascript" src="js/libraries/material-components-web/mdc.autoInit.min.js"></script>
<script type="text/javascript" async defer>
    window.mdc.autoInit();
</script>
</body>
</html>