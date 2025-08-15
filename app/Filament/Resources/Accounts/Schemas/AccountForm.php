<?php

namespace App\Filament\Resources\Accounts\Schemas;

use Filament\Forms\Components\Hidden;
use Filament\Forms\Components\TextInput;
use Filament\Schemas\Schema;

class AccountForm
{
    public static function configure(Schema $schema): Schema
    {
        return $schema
            ->components([
                Hidden::make('user_id')
                    ->default(fn (): ?int => auth()->id())
                    ->dehydrated()
                    ->required(),
                TextInput::make('iban')
                    ->required(),
            ]);
    }
}
