<?php

namespace Database\Seeders\App;

use App\Models\Core\Auth\Type;
use App\Models\Core\Setting\NotificationEvent;
use Database\Seeders\Traits\DisableForeignKeys;
use Illuminate\Database\Seeder;

class NotificationEventTableSeeder extends Seeder
{
    use DisableForeignKeys;

    /**
     * Run the database seeders.
     *
     * @return void
     */
    public function run()
    {
        $this->disableForeignKeys();
        $appTypeId = Type::findByAlias('app')->id;
        $events = [
            [
                'name' => 'user_invitation',
                'type_id' => $appTypeId,
            ],
            [
                'name' => 'password_reset',
                'type_id' => $appTypeId,
            ],
            [
                'name' => 'client_credential',
                'type_id' => $appTypeId,
            ],
            [
                'name' => 'invoice_sending_attachment',
                'type_id' => $appTypeId,
            ],
            [
                'name' => 'invoice_payment_reminder',
                'type_id' => $appTypeId,
            ],
            [
                'name' => 'user_joined',
                'type_id' => $appTypeId,
            ],

            //role
            [
                'name' => 'roles_created',
                'type_id' => $appTypeId,
            ],
            [
                'name' => 'roles_updated',
                'type_id' => $appTypeId,
            ],
            [
                'name' => 'roles_deleted',
                'type_id' => $appTypeId,
            ],
            //Invoice
//            [
//                'name' => 'invoice_created',
//                'type_id' => $appTypeId,
//            ],
//            [
//                'name' => 'invoice_updated',
//                'type_id' => $appTypeId,
//            ],
//            [
//                'name' => 'invoice_deleted',
//                'type_id' => $appTypeId,
//            ],

        ];
        NotificationEvent::query()->truncate();
        NotificationEvent::query()->insert($events);
        $this->enableForeignKeys();
    }
}
