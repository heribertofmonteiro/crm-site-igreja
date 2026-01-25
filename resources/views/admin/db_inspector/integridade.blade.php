<div class="row">
    <div class="col-md-12">
        <h4>Verificação de Integridade de Dados</h4>

        <div class="card">
            <div class="card-header">
                <h5>Registros Órfãos</h5>
            </div>
            <div class="card-body">
                @if(count($orphanedRecords) > 0)
                <div class="alert alert-danger">
                    <strong>Problemas de Integridade Encontrados:</strong>
                </div>
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tabela</th>
                            <th>Problema</th>
                            <th>Quantidade</th>
                            <th>Ações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($orphanedRecords as $record)
                        <tr>
                            <td>{{ $record['table'] }}</td>
                            <td>{{ $record['issue'] }}</td>
                            <td><span class="badge badge-danger">{{ $record['count'] }}</span></td>
                            <td>
                                <button class="btn btn-sm btn-warning">Corrigir</button>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Nenhum registro órfão encontrado.
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Violações de Chaves Estrangeiras</h5>
            </div>
            <div class="card-body">
                @if(count($foreignKeyViolations) > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Tabela</th>
                            <th>Violação</th>
                            <th>Detalhes</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($foreignKeyViolations as $violation)
                        <tr>
                            <td>{{ $violation['table'] }}</td>
                            <td>{{ $violation['violation'] }}</td>
                            <td>{{ $violation['details'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> Nenhuma violação de chave estrangeira encontrada.
                </div>
                @endif
            </div>
        </div>
    </div>
</div>