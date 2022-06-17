@extends('layouts.app')

@section('title', trans('default.client_details'))

@section('contents')
    <client-details @if(isset($id)) selected-url="/clients/{{$id}}" @endif
    @if(isset($id)) client-id="{{$id}}" @endif/>
@endsection

