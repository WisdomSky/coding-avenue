<!DOCTYPE html>
<html lang="{{ config('app.locale') }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="app-fallback-locale" content="{{ config('app.fallback_locale') }}">
    <meta name="base-url" content="{{ URL::to('/') }}">
    <meta name="g-client-id" content="{{ env('GOOGLE_CLIENT_ID') }}">

    <title>{{ config('app.name', 'Coding Avenue') }}</title>
    <link href="{{ mix('css/app.css') }}" rel="stylesheet">
</head>
<body>

    <div id="app">
        <auth-state :data="{{ json_encode($auth_user) }}" ></auth-state>
        <app></app>
    </div>

    <script src="{{ mix('js/app.js') }}"></script>
</body>
</html>
