<?php

class Autoloader
{
    public function registrate(string $path): void
    {
        $autoloader = function (string $className, string $path) {
            $className = str_replace('\\', '/', $className);
            $path = "$path/$className.php";
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