<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Confirmação de Doação</title>
</head>
<body>
    <h1>Confirmação de Doação</h1>
    <p>Olá {{ $transaction->donor_name }},</p>
    <p>Obrigado pela sua doação à nossa igreja!</p>
    <p><strong>Detalhes da doação:</strong></p>
    <ul>
        <li>Nome: {{ $transaction->donor_name }}</li>
        <li>Email: {{ $transaction->donor_email }}</li>
        <li>Valor: R$ {{ number_format($transaction->amount, 2, ',', '.') }}</li>
        <li>Tipo: {{ $transaction->donation_type }}</li>
        <li>Método de Pagamento: {{ $transaction->payment_method }}</li>
        <li>Data: {{ $transaction->date->format('d/m/Y') }}</li>
    </ul>
    <p>Sua contribuição é muito importante para a obra de Deus. Que o Senhor abençoe abundantemente!</p>
    <p>Atenciosamente,<br>
    Equipe da Igreja</p>
</body>
</html>