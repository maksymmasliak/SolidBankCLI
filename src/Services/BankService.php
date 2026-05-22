<?php
declare(strict_types=1);

namespace Bank\Services;

use Bank\Interfaces\AccountRepositoryInterface;
use Bank\Interfaces\LoggerInterface;
use Bank\Exceptions\AccountNotFoundException;

class BankService
{
    public function __construct(
        private AccountRepositoryInterface $repository,
        private LoggerInterface $logger
    ) {}

    public function transfer(string $fromId, string $toId, float $amount): void
    {
        $fromAccount = $this->repository->findById($fromId);
        if ($fromAccount === null) {
            throw new AccountNotFoundException("Рахунок відправника з ID {$fromId} не знайдено");
        }

        $toAccount = $this->repository->findById($toId);
        if ($toAccount === null) {
            throw new AccountNotFoundException("Рахунок отримувача з ID {$toId} не знайдено");
        }

        $fromAccount->withdraw($amount);
        $toAccount->deposit($amount);

        $this->repository->save($fromAccount);
        $this->repository->save($toAccount);


        $this->logger->log("Успішний переказ: {$amount} з рахунку {$fromId} на рахунок {$toId}");
    }
}