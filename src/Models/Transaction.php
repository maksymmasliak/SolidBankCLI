<?php
declare(strict_types=1);
namespace Bank\Models;

use Bank\Interfaces\TransactionInterface;

class Transaction implements TransactionInterface
{
    private string $createdAt;

    public function __construct(
        private readonly string $id,
        private readonly string $fromId,
        private readonly string $toId,
        private readonly float  $amount,
        private readonly string $currency = 'UAH'
    ) {
        $this->createdAt = date('Y-m-d H:i:s');
    }

    public function getId(): string        { return $this->id; }
    public function getFromId(): string    { return $this->fromId; }
    public function getToId(): string      { return $this->toId; }
    public function getAmount(): float     { return $this->amount; }
    public function getCurrency(): string  { return $this->currency; }
    public function getCreatedAt(): string { return $this->createdAt; }

    public function toArray(): array
    {
        return [
            'id'        => $this->id,
            'fromId'    => $this->fromId,
            'toId'      => $this->toId,
            'amount'    => $this->amount,
            'currency'  => $this->currency,
            'createdAt' => $this->createdAt,
        ];
    }
}