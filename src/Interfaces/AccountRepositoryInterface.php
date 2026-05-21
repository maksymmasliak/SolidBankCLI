<?php
declare(strict_types=1);

namespace Bank\Interfaces;
use Bank\Models\Account;

interface AccountRepositoryInterface {
    public function save(Account $account): void;
    public function findById(string $id): ?Account;
    public function findAll(): array;
}