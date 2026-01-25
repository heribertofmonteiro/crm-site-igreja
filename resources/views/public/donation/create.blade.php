<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Doação Online</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3>Doação Online</h3>
                    </div>
                    <div class="card-body">
                        <p>Contribua com a obra de Deus através de sua doação. Sua generosidade faz a diferença!</p>

                        @if(session('success'))
                            <div class="alert alert-success">
                                {{ session('success') }}
                            </div>
                        @endif

                        @if($errors->any())
                            <div class="alert alert-danger">
                                <ul class="mb-0">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif

                        <form action="{{ route('donation.store') }}" method="POST">
                            @csrf
                            <div class="mb-3">
                                <label for="donor_name" class="form-label">Nome Completo</label>
                                <input type="text" class="form-control" id="donor_name" name="donor_name" required>
                            </div>
                            <div class="mb-3">
                                <label for="donor_email" class="form-label">Email</label>
                                <input type="email" class="form-control" id="donor_email" name="donor_email" required>
                            </div>
                            <div class="mb-3">
                                <label for="amount" class="form-label">Valor da Doação (R$)</label>
                                <input type="number" step="0.01" min="0.01" class="form-control" id="amount" name="amount" required>
                            </div>
                            <div class="mb-3">
                                <label for="donation_type" class="form-label">Tipo de Doação</label>
                                <select class="form-control" id="donation_type" name="donation_type" required>
                                    <option value="">Selecione</option>
                                    <option value="dízimo">Dízimo</option>
                                    <option value="oferta">Oferta</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="payment_method" class="form-label">Método de Pagamento</label>
                                <select class="form-control" id="payment_method" name="payment_method" required>
                                    <option value="">Selecione</option>
                                    <option value="cartão de crédito">Cartão de Crédito</option>
                                    <option value="cartão de débito">Cartão de Débito</option>
                                    <option value="transferência bancária">Transferência Bancária</option>
                                    <option value="PIX">PIX</option>
                                    <option value="dinheiro">Dinheiro</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Fazer Doação</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>