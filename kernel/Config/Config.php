<?php

namespace App\Kernel\Config;

class Config implements ConfigInterface
{
    public function get(string $key, $default = null): mixed
    {
        [$file, $key] = explode('.', $key);

        if (! file_exists($path = APP_PATH."/config/$file.php")) {
            return $default;
        }

        $config = require $path;

        return $config[$key] ?? $default;
    }
}
