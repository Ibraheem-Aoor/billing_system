<?php

namespace App\Models\Billar\PaymentHistory;

use App\Models\App\PaymentMethods\PaymentMethod;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Core\BaseModel;
use App\Models\Core\Traits\BootTrait;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class PaymentHistory extends BaseModel
{
    use BootTrait, SoftDeletes;

    protected $fillable = ['invoice_id', 'payment_method_id', 'received_on', 'amount', 'note', 'created_by'];

    public function paymentMethod(): BelongsTo
    {
        return $this->belongsTo(PaymentMethod::class);
    }

    public function invoice(): BelongsTo
    {
        return $this->belongsTo(Invoice::class);
    }
}
