<?php
declare(strict_types=1);
namespace Bank\Models;

use Bank\Exceptions\InsufficientFundsException;

abstract class Account{
    public function __construct(
        protected string $id,
        protected float $balance,
        protected string $currency = 'UAH'
    ){}
    public function getId(): string{
        return $this->id;
    }
    public function getBalance(): float{
        return $this->balance;
    }
    public function getCurrency(): string{
        return $this->currency;
    }
    public function deposit(float $amount): void{
        if ($amount <= 0){
            throw new \InvalidArgumentException("Сума поповнення має бути більшою за нуль");
        }

        $this->balance += $amount;
    }
}