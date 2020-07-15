<?php
use Hydro\Helper\CacheBuster;

if(isset($_GET['url'])){
    $slashPos = strpos($_GET['url'], '/', 1);
    if ($slashPos) {
        $isSubPage = true;
    }
}
?>


    <!-- elements per page -->
    <link rel="stylesheet" href="<?= CacheBuster::serve("css/login.css", $isSubPage) ?>">
    <script src="<?= CacheBuster::serve("js/toggle-password.js", $isSubPage) ?>"></script>

</head>