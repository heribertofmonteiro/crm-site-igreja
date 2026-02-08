<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Acesso Negado - {{ config('app.name', 'Sistema de Gestão Eclesiástica') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        .error-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        .error-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 60px rgba(0,0,0,0.3);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }
        .error-icon {
            font-size: 5rem;
            color: #dc3545;
            margin-bottom: 1rem;
        }
        .error-code {
            font-size: 6rem;
            font-weight: 700;
            color: #dc3545;
            line-height: 1;
            margin-bottom: 0.5rem;
        }
        .error-title {
            font-size: 1.5rem;
            font-weight: 600;
            color: #333;
            margin-bottom: 1rem;
        }
        .error-message {
            color: #666;
            margin-bottom: 2rem;
            line-height: 1.6;
        }
        .btn-home {
            display: inline-block;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            transition: transform 0.2s, box-shadow 0.2s;
        }
        .btn-home:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 30px rgba(102, 126, 234, 0.4);
            color: white;
        }
        .btn-back {
            display: inline-block;
            background: #f8f9fa;
            color: #666;
            padding: 0.75rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 500;
            margin-left: 0.5rem;
            transition: background 0.2s;
        }
        .btn-back:hover {
            background: #e9ecef;
            color: #333;
        }
    </style>
</head>
<body>
    <div class="error-container">
        <div class="error-card">
            <div class="error-icon">
                <i class="fas fa-lock"></i> 🔒
            </div>
            <div class="error-code">403</div>
            <h1 class="error-title">Acesso Negado</h1>
            <p class="error-message">
                {{ $exception->getMessage() ?: 'Você não possui as permissões necessárias para acessar este recurso.' }}
            </p>
            <div>
                <a href="{{ route('dashboard') }}" class="btn-home">
                    <i class="fas fa-home"></i> Voltar ao Dashboard
                </a>
                <a href="javascript:history.back()" class="btn-back">
                    <i class="fas fa-arrow-left"></i> Voltar
                </a>
            </div>
            @if(app()->environment('local', 'development'))
                <div style="margin-top: 2rem; padding-top: 2rem; border-top: 1px solid #eee; text-align: left;">
                    <p style="font-size: 0.875rem; color: #999; margin-bottom: 0.5rem;"><strong>Debug Info:</strong></p>
                    <p style="font-size: 0.75rem; color: #666; font-family: monospace;">
                        User: {{ auth()->user()?->name ?? 'Guest' }}<br>
                        Route: {{ request()->route()?->getName() ?? 'N/A' }}<br>
                        URL: {{ request()->url() }}
                    </p>
                </div>
            @endif
        </div>
    </div>
</body>
</html>
