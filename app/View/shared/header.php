<?php
use Hydro\Helper\CacheBuster;
use Hydro\Helper\ColorCollector;

$isSubPage = false;
if(isset($_GET['url'])){
    $slashPos = strpos($_GET['url'], '/', 1);
    if ($slashPos) {
        $isSubPage = true;
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Platypurse</title>
    <meta name="description" content="Schnabeltierbörse für Schnabeltiere, oder so">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="keywords" content="platypus, trade, börse, uol">
    <meta name="author" content="Malte Grave, Tim Hesse, Marvin Kuhlmann">

    <!-- Favicon -->
    <link
            rel="apple-touch-icon"
            sizes="57x57"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-57x57.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="60x60"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-60x60.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="72x72"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-72x72.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="76x76"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-76x76.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="114x114"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-114x114.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="120x120"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-120x120.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="144x144"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-144x144.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="152x152"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-152x152.png", $isSubPage) ?>\"
    >
    <link
            rel="apple-touch-icon"
            sizes="180x180"
            href="<?= CacheBuster::serve("assets/favicon/apple-icon-180x180.png", $isSubPage) ?>\"
    >
    <link
            rel="icon"
            type="image/png"
            sizes="192x192"
            href="<?= CacheBuster::serve("assets/favicon/android-icon-192x192.png", $isSubPage) ?>\"
    >
    <link
            rel="icon"
            type="image/png"
            sizes="32x32"
            href="<?= CacheBuster::serve("assets/favicon/favicon-32x32.png", $isSubPage) ?>\"
    >
    <link
            rel="icon"
            type="image/png"
            sizes="96x96"
            href="<?= CacheBuster::serve("assets/favicon/favicon-96x96.png", $isSubPage) ?>\"
    >
    <link
            rel="icon"
            type="image/png"
            sizes="16x16"
            href="<?= CacheBuster::serve("assets/favicon/favicon-16x16.png", $isSubPage) ?>\"
    >
    <link
            rel="manifest"
            href="<?= CacheBuster::serve("assets/favicon/manifest.json", $isSubPage) ?>\"
    >
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta
            name="msapplication-TileImage"
            content="<?= CacheBuster::serve("assets/favicon/ms-icon-144x144.png", $isSubPage) ?>\"
    >
    <meta name="theme-color" content="#ffffff">
    <!-- used https://www.favicon-generator.org/ for that -->

    <!-- CSS linking here -->
    <link
            rel="stylesheet"
            href="<?=
                CacheBuster::serve(
                        ColorCollector::serveColorSchemes("shared/raw-colors.css", "dark")
                , $isSubPage)
            ?>">
    <?= CacheBuster::embedCSSImports('css/shared.css', $isSubPage) ?>

    <!-- Link JS in the footer template-->
    <script src="<?= CacheBuster::serve('js/color-mode-switch.js', $isSubPage) ?>"></script>
    <script src="<?= CacheBuster::serve("js/enable-js-only-features.js", $isSubPage) ?>"></script>
    <script src="<?= CacheBuster::serve('js/date-operations.js', $isSubPage) ?>"></script>
    <script src="<?= CacheBuster::serve("js/confirm-changes.js", $isSubPage) ?>"></script>

    <!-- Font Awesome -->
    <script src="<?= CacheBuster::serve('js/font-awesome.js', $isSubPage) ?>"></script>
