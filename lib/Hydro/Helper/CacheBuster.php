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
}