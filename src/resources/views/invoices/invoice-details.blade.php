@extends('layouts.app')

@section('title', trans('default.invoice_details'))

@section('contents')
    <invoice-details @if(isset($id)) selected-url="/invoices/{{$id}}"
                     :config-data="{{ json_encode(config('settings.application')) }}
                             "@endif/>
@endsection

