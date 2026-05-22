<?php
declare(strict_types=1);
namespace Bank\Interfaces;

interface TransactionInterface
{
    public function getId(): string;
    public function getFromId(): string;
    public function getToId(): string;
    public function getAmount(): float;
    public function getCurrency(): string;
    public function getCreatedAt(): string;
    public function toArray(): array;
}