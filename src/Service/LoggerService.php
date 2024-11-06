<?php

namespace Service;

class LoggerService
{
    public function error($error)
    {
        $date = new \DateTime();
        $file = './../Storage/Log/error.txt';
                    $date = $date->format('Y-m-d H:i:s');

                    foreach ($error as $key => $item) {
                        file_put_contents($file, "{$key}: {$item}\n", FILE_APPEND );
                    }
                    file_put_contents($file, "$date\n", FILE_APPEND );
    }

}