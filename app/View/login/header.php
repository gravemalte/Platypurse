<?php
use Hydro\Helper\CacheBuster;
?>

    <!-- elements per page -->
    <link rel="stylesheet" href="<?= CacheBuster::serve("css/login.css") ?>">
    <script src="<?= CacheBuster::serve("js/toggle-password.js") ?>"></script>

</head>