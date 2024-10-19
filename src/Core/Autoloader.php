<?php

namespace Core;

class Autoloader
{
    public function registrate()
    {
        $autoloader = function (string $className) {
            $path = str_replace('\\', '/', $className);
            $path = './../' . $path . '.php';
            if (file_exists($path)) {
                require_once $path;
                return true;
            } else {
                return false;
            }
        };
        spl_autoload_register($autoloader);
    }
}