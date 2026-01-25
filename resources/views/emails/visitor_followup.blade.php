<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bem-vindo</title>
    <style>
        body { font-family: Arial, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 0 auto; background-color: #ffffff; padding: 20px; }
        .header { background-color: #28a745; color: #ffffff; padding: 20px; text-align: center; }
        .content { padding: 20px; }
        .footer { background-color: #f8f9fa; padding: 10px; text-align: center; font-size: 12px; color: #6c757d; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Bem-vindo à {{ config('app.name') }}, {{ $member->name }}!</h1>
        </div>
        <div class="content">
            <p>Olá {{ $member->name }},</p>
            <p>Foi um prazer recebê-lo(a) em nossa igreja. Esperamos que tenha se sentido bem-vindo e que tenha experimentado a presença de Deus.</p>
            <p>Gostaríamos de convidá-lo(a) para voltar e conhecer mais sobre nossa comunidade. Temos diversos ministérios e grupos onde você pode se envolver.</p>
            <p>Se tiver alguma dúvida ou precisar de mais informações, não hesite em nos contatar.</p>
            <p>Que Deus continue abençoando sua vida!</p>
            <p>Com carinho,<br>
            Equipe da {{ config('app.name') }}</p>
        </div>
        <div class="footer">
            <p>Este é um email automático. Por favor, não responda.</p>
        </div>
    </div>
</body>
</html>