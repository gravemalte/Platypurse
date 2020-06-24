<?php
use Hydro\Helper\CacheBuster;
?>

    <!-- elements per page -->
    <link rel="stylesheet" href="<?= CacheBuster::serve("css/chat.css") ?>">
    <script src="<?= CacheBuster::serve("js/chat.js") ?>"></script>

</head>