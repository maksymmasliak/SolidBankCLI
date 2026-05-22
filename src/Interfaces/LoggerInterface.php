<?php
declare(strict_types=1);

namespace Bank\Interfaces;

interface LoggerInterface
{
    public function log(string $message): void;
}