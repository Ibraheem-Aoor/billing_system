<?php

namespace App\Http\Controllers\Billar\PaymentHistory;

use App\Http\Controllers\Controller;
use App\Models\Billar\Invoice\Invoice;
use App\Services\Billar\PaymentHistory\InvoicePaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use PayPal\Api\Item;
use PayPal\Api\ItemList;
use PayPal\Api\Transaction;

class PaypalController extends Controller
{
    public function __construct(InvoicePaymentService $service)
    {
        $this->service = $service;
    }

    public function create(Invoice $invoice)
    {

        $payer = $this->service->payer();

        list($item) = $this->item($invoice);

        $itemList = new ItemList();
        $itemList->setItems(array($item));

       // $details = $this->service->details($invoice);

        $amount = $this->service->amount($invoice->due_amount);
        Session::put('amount', $amount);
        $transaction = $this->service->transaction($amount, $itemList);


        $redirectUrls = $this->service->redirectUrls();

        $payment = $this->service->payment($payer, $redirectUrls, $transaction);

        $payment->create($this->service->apiContext);

        return redirect($payment->getApprovalLink());
    }

    public function execute()
    {

        $payment = $this->service->getThePayment();

        $execution = $this->service->createExtracted();

        $transaction = new Transaction();

        //$details = $this->service->details();

        $amount = $this->service->amount(Session::get('amount'));

        $transaction->setAmount($amount);

        $execution->addTransaction($transaction);
        $result = $payment->execute($execution, $this->service->apiContext);
        return redirect(config('app.url') . '/invoices/list/view')
            ->with('message', 'Payment successfully');
    }


    public function item($invoice)
    {
        $all_items_arr = [];
        foreach ($invoice->invoiceDetails as $dataItem) {
            $item = new Item();

            $item->setName($dataItem->product['name'])
                ->setCurrency('USD')
                ->setQuantity($dataItem['quantity'])
                ->setPrice($dataItem['price']);
            $all_items_arr[] = $item;
        }


        return array($all_items_arr);
    }
}
