<?php
    $title = 'Account';
    $layout = '/shared/layout_secure.php';
?>

<p>Welcome !</p>

<?php

echo $this->viewData->getValidationMessage('username');
echo '<br>';
print_r($_SESSION, 0 );

?>
