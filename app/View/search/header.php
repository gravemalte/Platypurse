<?php
use Hydro\Helper\CacheBuster;
?>

<!-- elements per page -->
<link rel="stylesheet" href="<?= CacheBuster::serve("css/search.css") ?>">
<script src="<?= CacheBuster::serve("js/multi-thumb-slider.js") ?>"></script>
<script src="<?= CacheBuster::serve("js/demand-more.js") ?>"></script>

</head>