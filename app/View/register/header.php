<?php
use Hydro\Helper\CacheBuster;
?>

    <!-- elements per page -->
    <?= CacheBuster::embedCSSImports('css/register.css') ?>
    <script src="<?= CacheBuster::serve("js/toggle-password.js") ?>"></script>

</head>