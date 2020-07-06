<?php
use Hydro\Helper\CacheBuster;
?>

    <!-- elements per page -->
    <link rel="stylesheet" href="<?= CacheBuster::serve("css/create.css") ?>">
    <script src="<?= CacheBuster::serve("js/file-drop.js") ?>"></script>

</head>