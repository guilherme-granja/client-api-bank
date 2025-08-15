<?php

namespace App\Filament\Resources\Accounts\Tables;

use App\Filament\Actions\AddMoneyAction;
use Filament\Support\Colors\Color;
use Filament\Tables\Columns\TextColumn;
use Filament\Tables\Table;

class AccountsTable
{
    public static function configure(Table $table): Table
    {
        return $table
            ->columns([
                TextColumn::make('iban')
                    ->searchable(),
                TextColumn::make('balance')
                    ->numeric()
                    ->sortable()
                    ->money('EUR'),
                TextColumn::make('status')
                    ->searchable()
                    ->badge()
                    ->color(fn (string $state): array => match ($state) {
                        'Active' => Color::Green,
                        'Blocked' => Color::Red,
                        'Inactive' => Color::Gray,
                    }),
                TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->recordActions([
                AddMoneyAction::make(),
            ]);
    }
}
