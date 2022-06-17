<?php
	
	use Illuminate\Database\Migrations\Migration;
	use Illuminate\Support\Facades\DB;
	
	class AddPurchaseCodeMoveToSettingsTable extends Migration
	{
		/**
		 * Run the migrations.
		 *
		 * @return string
		 */
		public function up()
		{
			try {
				$purchasesCode = DB::table('gain')->count();
				if ($purchasesCode > 0){
					\App\Models\Core\Setting\Setting::query()->insert([
						'name' => 'purchase_code',
						'value' => DB::table('gain')->first()->purchase_code,
						'context' => 'purchase_code'
					]);
				}
				
				
			} catch (\Exception $exception) {
				return $exception->getMessage();
			}
		}
		
		/**
		 * Reverse the migrations.
		 *
		 * @return void
		 */
		public function down()
		{
		
		}
	}
