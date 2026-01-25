<div class="row">
    <div class="col-md-12">
        <h4>Auto-Fix de Índices</h4>

        <div class="card">
            <div class="card-header">
                <h5>Sugestões de Índices</h5>
            </div>
            <div class="card-body">
                @if(count($indexSuggestions) > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tabela</th>
                            <th>Coluna</th>
                            <th>Razão</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($indexSuggestions as $suggestion)
                        <tr>
                            <td>{{ $suggestion['table'] }}</td>
                            <td>{{ $suggestion['column'] }}</td>
                            <td>{{ $suggestion['reason'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-success" onclick="applyIndex('{{ $suggestion['table'] }}', '{{ $suggestion['column'] }}')">
                                    <i class="fas fa-plus"></i> Aplicar
                                </button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    Nenhuma sugestão de índice disponível no momento.
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Índices Existentes</h5>
            </div>
            <div class="card-body">
                <p>Esta seção mostra os índices já aplicados no sistema.</p>
                <div class="alert alert-info">
                    <strong>Nota:</strong> A análise completa de índices requer acesso aos logs de queries do MySQL. Implementação simplificada mostra sugestões básicas.
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Como os Índices Melhoram a Performance</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>WHERE clauses:</strong> Índices em colunas usadas em filtros WHERE</li>
                    <li><strong>JOINs:</strong> Índices nas colunas de junção</li>
                    <li><strong>ORDER BY:</strong> Índices podem acelerar ordenação</li>
                    <li><strong>Considerações:</strong> Índices ocupam espaço em disco e podem tornar inserts/updates mais lentos</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function applyIndex(table, column) {
    if (confirm(`Aplicar índice na coluna '${column}' da tabela '${table}'?`)) {
        fetch('/admin/db-inspector/apply-index', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({ table: table, column: column })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('Índice aplicado com sucesso!');
                location.reload();
            } else {
                alert('Erro: ' + data.message);
            }
        })
        .catch(error => {
            alert('Erro na aplicação do índice: ' + error.message);
        });
    }
}
</script>