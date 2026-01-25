<div class="row">
    <div class="col-md-12">
        <h4>Simulador de Carga</h4>

        <div class="card">
            <div class="card-header">
                <h5>Teste de Performance com Múltiplos Registros</h5>
            </div>
            <div class="card-body">
                <form id="load-test-form">
                    <div class="form-group">
                        <label for="num_records">Número de Registros para Inserir:</label>
                        <input type="number" class="form-control" id="num_records" name="num_records" value="1000" min="100" max="10000">
                    </div>
                    <button type="button" class="btn btn-primary" onclick="runLoadTest()">Executar Teste de Carga</button>
                </form>
            </div>
        </div>

        <div class="card mt-3" id="results-card" style="display: none;">
            <div class="card-header">
                <h5>Resultados do Teste</h5>
            </div>
            <div class="card-body">
                <div id="results-content">
                    <!-- Resultados serão inseridos aqui via AJAX -->
                </div>
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Avisos Importantes</h5>
            </div>
            <div class="card-body">
                <div class="alert alert-warning">
                    <strong>Atenção:</strong> Este teste irá inserir registros reais no banco de dados. Em produção, considere usar um ambiente de teste separado.
                </div>
                <ul>
                    <li>Os registros inseridos terão dados fictícios</li>
                    <li>O teste mede apenas o tempo de inserção em lote</li>
                    <li>Considere o impacto no banco de dados antes de executar</li>
                    <li>Para limpeza, você pode usar migrations ou comandos manuais</li>
                </ul>
            </div>
        </div>
    </div>
</div>

<script>
function runLoadTest() {
    const numRecords = document.getElementById('num_records').value;
    const button = event.target;
    const originalText = button.innerHTML;

    button.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Executando...';
    button.disabled = true;

    fetch('/admin/db-inspector/run-load-simulation', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
        },
        body: JSON.stringify({ num_records: numRecords })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            document.getElementById('results-content').innerHTML = `
                <div class="alert alert-success">
                    <h6>Teste concluído com sucesso!</h6>
                    <ul>
                        <li><strong>Registros inseridos:</strong> ${data.records_inserted}</li>
                        <li><strong>Tempo de execução:</strong> ${data.execution_time.toFixed(2)} segundos</li>
                        <li><strong>Registros por segundo:</strong> ${(data.records_inserted / data.execution_time).toFixed(2)}</li>
                    </ul>
                </div>
            `;
            document.getElementById('results-card').style.display = 'block';
        } else {
            alert('Erro: ' + data.message);
        }
    })
    .catch(error => {
        alert('Erro na execução do teste: ' + error.message);
    })
    .finally(() => {
        button.innerHTML = originalText;
        button.disabled = false;
    });
}
</script>