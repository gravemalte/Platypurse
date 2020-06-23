<?php

function getVersion() {
    if (!isset($_GET['module'])) return 0;
    $filepath = "./" . $_GET['module'];
    if (!file_exists($filepath)) return 0;
    return filemtime($filepath);
}

echo getVersion();