<?php
    $title = 'Account';
    $layout = '/shared/layout_secure.php';
    /* @var $viewData \Application\Models\ViewModels\UserAccountDashboardViewModel */
    $viewData = $this->viewData;
?>

<p>Welcome !</p>

<?php

#echo $this->viewData;

echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';echo '<br>';
echo '<br>';
echo $viewData->getUsername();

echo '<br>';echo '<br>';echo '<br>';



print_r($_SESSION, 0 );

?>
