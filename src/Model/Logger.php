<?php

namespace Model;

use Core\Model;

class Logger extends Model
{
    public static function create(string $message, string $file, string $line, $date)
    {
        $stmt = Model::getPdo()->prepare("INSERT INTO `logs` (message, file, line, date) VALUES (:message, :file, :line, :date)");
        $stmt->execute(['message' => $message, 'file' => $file, 'line' => $line, 'date' => $date] );
    }

}