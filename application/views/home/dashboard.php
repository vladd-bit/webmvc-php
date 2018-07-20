<?php
    $title = 'Account';
    $layout = '/shared/layout_secure.php';
?>

<p>Welcome !</p>
<?php

echo $this->viewData['username'];
echo '<br>';
print_r($_SESSION, 0 );

?>