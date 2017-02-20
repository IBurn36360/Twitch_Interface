<?php

date_default_timezone_set('UTC');

final class NSAutoLoader {
    public static function loadFile($namespace) {
        $namespace = preg_replace('~^\\\\?IBurn36360\\\\TwitchInterface\\\\~', '', $namespace);

        if (file_exists($filePath = (realpath(__DIR__ . '/../src') . "/$namespace.php"))) {
            require_once($filePath);
        }
    }
}

spl_autoload_register(array('NSAutoLoader', 'loadFile'));
