<?php

declare(strict_types=1);

class BankAccount
{
    private null|int $balance = null;

    public function open()
    {
        if ($this->balance !== null) {
            throw new InvalidArgumentException("account already open");
        }
        $this->balance = 0;
    }

    public function close()
    {
        $this->checkOpen();
        $this->balance = null;
    }

    public function balance(): int
    {
        $this->checkOpen();
        return $this->balance;
    }

    public function deposit(int $amt)
    {
        $this->checkOpen();
        if ($amt <= 0) {
            throw new InvalidArgumentException("amount must be greater than 0");
        }
        $this->balance += $amt;
    }

    public function withdraw(int $amt)
    {
        $this->checkOpen();
        if ($amt <= 0) {
            throw new InvalidArgumentException("amount must be greater than 0");
        }
        if ($this->balance - $amt < 0) {
            throw new InvalidArgumentException("amount must be less than balance");
        }
        $this->balance -= $amt;
    }

    private function checkOpen(): void
    {
        if ($this->balance === null) {
            throw new InvalidArgumentException('account not open');
        }
    }
}
