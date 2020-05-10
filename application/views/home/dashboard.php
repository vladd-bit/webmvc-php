<?php
    $title = 'Account';
    $layout = '/shared/layout_secure.php';
    /* @var $viewData \Application\Models\ViewModels\UserAccountDashboardViewModel */
    $userAccountDashboardViewModel = $this->viewData['userAccountDashboardViewModel'];
?>

<p>Welcome !</p>

<?php

print_r($_SESSION, 0 );

?>
