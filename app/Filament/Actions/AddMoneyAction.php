<?php

declare(strict_types=1);

namespace App\Filament\Actions;

use App\Enum\Status;
use App\Models\Account;
use Filament\Actions\Action;
use Filament\Forms\Components\TextInput;

/**
 * Record action to add money to the specific account row.
 */
class AddMoneyAction extends Action
{
    public static function make(?string $name = null): static
    {
        $action = parent::make($name ?? 'addMoney');

        $action
            ->label('Add Money')
            ->modalHeading('Add Money')
            ->icon('heroicon-o-banknotes')
            ->visible(fn (Account $record): bool => $record->status !== 'Inactive')
            ->schema([
                TextInput::make('amount')
                    ->label('Amount')
                    ->required()
                    ->numeric()
                    ->minValue(0.01)
                    ->step('0.01')
                    ->rule('decimal:0,2'),
            ])
            ->action(function (Account $record, array $data): void {
                $amount = (float) ($data['amount'] ?? 0);

                if ($amount <= 0) {
                    return;
                }

                $newBalance = (float) $record->getRawOriginal('balance') + $amount;

                $attributes = [
                    'balance' => number_format($newBalance, 2, '.', ''),
                ];

                // If blocked, activate the account upon adding money
                if ($record->getRawOriginal('status') === Status::Blocked->value) {
                    $attributes['status'] = Status::Active->value;
                }

                $record->update($attributes);
            });

        return $action;
    }
}
