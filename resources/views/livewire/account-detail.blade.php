<div class="p-4">
    <h1 class="text-xl font-bold mb-4">Conta: {{ $account->iban }}</h1>
    <p class="mb-4">Saldo: {{ number_format($account->balance, 2) }} {{ $account->currency }}</p>

    @if(session()->has('message'))
        <div class="text-green-500">{{ session('message') }}</div>
    @endif

    @if(session()->has('error'))
        <div class="text-red-500">{{ session('error') }}</div>
    @endif

    <div class="mb-4">
        <input type="number" wire:model="amount" placeholder="Valor" class="border px-2 py-1 mr-2">
        <button wire:click="deposit" class="bg-green-500 text-white px-2 py-1">Depositar</button>
        <button wire:click="withdraw" class="bg-yellow-500 text-white px-2 py-1">Sacar</button>
    </div>

    <div>
        <input type="text" wire:model="targetIban" placeholder="IBAN destino" class="border px-2 py-1 mr-2">
        <button wire:click="transfer" class="bg-blue-500 text-white px-2 py-1">Transferir</button>
    </div>
</div>
