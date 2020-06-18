<?php
use Hydro\Helper\CacheBuster;
?>

    <!-- elements per page -->
    <link rel="stylesheet" href="<?= CacheBuster::serve("css/register.css") ?>">
    <script src="<?= CacheBuster::serve("js/togglePassword.js") ?>"></script>

</head>