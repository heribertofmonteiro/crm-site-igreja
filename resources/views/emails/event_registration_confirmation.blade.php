<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Inscrição</title>
</head>
<body>
    <h1>Confirmação de Inscrição no Evento</h1>
    <p>Olá {{ $registration->name }},</p>
    <p>Obrigado por se inscrever no evento <strong>{{ $registration->event->title }}</strong>.</p>
    <p><strong>Detalhes da inscrição:</strong></p>
    <ul>
        <li>Nome: {{ $registration->name }}</li>
        <li>Email: {{ $registration->email }}</li>
        <li>Telefone: {{ $registration->phone }}</li>
        <li>Data do evento: {{ $registration->event->event_date }}</li>
        <li>Local: {{ $registration->event->location ?? 'Não informado' }}</li>
    </ul>
    <p>Se você confirmou sua participação, estamos ansiosos para vê-lo lá!</p>
    <p>Atenciosamente,<br>
    Equipe da Igreja</p>
</body>
</html>