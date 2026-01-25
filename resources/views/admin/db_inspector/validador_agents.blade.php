<div class="row">
    <div class="col-md-12">
        <h4>Validador de AGENTS.md</h4>

        <div class="card">
            <div class="card-body">
                <p class="mb-3">Esta ferramenta valida se as tabelas do banco de dados atendem aos requisitos definidos no documento AGENTS.md para cada agente do sistema.</p>

                @if(count($validationResults) > 0)
                <table class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th>Agente</th>
                            <th>Tabela</th>
                            <th>Status</th>
                            <th>Observações</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($validationResults as $result)
                        <tr class="{{ $result['status'] === 'MISSING' ? 'table-danger' : 'table-success' }}">
                            <td>{{ $result['agent'] }}</td>
                            <td>{{ $result['table'] }}</td>
                            <td>
                                @if($result['status'] === 'OK')
                                <span class="badge badge-success"><i class="fas fa-check"></i> OK</span>
                                @else
                                <span class="badge badge-danger"><i class="fas fa-times"></i> FALTANDO</span>
                                @endif
                            </td>
                            <td>
                                @if($result['status'] === 'MISSING')
                                Tabela não encontrada no banco de dados
                                @else
                                Tabela existe e está acessível
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                @else
                <div class="alert alert-info">
                    Nenhum resultado de validação disponível.
                </div>
                @endif
            </div>
        </div>

        <div class="card mt-3">
            <div class="card-header">
                <h5>Resumo da Validação</h5>
            </div>
            <div class="card-body">
                @php
                $total = count($validationResults);
                $ok = count(array_filter($validationResults, fn($r) => $r['status'] === 'OK'));
                $missing = $total - $ok;
                @endphp
                <div class="row">
                    <div class="col-md-4">
                        <div class="text-center">
                            <h3 class="text-success">{{ $ok }}</h3>
                            <p>Tabelas OK</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h3 class="text-danger">{{ $missing }}</h3>
                            <p>Tabelas Faltando</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="text-center">
                            <h3 class="text-info">{{ $total }}</h3>
                            <p>Total Verificado</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>