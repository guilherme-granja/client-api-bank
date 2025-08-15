<?php

namespace App\Livewire;

use App\Models\Account;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\View\View as ViewAlias;
use Livewire\Component;

class AccountsDashboard extends Component
{
    /** @var \Illuminate\Support\Collection<int, Account> */
    public $accounts;

    public bool $showCreateModal = false;

    /** @var array{iban: string|null, balance: float|int|null} */
    public array $form = [
        'iban' => null,
        'balance' => null,
    ];

    public function mount(): void
    {
        $this->reloadAccounts();
    }

    protected function rules(): array
    {
        return [
            'form.iban' => ['nullable', 'string', 'max:255', Rule::unique('accounts', 'iban')],
            'form.balance' => ['nullable', 'numeric', 'min:0'],
        ];
    }

    public function openCreate(): void
    {
        $this->resetValidation();
        $this->form = [
            'iban' => (string) Str::uuid(),
            'balance' => 0,
        ];
        $this->showCreateModal = true;
    }

    public function create(): void
    {
        $this->validate();

        /** @var \App\Models\User $user */
        $user = Auth::user();

        $iban = $this->form['iban'] ?: (string) Str::uuid();
        $balance = (float) ($this->form['balance'] ?? 0);

        $account = new Account([
            'iban' => $iban,
            'balance' => $balance,
        ]);
        $user->accounts()->save($account);

        session()?->flash('message', __('Conta criada com sucesso.'));

        $this->showCreateModal = false;
        $this->reloadAccounts();
    }

    private function reloadAccounts(): void
    {
        /** @var \App\Models\User $user */
        $user = Auth::user();
        $this->accounts = $user->accounts()->latest('id')->get();
    }

    public function render(): View|Application|Factory|ViewAlias
    {
        return view('livewire.accounts-dashboard')
            ->layout('components.layouts.app', ['title' => __('Accounts')]);
    }
}
