<?php

namespace App\Http\Controllers\Billar\Setting;

use App\Exceptions\GeneralException;
use App\Http\Controllers\Controller;
use App\Models\Billar\Invoice\Invoice;
use App\Notifications\Core\Settings\SettingsNotification;
use App\Services\Core\Setting\SettingService;
use Illuminate\Http\Request;

class InvoiceSettingController extends Controller
{
    public function __construct(SettingService $service)
    {
        $this->service = $service;
    }

    public function setting(Request $request)
    {
        validator($request->all(), [
            'invoice_logo' => 'required|image|mimes:jpg,png,jpeg,gif,svg|max:2048',
            'invoice_starting_number' => 'required|int',
        ])->validate();


        $check = Invoice::count();

        if ($check > 0) {
            return response()->json([
                'status' => false,
                'message' => __t('invoice_number_already_in_use_but_others_settings_saved_successfully')
            ], 200);
        }

        $trashInvoiceCheck = Invoice::onlyTrashed()->count();
        if ($trashInvoiceCheck > 0) {
            return response()->json([
                'status' => false,
                'message' => __t('invoice_number_previously_used')
            ], 200);
        }


        $this->service->update();

        notify()
            ->on('settings_updated')
            ->with(trans('default.general_settings'))
            ->send(SettingsNotification::class);

        return updated_responses('settings', [
            'settings' => $this->service->getFormattedSettings()
        ]);

    }
}
