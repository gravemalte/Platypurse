<?php
use Hydro\Helper\CacheBuster;
?>

<!-- elements per page -->
<link rel="stylesheet" href="<?= CacheBuster::serve("css/profile.css") ?>">
<script type="text/javascript" src="<?= CacheBuster::serve("js/rate-user.js") ?>"></script>

</head>