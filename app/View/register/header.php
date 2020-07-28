<?php
use Hydro\Helper\CacheBuster;

$isSubPage = false;
if(isset($_GET['url'])){
    $slashPos = strpos($_GET['url'], '/', 1);
    if ($slashPos) {
        $isSubPage = true;
    }
}
?>

    <!-- elements per page -->
    <?= CacheBuster::embedCSSImports('css/register.css', $isSubPage) ?>
    <script src="<?= CacheBuster::serve("js/toggle-password.js", $isSubPage) ?>"></script>

</head>