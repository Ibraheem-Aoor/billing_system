<?php


namespace App\Services\Billar\Invoice;


use App\Helpers\Core\Traits\HasWhen;
use App\Models\Billar\Invoice\Invoice;
use App\Models\Billar\Invoice\InvoiceDetail;
use App\Services\Billar\ApplicationBaseService;
use Illuminate\Support\Facades\Storage;
use PDF;

class InvoiceService extends ApplicationBaseService
{
    use HasWhen;

    public function __construct(Invoice $invoice)
    {
        $this->model = $invoice;
    }

    public function individualClient(): self
    {
        $this->builder->when(!auth()->user()->isAppAdmin(), function ($query) {
            $query->where('client_id', auth()->id());
        });
        return $this;
    }

    public function setValidation(): self
    {
        $id = $this->model->id ?: '';
        validator(request()->all(), [
            'client_id' => 'required|max:191',
            'invoice_number' => 'required|unique:invoices,invoice_number,' . $id,
            'recurring' => 'required',
            'date' => 'required|date',
            'due_date' => 'required|date',
            'status_id' => 'required',
            'recurring_cycle_id' => 'required_if:recurring, ==, 1',
            'products.*.product_id' => 'required',
            'products.*.quantity' => 'required',
            'products.*.price' => 'required',
            'products.*.amount' => 'required',
            'sub_total' => 'required',
            'total' => 'required',
        ], [
            'client_id.required' => 'The client field is required.',
            'status_id.required' => 'The status field is required.',
            'recurring_cycle_id.required_if' => 'The recurring cycle field is required.',
            'products.*.product_id.required' => 'The product field is required.',
            'products.*.quantity.required' => 'The quantity field is required.',
            'products.*.price.required' => 'The price field is required.',
            'products.*.amount.required' => 'The amount field is required.',

        ])->validate();

        return $this;
    }

    /**
     * @throws \Illuminate\Validation\ValidationException
     */
    public function setSendInvoiceValidation(): self
    {
        validator(request()->all(), [
            'email' => 'required|email',
            'subject' => 'required',
            'message' => 'required',
        ])->validate();

        return $this;
    }

    public function invoiceDetails(): self
    {
        if (request()->products) {
            foreach (request()->products as $item) {
                if (collect($item)->has('id')) {
                    InvoiceDetail::where('id', $item['id'])->update([
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'tax_id' => $item['tax_id'],
                    ]);
                } else {
                    InvoiceDetail::create([
                        'invoice_id' => $this->model->id,
                        'product_id' => $item['product_id'],
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'tax_id' => $item['tax_id'],
                    ]);
                }
            }
        }

        return $this;
    }

    public function loadInvoiceInfo($invoice)
    {
        $invoiceInfo = $invoice->load(['invoiceDetails' => function ($query) {
            $query->with('product:id,name', 'tax:id,name,value');
        }, 'client:id,first_name,last_name,email', 'createdBy:id,first_name,last_name']);

        $invoiceInfo->totalTax = $invoiceInfo->invoiceDetails->map(function ($item) {
            $tax = $item->load('tax')->tax ? $item->load('tax')->tax->value : 0;
            return $this->productTaxSum($item->quantity, $item->price, $tax);
        })->sum();

        return $invoiceInfo;

    }

    public function pdfGenerate($invoiceInfo): self
    {
        $pdf = PDF::loadView('invoices.invoice-generate', [
            'invoice' => $invoiceInfo
        ]);

        $output = $pdf->output();
        $filePath = $this->getAttribute('file_path');
        Storage::put($filePath, $output);
        return $this;
    }

    public function tags($invoice, $message): string
    {
        $data = [
            '{invoice_number}' => $invoice['invoice_number'],
            '{invoice_amount}' => $invoice['total'],
            '{invoice_logo}' => '<img src= "' . asset(config('settings.application.invoice_logo')) . '"/>',
            '{client_name}' => $invoice['client']['full_name'],
            '{client_email}' => $invoice['client']['email'],
            '{company_name}' => config('app.name'),
            '{login_link}' => '<a href="' . url('/') . '"> Click Here </a>',
        ];

        return $this->tagsReplace($data, $message);
    }

    private function tagsReplace($data, $message): string
    {
        return strtr($message, $data);
    }


    public function productTaxSum($quantity, $price, $taxValue)
    {
        return (($quantity * $price) * ($taxValue / 100));
    }

}