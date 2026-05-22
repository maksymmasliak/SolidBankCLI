<?php
declare(strict_types=1);

namespace Bank\Loggers;
use Bank\Interfaces\LoggerInterface;

class FileLogger implements LoggerInterface
{
    public function __construct(private string $filePath) {}

    public function log(string $message): void
    {
        $date = date('Y-m-d H:i:s');

        $logEntry = "[{$date}] {$message}\n";

        file_put_contents($this->filePath, $logEntry, FILE_APPEND);
    }
}