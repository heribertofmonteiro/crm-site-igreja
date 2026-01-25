<div class="row">
    <div class="col-md-12">
        <h4>Auditoria de Tipagem de Dados</h4>

        <div class="card">
            <div class="card-body">
                @if(count($typeIssues) > 0)
                <div class="alert alert-warning">
                    <strong>Problemas de Tipagem Encontrados:</strong> Estes campos podem causar erros de arredondamento ou inconsistências.
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tabela</th>
                            <th>Coluna</th>
                            <th>Tipo Atual</th>
                            <th>Tipo Recomendado</th>
                            <th>Problema</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($typeIssues as $issue)
                        <tr>
                            <td>{{ $issue['table'] }}</td>
                            <td>{{ $issue['column'] }}</td>
                            <td><code>{{ $issue['current_type'] }}</code></td>
                            <td><code>{{ $issue['recommended_type'] }}</code></td>
                            <td>{{ $issue['issue'] }}</td>
                            <td>
                                <button class="btn btn-sm btn-primary">Gerar Migration</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Nenhum problema de tipagem encontrado.
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Regras de Tipagem</h5>
            </div>
            <div class="card-body">
                <ul>
                    <li><strong>Valores monetários:</strong> Sempre usar <code>decimal(10,2)</code> ou similar</li>
                    <li><strong>Datas:</strong> Usar <code>date</code>, <code>datetime</code> ou <code>timestamp</code></li>
                    <li><strong>IDs:</strong> Usar <code>unsignedBigInteger</code> para chaves primárias</li>
                    <li><strong>Textos curtos:</strong> <code>string</code> (VARCHAR)</li>
                    <li><strong>Textos longos:</strong> <code>text</code> ou <code>longText</code></li>
                    <li><strong>Booleanos:</strong> <code>boolean</code></li>
                </ul>
            </div>
        </div>
    </div>
</div>