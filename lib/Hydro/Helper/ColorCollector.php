<?php


namespace Hydro\Helper;


use Exception;

class ColorCollector {

    const CSS_PATH = ROOT
        . 'public'
        . DIRECTORY_SEPARATOR
        . 'css'
        . DIRECTORY_SEPARATOR;

    /**
     * Returns a colors.css with defined colors for each
     * preferred color scheme.
     *
     * @param $css_filepath
     * @param $defaultScheme
     * @return string
     * @throws Exception
     */
    public static function serveColorSchemes($css_filepath, $defaultScheme) {
        if ($defaultScheme !== "dark" && $defaultScheme !== "light") {
            throw new Exception("Default scheme must be 'dark' or 'light'");
        }

        $filepath = self::CSS_PATH . $css_filepath;
        if (!file_exists($filepath)) {
            return "css" . DIRECTORY_SEPARATOR . $css_filepath;
        }
        $file_content = file_get_contents($filepath);
        $file_content = preg_replace('/(\/\*.*\*\/)/', '', $file_content);
        $file_content = preg_replace('/[\n\s]+/', ' ', $file_content);

        $outputFile = dirname($filepath) . DIRECTORY_SEPARATOR . "colors.css";
        $publicOutputPath = "css". DIRECTORY_SEPARATOR . dirname($css_filepath) . DIRECTORY_SEPARATOR . "colors.css";

        if (file_exists($outputFile)) {
            if (filemtime($filepath) < filemtime($outputFile)) {
                return $publicOutputPath;
            }
        }

        $root_match = [];
        preg_match('/:root ({[^{}]*})/', $file_content, $root_match);
        $root = $root_match[1];

        $light_match = [];
        preg_match('/\.light ({[^{}]*})/', $file_content, $light_match);
        $light = $light_match[1];

        $dark_match = [];
        preg_match('/\.dark ({[^{}]*})/', $file_content, $dark_match);
        $dark = $dark_match[1];

        $output = "/* This file is generated. Do not edit! */\n";
        $output .= ":root " . $root . " ";
        if ($defaultScheme === "dark") {
            $output .= "body " . $light . " ";
            $output .= "body " . $dark . " ";
        }
        else {
            $output .= "body " . $dark . " ";
            $output .= "body " . $light . " ";
        }
        $output .= "body.light " . $light . " ";
        $output .= "body.dark " . $dark . " ";
        $output .= "@media (prefers-color-scheme: dark) { body " . $dark . " } ";
        $output .= "@media (prefers-color-scheme: light) { body " . $light . " } ";

        file_put_contents($outputFile, $output);

        return $publicOutputPath;
    }

}