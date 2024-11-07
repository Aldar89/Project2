<?php

namespace Service\Logger;
use Model\Model;

class LoggerDBService implements LoggerServiceInterface
{
    function error(string $message, array $context = []): void
    {
        $message = $context['message'];
        $file = $context['file'];
        $line = $context['line'];
        $date = new \DateTime();
        $date = $date->format('Y-m-d H:i:s');
        $stmt = Model::getPdo()->prepare("INSERT INTO `logs` (message, file, line, date) VALUES (:message, :file, :line, :date)");
        $stmt->execute(['message' => $message, 'file' => $file, 'line' => $line, 'date' => $date] );
    }

    public function info(string $message, array $context = [])
    {

    }

    public function warning(string $message, array $context = [])
    {

    }

}