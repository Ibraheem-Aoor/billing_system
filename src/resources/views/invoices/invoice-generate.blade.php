<!Doctype html>
<html>
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>{{ config('app.name') }}</title>
    <link rel="shortcut icon" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
    <link rel="apple-touch-icon" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>
    <link rel="apple-touch-icon-precomposed" href="{{ env('APP_URL').config('settings.application.company_icon') }}"/>

    <style>
        /* dev */
        .t {
            border: 1px solid red;
        }

        .bg-t {
            background-color: #00660050;
        }

        .bg-dark {
            background-color: #333333 !important;
        }

        .bg-secondary {
            background-color: #dddddd !important;
        }

        .bg-transparent {
            background-color: transparent !important;
        }

        /* * {
            font-family: Arial;
            margin: 0;
            padding: 0;
        } */

        /*common*/
        .m-0 {
            margin: 0;
        }

        .m-1 {
            margin: 5px;
        }

        .m-2 {
            margin: 10px;
        }

        .m-3 {
            margin: 15px;
        }

        .m-4 {
            margin: 20px;
        }

        .m-5 {
            margin: 25px;
        }

        .mx-1 {
            margin: 0 5px;
        }

        .mx-2 {
            margin: 0 10px;
        }

        .mx-3 {
            margin: 0 15px;
        }

        .mx-4 {
            margin: 0 20px;
        }

        .mx-5 {
            margin: 0 25px;
        }

        .my-1 {
            margin: 5px 0;
        }

        .my-2 {
            margin: 10px 0;
        }

        .my-3 {
            margin: 15px 0;
        }

        .my-4 {
            margin: 20px 0;
        }

        .my-5 {
            margin: 25px 0;
        }

        .mt-1 {
            margin-top: 5px
        }

        .mt-2 {
            margin-top: 10px
        }

        .mt-3 {
            margin-top: 15px
        }

        .mt-4 {
            margin-top: 20px
        }

        .mt-5 {
            margin-top: 25px
        }

        .mb-1 {
            margin-bottom: 5px
        }

        .mb-2 {
            margin-bottom: 10px
        }

        .mb-3 {
            margin-bottom: 15px
        }

        .mb-4 {
            margin-bottom: 20px
        }

        .mb-5 {
            margin-bottom: 25px
        }

        .p-0 {
            padding: 0;
        }

        .p-1 {
            padding: 5px;
        }

        .p-2 {
            padding: 10px;
        }

        .p-3 {
            padding: 15px;
        }

        .p-4 {
            padding: 20px;
        }

        .p-5 {
            padding: 25px;
        }

        .px-1 {
            padding: 0 5px;
        }

        .px-2 {
            padding: 0 10px;
        }

        .px-3 {
            padding: 0 15px;
        }

        .px-4 {
            padding: 0 20px;
        }

        .px-5 {
            padding: 0 25px;
        }

        .py-1 {
            padding: 5px 0;
        }

        .py-2 {
            padding: 10px 0;
        }

        .py-3 {
            padding: 15px 0;
        }

        .py-4 {
            padding: 20px 0;
        }

        .py-5 {
            padding: 25px 0;
        }

        .w-10 {
            width: 10%;
        }

        .w-15 {
            width: 15%;
        }

        .w-45 {
            width: 45%;
        }

        .w-25 {
            width: 25%;
        }

        .w-50 {
            width: 50%;
        }

        .w-75 {
            width: 75%;
        }

        .w-100 {
            width: 100%;
        }

        .h-100 {
            height: 100%;
        }

        .f-left {
            float: left;
        }

        .f-right {
            float: right;
        }

        .f-clear {
            clear: both;
        }

        .text-left {
            text-align: left;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-secondary {
            color: #666666;
        }

        .text-light {
            color: #fff;
        }

        .text-black {
            color: #000;
        }

        .text-capital {
            text-transform: uppercase;
        }

        .thin {
            font-weight: lighter;
        }

        .bold {
            font-weight: bold;
        }

        .font-xm {
            font-size: x-small
        }

        .font-md {
            font-size: medium
        }

        .font-lg {
            font-size: large
        }

        .table-strip {
        }

        .table-strip tr:nth-child(even) {
            background-color: #f8f8f8;
        }

        /*layout*/
        .invoice_container {
        }

        .invoice_container * {
            box-sizing: content-box;
        }

        .invoice_container__item {

        }

        .logo {
            width: 96px;
        }

        .hr {
            background-color: #999999;
            border: none;
            height: 1px;
        }

    </style>
</head>

<body>
<div class="invoice_container">
    <div class="invoice_container__item px-5 mt-5 text-black">
        <div class="w-25 f-left p-2">
            <div>
                <img class="logo" src="{{ env('APP_URL').config('settings.application.invoice_logo')}}" alt="NF">
            </div>
        </div>
        <div class="w-50 f-right text-right">
            <h1 class="bold text-black text-capital">Invoice</h1>
            <table class="f-right w-75 font-xm mt-3">
                <tr>
                    <td class="bold">{{__t('invoice_no')}}</td>
                    <td>:</td>
                    <td class="text-right">{{$invoice->invoice_number}}</td>
                </tr>
                <tr>
                    <td class="bold">{{__t('date')}}</td>
                    <td>:</td>
                    <td class="text-right">{{$invoice->date}}</td>
                </tr>
                <tr>
                    <td class="bold">{{__t('due_date')}}</td>
                    <td>:</td>
                    <td class="text-right">{{$invoice->due_date}}</td>
                </tr>
            </table>
            <div class="f-clear"></div>
        </div>
        <div class="f-clear"></div>
    </div>
    {{--        <hr class="hr">--}}
    <div class="invoice_container__item p-5 text-black">
        <div class="w-50 f-left font-xm">
            <p class="bold">{{__t('from')}}</p>
            @if($invoice->createdBy)
                <p>{{$invoice->createdBy->full_name}}</p>
                @if($invoice->createdBy->profile)
                    <small>{{__t('contact')}}: {{$invoice->createdBy->profile->contact}}</small>
                    <br>
                    <small>{{__t('address')}}: {{$invoice->createdBy->profile->address}}</small>
                @endif
            @endif
        </div>
        <div class="w-50 f-right font-xm">
            <div class="w-75 f-right">
                <p class="bold">{{__t('to')}}</p>
                @if($invoice->client)
                    <p>{{$invoice->client->full_name}}</p>
                    @if($invoice->client->profile)
                        <small>{{__t('contact')}}: {{$invoice->client->profile->contact}}</small>
                        <br>
                        <small>{{__t('address')}}: {{$invoice->client->profile->address}}</small>
                    @endif
                @endif
            </div>
            <div class="f-clear"></div>
        </div>
        <div class="f-clear"></div>
    </div>
    {{--    <hr class="hr">--}}
    <div class="invoice_container__item px-5">
        <table class="w-100 font-xm table-strip" border="0" cellspacing="0" cellpadding="0">
            <thead>
            <tr class="bg-dark text-light">
                <th class="w-45 p-1 text-left">{{__t('product')}}</th>
                <th class="w-10 p-1 text-right">{{__t('quantity')}}</th>
                <th class="w-15 p-1 text-right">{{__t('unit_price')}}</th>
                <th class="w-15 p-1 text-right">{{__t('tax')}} </th>
                <th class="w-15 p-1 text-right">{{__t('total')}}</th>
            </tr>
            </thead>
            <tbody>
            @foreach($invoice->invoiceDetails as $item)
                <tr>
                    @if($item->product)
                        <td class="p-1">{{$item->product->name}}</td>
                    @endif
                    <td class="p-1 text-right">{{$item->quantity}}</td>
                    <td class="p-1 text-right">{{number_with_currency_symbol($item->price)}}</td>
                    <td class="p-1 text-right">
                        @if($item->tax)
                            {{$item->tax->value . '%'}}
                        @else
                            <span>N/A</span>
                        @endif
                    </td>
                    <td class="p-1 text-right">
                        {{number_with_currency_symbol(
                        (($item->quantity * $item->price)+($item->quantity * $item->price) * ($item->tax ? ($item->tax->value /100) : 0 ))
                        )}}
                    </td>
                </tr>
            @endforeach
            <tr class="bg-transparent text-black">
                <td colspan="5">
                    <div class="hr mt-2"></div>
                </td>
            </tr>
            <tr class="bg-transparent text-black">
                <td colspan="2"></td>
                <td colspan="2" class="bold p-1">{{__t('sub_total')}} :</td>
                <td class="text-right p-1">{{number_with_currency_symbol($invoice->sub_total)}}</td>
            </tr>
            <tr class="bg-transparent text-black">
                <td colspan="2"></td>
                <td colspan="2" class="bold p-1">{{__t('tax')}} :</td>
                <td class="text-right p-1">{{number_with_currency_symbol($invoice->totalTax)}}</td>
            </tr>
            <tr class="bg-transparent text-black">
                <td colspan="2"></td>
                <td colspan="2" class="bold p-1">{{__t('discount')}} :</td>
                @if($invoice->discount_type == 'percentage')
                    <td class="text-right p-1">{{$invoice->discount}} %</td>
                @else
                    <td class="text-right p-1">{{number_with_currency_symbol($invoice->discount)}}</td>
                @endif
            </tr>
            <tr class="bg-transparent text-black">
                <td colspan="2"></td>
                <td colspan="2" class="bold p-1">{{__t('total')}} :</td>
                <td class="text-right p-1">{{number_with_currency_symbol($invoice->total)}}</td>
            </tr>
            <tr class="bg-transparent text-black">
                <td colspan="2"></td>
                <td colspan="2" class="bold p-1">{{__t('paid')}} :</td>
                <td colspan="2" class="text-right p-1">{{number_with_currency_symbol($invoice->received_amount)}}</td>
            </tr>
            <tr>
                <td colspan="2" class="bg-transparent"></td>
                <td colspan="3" class="bg-transparent">
                    <div class="hr mt-2"></div>
                </td>
            </tr>
            <tr class="bg-transparent bold text-black">
                <td colspan="2"></td>
                <td colspan="2" class="p-1">{{__t('due_amount')}} :</td>
                <td class="text-right p-1">{{number_with_currency_symbol($invoice->due_amount)}}</td>
            </tr>
            </tbody>
        </table>
    </div>
</div>

<div class="invoice_container__item p-5 font-xm">
    <div>
        @if($invoice->notes)
            <div class="bold">{{__t('notes')}}</div>
            <p>{!! $invoice->notes !!}</p>
        @endif

        @if($invoice->terms)
            <div class="bold mt-3">{{__t('terms')}}</div>
            <p>{!! $invoice->terms !!}</p>
        @endif
    </div>
</div>
</body>
