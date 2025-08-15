<?php

use App\Models\Account;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('transactions', function (Blueprint $table): void {
            $table->id();
            $table->foreignIdFor(Account::class)->constrained('accounts')->cascadeOnDelete();
            $table->enum('type', ['deposit', 'withdraw', 'transfer']);
            $table->decimal('amount', 15);
            $table->enum('status', ['pending', 'completed', 'failed'])->default('pending');
            $table->string('related_iban')->nullable();
            $table->timestamps();

            $table->index(['account_id', 'type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('transactions');
    }
};
