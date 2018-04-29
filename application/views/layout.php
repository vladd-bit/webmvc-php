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

    <link rel="stylesheet" type="text/css" href="media/stylesheets/css/google_mdl/material.css">
    <link rel="icon" href="media/images/favicon.ico">
    <link rel="stylesheet" type="text/css" href="media/stylesheets/css/layouts/general-layout.css">
</head>
<body class="mdl-layout mdl-js-layout mdl-layout--fixed-header">

<?php
    include_once('header.php');
?>

<main class="mdl-layout__content">
    {renderBody}
</main>

<?php
    include_once('footer.php');
?>

</body>
</html>