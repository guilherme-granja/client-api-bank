<div class="flex flex-col gap-4">
    @if (session('message'))
        <flux:callout icon="check-circle-2" variant="success">{{ session('message') }}</flux:callout>
    @endif

    <div class="flex items-center justify-between">
        <h1 class="text-xl font-semibold">{{ __('Minhas Contas') }}</h1>
        <flux:button icon="plus" variant="primary" wire:click="openCreate">{{ __('Adicionar conta') }}</flux:button>
    </div>

    <div class="overflow-hidden rounded-xl border border-neutral-200 dark:border-neutral-700">
        <table class="w-full text-sm">
            <thead class="bg-neutral-100/60 dark:bg-neutral-800/60">
                <tr>
                    <th class="px-4 py-3 text-left">{{ __('IBAN') }}</th>
                    <th class="px-4 py-3 text-left">{{ __('Saldo') }}</th>
                    <th class="px-4 py-3 text-left">{{ __('Ações') }}</th>
                </tr>
            </thead>
            <tbody>
                @forelse($accounts as $account)
                    <tr class="border-t border-neutral-200 dark:border-neutral-700">
                        <td class="px-4 py-3">
                            <a class="text-blue-600 hover:underline" href="{{ route('accounts.show', $account) }}" wire:navigate>
                                {{ $account->iban }}
                            </a>
                        </td>
                        <td class="px-4 py-3">{{ number_format((float) $account->balance, 2, ',', '.') }}</td>
                        <td class="px-4 py-3">
                            <a class="text-blue-600 hover:underline" href="{{ route('accounts.show', $account) }}" wire:navigate>{{ __('Abrir') }}</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="px-4 py-6 text-center text-neutral-500">{{ __('Nenhuma conta criada ainda.') }}</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <flux:modal wire:model="showCreateModal">
        <x-slot name="title">{{ __('Criar conta') }}</x-slot>
        <x-slot name="description">{{ __('Preencha os campos para criar uma nova conta.') }}</x-slot>

        <div class="space-y-4">
            <flux:field>
                <flux:label>{{ __('IBAN') }}</flux:label>
                <flux:input wire:model.live="form.iban"/>
                @error('form.iban') <flux:text variant="danger">{{ $message }}</flux:text> @enderror
            </flux:field>

            <flux:field>
                <flux:label>{{ __('Saldo inicial') }}</flux:label>
                <flux:input type="number" step="0.01" min="0" wire:model.live="form.balance"/>
                @error('form.balance') <flux:text variant="danger">{{ $message }}</flux:text> @enderror
            </flux:field>
        </div>

        <x-slot name="actions">
            <flux:button variant="ghost" wire:click="$set('showCreateModal', false)">{{ __('Cancelar') }}</flux:button>
            <flux:button variant="primary" wire:click="create" wire:loading.attr="disabled">
                <span wire:loading.remove>{{ __('Criar') }}</span>
                <span wire:loading>{{ __('A criar...') }}</span>
            </flux:button>
        </x-slot>
    </flux:modal>
</div>
