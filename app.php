<?php
declare(strict_types=1);

use Bank\Services\BankService;
use Bank\Repositories\JsonAccountRepository;
use Bank\Models\SavingsAccount;
use Bank\Models\CreditAccount;

require_once __DIR__ . '/vendor/autoload.php';

$repository = new JsonAccountRepository(__DIR__ . '/data/database.json');
$bankService = new BankService($repository);

if (!isset($argv[1])) {
    echo "Помилка: введіть команду (наприклад, seed або transfer)\n";
    exit;
}

$command = $argv[1];

try {
    if ($command === 'seed') {
        $savingsAccount = new SavingsAccount('SAV-1', 1000.0, 0.05);
        $creditAccount = new CreditAccount('CRED-1', 0.0, 5000.0);

        $repository->save($savingsAccount);
        $repository->save($creditAccount);

        echo "Базу успішно наповнено!\n";
    } elseif ($command === 'transfer') {
        $fromId = $argv[2];
        $toId = $argv[3];
        $amount = (float) $argv[4];

        $bankService->transfer($fromId, $toId, $amount);

        echo "Переказ успішно виконано!\n";
    } else {
        echo "Помилка: невідома команда '{$command}'\n";
    }
} catch (\Exception $e) {
    echo "Помилка: " . $e->getMessage() . "\n";
}