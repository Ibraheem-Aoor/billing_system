<?php

use App\Models\Core\Auth\Permission;
use App\Models\Core\Auth\Type;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;


class AddRowToPermissions extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        try {
            $getPermission = Permission::select('id', 'name')->pluck('name')->toArray();
            $checkPermission = array_search('invoice_resend', $getPermission);
            if ($checkPermission == false) {
                $appId = Type::findByAlias('app')->id;
                $permissions = [

                    [
                        'name' => 'invoice_resend',
                        'type_id' => $appId,
                        'group_name' => 'invoices',
                    ],
                ];
                Permission::query()->insert($permissions);
            }
        } catch (Exception $exception) {
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
