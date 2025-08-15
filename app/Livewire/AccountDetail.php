<?php

namespace App\Livewire;

use App\Models\Account;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\View\View as ViewAlias;
use Livewire\Component;

class AccountDetail extends Component
{
    public $account;

    public $amount;

    public $targetIban;

    public function mount(Account $account): void
    {
        $this->account = $account;
    }

    public function deposit(): void
    {
        $this->account->balance += $this->amount;
        $this->account->save();
        session()?->flash('message', 'Depósito realizado!');
        $this->amount = null;
    }

    public function withdraw(): void
    {
        if ($this->amount > $this->account->balance) {
            session()?->flash('error', 'Saldo insuficiente!');

            return;
        }
        $this->account->balance -= $this->amount;
        $this->account->save();
        session()?->flash('message', 'Saque realizado!');
        $this->amount = null;
    }

    public function transfer(): void
    {
        $targetAccount = Account::query()
            ->where('iban', $this->targetIban)->first();

        if (! $targetAccount) {
            session()?->flash('error', 'Conta destino não encontrada!');

            return;
        }

        if ($this->amount > $this->account->balance) {
            session()?->flash('error', 'Saldo insuficiente!');

            return;
        }

        $this->account->balance -= $this->amount;
        $targetAccount->balance += $this->amount;

        $this->account->save();
        $targetAccount->save();

        session()?->flash('message', 'Transferência realizada!');
        $this->amount = null;
        $this->targetIban = null;
    }

    public function render(): View|Application|Factory|ViewAlias
    {
        return view('livewire.account-detail')
            ->layout('components.layouts.app', ['title' => __('Account')]);
    }
}
