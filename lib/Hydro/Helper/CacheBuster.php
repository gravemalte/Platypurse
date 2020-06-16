<?php


namespace Hydro\Helper;


class CacheBuster {

    const LOCAL_PUBLIC_PATH = ROOT . 'public' . DIRECTORY_SEPARATOR;

    /**
     * Appends a query string to a file path.
     * This will allow browsers to recognize changes.
     *
     * @param $public_filepath
     * @return string
     */
    public static function serve($public_filepath) {
        $filepath = self::LOCAL_PUBLIC_PATH . $public_filepath;
        if (file_exists($filepath)) {
            return $public_filepath . "?t=" . filemtime($filepath);
        }
        return $public_filepath;
    }

    /**
     * Checks a css file for it's import statements.
     * Will return a style block if possible.
     * All imports will be cache busted if possible.
     * Every output is as best cache busted as possible.
     *
     * @param $public_filepath
     * @return string
     */
    public static function embedCSSImports($public_filepath) {
        $filepath = self::LOCAL_PUBLIC_PATH . $public_filepath;
        if (file_exists($filepath)) {
            $fileContent = file_get_contents($filepath);
            $relPublicPos = substr($public_filepath, 0, strrpos($public_filepath, "/") + 1);
            $matches = [];
            if (preg_match_all('/[^\s"\']+\.css/', $fileContent, $matches)) {
                $output = "<style>\n";
                foreach ($matches[0] as $match) {
                    $output .= '@import "';
                    $output .= self::serve($relPublicPos . $match);
                    $output .= "\";\n";
                }
                $output .= "</style>";
                return $output;
            }
        }
        return '<link rel="stylesheet" href="' . self::serve($public_filepath) . '">';
    }
}