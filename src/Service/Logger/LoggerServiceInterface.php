<?php

namespace Aldar\Project2\Service\Logger;

interface LoggerServiceInterface
{
    public function error(string $message, array $context = []);
    public function info( string $message, array $context = []);
    public function warning(string $message, array $context = []);
}