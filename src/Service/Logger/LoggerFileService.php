<?php

namespace Aldar\Project2\Service\Logger;
use Aldar\Project2\Service\Logger\LoggerServiceInterface;

class LoggerFileService implements LoggerServiceInterface
{

    public function error(string $message, array $context = []): void
    {
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');

        $erorrFile = './../Storage/Log/error.txt';

        foreach ($context as $key => $value) {

            file_put_contents($erorrFile, "$key: $value\n", FILE_APPEND);
        }

        file_put_contents( $erorrFile,    $date."\n", FILE_APPEND);


    }

    public function info(string $message, array $context = []): void
    {
        $erorrFile = './../Storage/Log/info.txt';
    }

    public function warning(string $message, array $context = []): void
    {
        $erorrFile = './../Storage/Log/warning.txt';
    }

}