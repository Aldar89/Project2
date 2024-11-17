<?php

namespace Service\Logger;
use Model\Logger;

class LoggerDBService implements LoggerServiceInterface
{
    function error(string $message, array $context = []): void
    {
        $message = $context['message'];
        $file = $context['file'];
        $line = $context['line'];
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        Logger::create($message, $file, $line, $date);
    }

    public function info(string $message, array $context = [])
    {

    }

    public function warning(string $message, array $context = [])
    {

    }

}