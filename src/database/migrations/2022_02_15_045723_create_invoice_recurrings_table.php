<?php
  
  use Illuminate\Database\Migrations\Migration;
  use Illuminate\Database\Schema\Blueprint;
  use Illuminate\Support\Facades\Schema;
  
  class CreateInvoiceRecurringsTable extends Migration
  {
	/**
	 * Run the migrations.
	 *
	 * @return void
	 */
	public function up()
	{
	  Schema::create('invoice_recurrings', function (Blueprint $table) {
		$table->id();
		$table->foreignId('invoice_id')->constrained()->cascadeOnDelete();
		$table->foreignId('referance_invoice_id')->constrained('invoices')->cascadeOnDelete();
		$table->date('recurring_date');
	  });
	}
	
	/**
	 * Reverse the migrations.
	 *
	 * @return void
	 */
	public function down()
	{
	  Schema::dropIfExists('invoice_recurrings');
	}
  }
