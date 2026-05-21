<?php
declare(strict_types=1);

namespace Bank\Models;

use Bank\Exceptions\InsufficientFundsException;

class SavingsAccount extends Account
{
    public function __construct(string $id, float $balance, protected float $interestRate, string $currency = 'UAH')
    {
        parent::__construct($id, $balance, $currency);
    }

    public function withdraw(float $amount): void{
        if ($amount <= 0) {
            throw new \InvalidArgumentException("Amount must be greater than 0");
        }
        if ($amount > $this->balance) {
            throw new InsufficientFundsException("Недостатньо коштів на ощадному рахунку");
        }
        $this->balance -= $amount;
    }
}