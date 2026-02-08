<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @php
        use Illuminate\Support\Facades\DB;
        $systemName = DB::table('system_settings')->where('key', 'system_name')->value('value') ?? 'Igreja On Line';
        $churchName = DB::table('system_settings')->where('key', 'church_name')->value('value') ?? '';
    @endphp
    <title>{{ $systemName }} - Nova Senha</title>

    <!-- Scripts -->
    @routes
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-black">
    <div id="reset-password-app"
         data-token="{{ $request->token ?? '' }}"
         data-email="{{ $request->email ?? '' }}"
         data-system-name="{{ $systemName }}"
         data-church-name="{{ $churchName }}"
    ></div>
</body>
</html>
