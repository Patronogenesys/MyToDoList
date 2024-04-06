<?php

namespace App\Kernel\Config;

interface ConfigInterface
{
    // $config->get('filename.prameter');
    public function get(string $key, $default = null): mixed;
}
