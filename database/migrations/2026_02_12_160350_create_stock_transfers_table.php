<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        if (!Schema::hasTable('stock_transfers')) {
            Schema::create('stock_transfers', function (Blueprint $table) {
                $table->id();        

                $table->foreignId('inventory_item_id')
                    ->constrained()
                    ->cascadeOnDelete();

                $table->foreignId('from_warehouse_id')
                    ->constrained('warehouses')
                    ->cascadeOnDelete();

                $table->foreignId('to_warehouse_id')
                    ->constrained('warehouses')
                    ->cascadeOnDelete();

                $table->unsignedBigInteger('quantity');

                $table->tinyInteger('status')->default(1);

                $table->string('reference')->nullable();
                $table->text('note')->nullable();

                $table->foreignId('requested_by')->nullable()
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->foreignId('approved_by')->nullable()
                    ->constrained('users')
                    ->cascadeOnDelete();
                    
                $table->foreignId('completed_by')->nullable()
                    ->constrained('users')
                    ->cascadeOnDelete();
                    
                $table->foreignId('rejected_by')->nullable()
                    ->constrained('users')
                    ->cascadeOnDelete();
                    
                $table->foreignId('deleted_by')->nullable()
                    ->constrained('users')
                    ->cascadeOnDelete();

                $table->timestamp('requested_at')->nullable();
                $table->timestamp('approved_at')->nullable();
                $table->timestamp('completed_at')->nullable();
                $table->timestamp('rejected_at')->nullable();

                $table->timestamps();
                $table->softDeletes();

                $table->index(['inventory_item_id', 'from_warehouse_id']);
                $table->index(['inventory_item_id', 'to_warehouse_id']);
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stock_transfers');
    }
};
