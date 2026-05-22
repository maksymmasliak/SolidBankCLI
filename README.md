# SolidBank CLI

A command-line banking system built in PHP without frameworks. Manages different account types, handles fund transfers, and ensures architectural flexibility through strict adherence to SOLID principles and JSON persistence.

## Features
- Manage **Savings** and **Credit** accounts with specific business rules (interest rates, credit limits)
- Transfer funds between accounts securely
- Built-in transaction model for standardizing transfer data
- File-based logging of all successful operations
- JSON file persistence — no database required

## Tech Stack
- PHP 8.1+
- Composer (PSR-4 autoloading)

## Architecture
| Layer | Classes |
|---|---|
| Models | `Account` (abstract), `SavingsAccount`, `CreditAccount`, `Transaction` |
| Interfaces | `AccountRepositoryInterface`, `TransactionInterface`, `LoggerInterface` |
| Repositories | `JsonAccountRepository` |
| Services | `BankService` |
| Loggers | `FileLogger` |
| Exceptions | `AccountNotFoundException`, `InsufficientFundsException` |

## Project Structure
```text
├── app.php
├── composer.json
├── data/
│   ├── database.json
│   └── transactions.log
└── src/
    ├── Exceptions/
    │   ├── AccountNotFoundException.php
    │   └── InsufficientFundsException.php
    ├── Interfaces/
    │   ├── AccountRepositoryInterface.php
    │   ├── TransactionInterface.php
    │   └── LoggerInterface.php
    ├── Loggers/
    │   └── FileLogger.php
    ├── Models/
    │   ├── Account.php
    │   ├── SavingsAccount.php
    │   ├── CreditAccount.php
    │   └── Transaction.php
    ├── Repositories/
    │   └── JsonAccountRepository.php
    └── Services/
        └── BankService.php
 ````
## Installation

```bash
git clone https://github.com/maksymmasliak/SolidBankCLI.git
cd SolidBankCLI
composer install
mkdir -p data
```

## Usage

**Seed the database with initial accounts:**

```bash
php app.php seed
```

Creates a Savings account `SAV-1` and a Credit account `CRED-1`.

**Transfer funds between accounts:**

```bash
php app.php transfer SAV-1 CRED-1 200
```

Transfers 200 from `SAV-1` to `CRED-1`. The operation is logged and
the JSON database is updated.

## Design Principles

SOLID is applied throughout the core architecture:

- **S** — each class has a single responsibility: `BankService` handles
  business logic, `JsonAccountRepository` handles persistence,
  `FileLogger` handles logging
- **O** — new account types can extend `Account` without modifying the
  core domain logic
- **L** — all account subclasses are substitutable for `Account` without
  breaking behaviour in the Repository or Service
- **I** — interfaces are small and focused (`AccountRepositoryInterface`,
  `LoggerInterface`); classes only implement what they need
- **D** — `BankService` depends on abstractions
  (`AccountRepositoryInterface` and `LoggerInterface`), not on concrete
  implementations, making it ready for SQL integration

## Data Storage

All data is stored locally in the `data/` directory:

| File | Contents |
|---|---|
| `database.json` | Account state (id, balance, currency, type-specific fields) |
| `transactions.log` | Timestamped log of every successful operation |