<?php
declare(strict_types=1);

namespace Bank\Repositories;

use Bank\Models\Account;
use Bank\Interfaces\AccountRepositoryInterface;

class JsonAccountRepository implements AccountRepositoryInterface{
    public function __construct(private string $filePath) {}
    private function loadData(): array{
        if (!file_exists($this->filePath)) {
            return [];
        }
        $json = file_get_contents($this->filePath);
        return json_decode($json, true) ?? [];
    }
    private function saveData(array $data): void{
        file_put_contents($this->filePath, json_encode($data, JSON_PRETTY_PRINT));
    }
    private function hydrateAccount(array $data): Account {
        if ($data['type'] === 'savings') {
            return new \Bank\Models\SavingsAccount(
                $data['id'],
                $data['balance'],
                $data['interestRate'],
                $data['currency']
            );
        } elseif ($data['type'] === 'credit') {
            return new \Bank\Models\CreditAccount(
                $data['id'],
                $data['balance'],
                $data['creditLimit'],
                $data['currency']
            );
        }

        // Захист від пошкоджених даних у файлі
        throw new \InvalidArgumentException("Невідомий тип рахунку: " . $data['type']);
    }
    public function save(Account $account): void {

        $accounts = $this->loadData();


        $accountData = [
            'id' => $account->getId(),
            'balance' => $account->getBalance(),
            'currency' => $account->getCurrency(),
        ];

        if ($account instanceof \Bank\Models\SavingsAccount) {
            $accountData['type'] = 'savings';
            $accountData['interestRate'] = $account->getInterestRate();
        } elseif ($account instanceof \Bank\Models\CreditAccount) {
            $accountData['type'] = 'credit';
            $accountData['creditLimit'] = $account->getCreditLimit();
        }
        $accounts[$account->getId()] = $accountData;

        $this->saveData($accounts);
    }
    public function findById(string $id): ?Account {
        $accounts = $this->loadData();

        if (!isset($accounts[$id])) {
            return null;
        }

        // Перетворюємо масив на об'єкт і повертаємо його
        return $this->hydrateAccount($accounts[$id]);
    }
    public function findAll(): array {
        $accounts = $this->loadData();
        $objects = [];

        foreach ($accounts as $accountData) {
            $objects[] = $this->hydrateAccount($accountData);
        }

        return $objects;
    }
}