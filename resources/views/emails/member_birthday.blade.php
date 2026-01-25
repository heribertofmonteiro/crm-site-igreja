<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feliz Aniversário</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; }
        .header { background-color: #007bff; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { background-color: #f8f9fa; padding: 10px; text-align: center; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Feliz Aniversário, {{ $member->name }}!</h1>
        </div>
        <div class="content">
            <p>Caro(a) {{ $member->name }},</p>
            <p>Parabéns pelo seu aniversário! Que este dia seja cheio de alegria, paz e bênçãos de Deus.</p>
            <p>A igreja {{ config('app.name') }} deseja-lhe um ano novo repleto de crescimento espiritual e conquistas.</p>
            <p>Que Deus continue abençoando sua vida e sua família.</p>
            <p>Com carinho,<br>
            Equipe da {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            <p>Este é um email automático. Por favor, não responda.</p>
        </div>
    </div>
</body>
</html>