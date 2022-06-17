<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateInvoicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->foreignId('client_id')->constrained('users');
            $table->foreignId('currency_id')->nullable()->constrained('currencies');
            $table->string('invoice_number')->unique();
            $table->boolean('recurring');
            $table->date('date');
            $table->date('due_date');
            $table->foreignId('status_id')->constrained();
            $table->foreignId('recurring_cycle_id')->nullable()->constrained();
            $table->double('sub_total', 16, 2);
            $table->enum('discount_type', ['none', 'fixed', 'percentage'])->default('none');
            $table->double('discount', 16, 2)->default(0);
            $table->double('total', 16, 2);
            $table->double('received_amount', 16, 2)->default(0);
            $table->double('due_amount', 16, 2);
            $table->longText('notes')->nullable();
            $table->longText('terms')->nullable();
            $table->foreignId('created_by')->constrained('users');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('invoices');
    }
}
