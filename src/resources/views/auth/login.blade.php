@extends('auth-layouts.auth')

@section('title', trans('default.login'))
@section('contents')
    <div id="app">
        <login
               :config-data="{{ json_encode(config('settings.application')) }}"
               @if(env('MARKET_PLACE_VERSION')) :market-place-version="{{env('MARKET_PLACE_VERSION')}}" @endif
        ></login>
    </div>
    <script>
        window.localStorage.setItem('app-languages',
            JSON.stringify(
                <?php echo json_encode(include resource_path() . DIRECTORY_SEPARATOR . 'lang' . DIRECTORY_SEPARATOR . (app()->getLocale() ?? 'en') . DIRECTORY_SEPARATOR . 'default.php')?>
            )
        );
    </script>
@endsection
